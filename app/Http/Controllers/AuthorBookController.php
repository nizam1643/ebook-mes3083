<?php

namespace App\Http\Controllers;

use App\Models\AuthorBook;
use App\Models\AuthorBookDraft;
use App\Models\AuthorTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use \CloudConvert\CloudConvert;
use \CloudConvert\Models\Job;
use \CloudConvert\Models\Task;

class AuthorBookController extends Controller
{
    public function createBook()
    {
        return view('author.book.create');
    }

    public function storeBook(Request $request)
    {
        $validated = request()->validate([
            'title' => 'required',
            'context' => 'required',
            'content' => 'nullable',
        ]);

        try {
            $storeBook = new AuthorBookDraft();
            $storeBook->user_id = auth()->user()->id;
            $storeBook->title = $request->title;
            $storeBook->context = $request->context;
            $storeBook->content = $request->content;
            $storeBook->save();

            if (!auth()->user()->authorBook) {
                $authorBook = new AuthorBook();
                $authorBook->user_id = auth()->user()->id;
                $authorBook->book_complete = 0;
                $authorBook->book_incomplete = 1;
                $authorBook->save();

                $authorTask = AuthorTask::where('user_id', auth()->user()->id)->first();
                $authorTask->task_consumed = $authorTask->task_consumed + 1;
                $authorTask->task_remaining = $authorTask->task_remaining - 1;
                $authorTask->save();
            } else {
                $authorBook = AuthorBook::where('user_id', auth()->user()->id)->first();
                $authorBook->book_incomplete = $authorBook->book_incomplete + 1;
                $authorBook->save();

                $authorTask = AuthorTask::where('user_id', auth()->user()->id)->first();
                $authorTask->task_consumed = $authorTask->task_consumed + 1;
                $authorTask->task_remaining = $authorTask->task_remaining - 1;
                $authorTask->save();
            }

            return redirect()->route('author.dashboard')->with('success', 'Book draft created successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('author.dashboard')->with('error', 'Book draft created failed');
        }

    }

    public function editBook($id)
    {
        $book = AuthorBookDraft::where(['id' => $id, 'user_id' => auth()->user()->id])->first();
        return view('author.book.edit', compact('book'));
    }

    public function updateBook(Request $request, $id)
    {
        $validated = request()->validate([
            'title' => 'required',
            'context' => 'required',
            'content' => 'nullable',
        ]);

        try {
            $updateBook = AuthorBookDraft::where(['id' => $id, 'user_id' => auth()->user()->id])->first();
            $updateBook->title = $request->title;
            $updateBook->context = $request->context;
            $updateBook->content = $request->content;
            $updateBook->save();

            return redirect()->route('author.dashboard')->with('success', 'Book draft updated successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('author.dashboard')->with('error', 'Book draft updated failed');
        }
    }

    public function deleteBook($id)
    {
        try {
            $deleteBook = AuthorBookDraft::where(['id' => $id, 'user_id' => auth()->user()->id])->first();
            $deleteBook->delete();

            $authorBook = AuthorBook::where('user_id', auth()->user()->id)->first();
            $authorBook->book_incomplete = $authorBook->book_incomplete - 1;
            $authorBook->save();

            $authorTask = AuthorTask::where('user_id', auth()->user()->id)->first();
            $authorTask->task_consumed = $authorTask->task_consumed - 1;
            $authorTask->task_remaining = $authorTask->task_remaining + 1;
            $authorTask->save();

            return redirect()->route('author.dashboard')->with('success', 'Book draft deleted successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('author.dashboard')->with('error', 'Book draft deleted failed');
        }
    }

    public function publishBook($id)
    {
        try {
            $publishBook = AuthorBookDraft::where(['id' => $id, 'user_id' => auth()->user()->id])->first();
            $publishBook->status = 'complete';
            $publishBook->save();

            $authorBook = AuthorBook::where('user_id', auth()->user()->id)->first();
            $authorBook->book_incomplete = $authorBook->book_incomplete - 1;
            $authorBook->book_complete = $authorBook->book_complete + 1;
            $authorBook->save();

            $book = AuthorBookDraft::where(['id' => $id, 'user_id' => auth()->user()->id])->first();
            $pdf = \Barryvdh\Snappy\Facades\SnappyPdf::loadView('author.realPdf', compact('book'));
            $pdf->setOption('enable-javascript', true);
            $pdf->setOption('javascript-delay', 5000);
            $pdf->setOption('enable-smart-shrinking', true);
            $pdf->setOption('no-stop-slow-scripts', true);
    
            $path = public_path('files/'.auth()->user()->id.'/');
            $pdf_name = Str::random(5).'.pdf';
            $pdf->save($path.$pdf_name);
            // $pdf->download($pdf_name);
            $path = public_path('files/'.auth()->user()->id.'/'.$pdf_name);
            $pdftext = file_get_contents($path);
            $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
    
            $updatecount = AuthorBookDraft::where(['id' => $id, 'user_id' => auth()->user()->id])->first();
            $updatecount->count_pages = $num;
            $updatecount->url_book = 'files/'.auth()->user()->id.'/'.$pdf_name;
            $updatecount->book_name = $pdf_name;
            $updatecount->save();

            $book = AuthorBookDraft::where(['id' => $id, 'user_id' => auth()->user()->id])->first();

            $cloudconvert = new CloudConvert(['api_key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZTM3ZTI3OWI3MWFiYmRlMzgyZmVlODhjMGUwZmFhYjFhZTIxYWEyNWM3MGUxNTM2NzdkZDc5OTYxOTcxZTIwM2NkZGM3MWYyMzcxNjkzYWEiLCJpYXQiOjE2NzQ2Mjk1ODUuNjY3Mjk5LCJuYmYiOjE2NzQ2Mjk1ODUuNjY3MywiZXhwIjo0ODMwMzAzMTg1LjY2MTUwNiwic3ViIjoiNjE3NDI1NjAiLCJzY29wZXMiOlsidXNlci5yZWFkIiwidXNlci53cml0ZSIsInRhc2sucmVhZCIsInRhc2sud3JpdGUiLCJ3ZWJob29rLnJlYWQiLCJ3ZWJob29rLndyaXRlIiwicHJlc2V0LnJlYWQiLCJwcmVzZXQud3JpdGUiXX0.R8kv6kJepJxe8VFWtrgdCpAAKkvkiyodm9CQDOwDA4vWMCUcnoWTNpnV1JHPu6HtQzYYB0Q9hvNB4Cplo3gMkec4jEbff90W7R0wIKG8le0S5eTyXFkkrT3xVuxdEeku0Qn1Yc9J1AUx0ltSRw-Y_ABnJYbfaABj3W7nddnE_OZbcXIj9cMIGqyOe3msDhd2kc5TYSWFmbaBe-3UuqgDN5Az0UNktzcP3seGYvTH81sYq-Awj7D-Y7I2F4XbUouRPpdIENvhMKZjc77q-7wlCKgvYO4tDypSVUX_Cs2qJ5N95QAR6HD_3sTu1hISmFziL8FxEcALG8mzFvSOaVZ6apHQnqIgNbChp-pmH58f0cJoWKFgKlvviW4x1gvVRoHY0-l6fqGxRy4NHJEcS-_97jDuP9j4taubV7IfLJXJyT513uUibbIXlLesNWd1fl0YifozDN4ABjT_-DEHVz7w3WQYwndf5y4TNX6D5hnLKatH_D7scMdFJYFb3xmVIWnEpmwyfIptVjEuWCI3c4h-TBUibwlR_ODog_wZHG56S6NwwiCIyjAVNePzDK3pFOZ21F7-xHk_JcT2k-pyz4q4ghk_ckAvoCcFUw5r2O61NXJrj1tLjsfcc8_8psfdAqAJx9-eIxPQNa7G1ozAGHt_gUYv3GDRP2w4nwrgqQkU-84']);
            
            $link = env('APP_URL').'/'.$book->url_book;

            $input = $book->book_name;
            $output = $book->id.'.epub';

            $job = (new Job())
            ->addTask(
                (new Task('import/url', 'import-1'))
                    ->set('url', $link)
                    ->set('filename', $input)
                )
            ->addTask(
                (new Task('convert', 'task-1'))
                    ->set('input_format', 'pdf')
                    ->set('output_format', 'epub')
                    ->set('engine', 'calibre')
                    ->set('input', ["import-1"])
                    ->set('engine_version', '6.11')
                    ->set('filename', $output)
                )
            ->addTask(
                (new Task('export/url', 'export-1'))
                    ->set('input', ["task-1"])
                    ->set('inline', false)
                    ->set('archive_multiple_files', false)
                ); 

                $cloudconvert->jobs()->create($job);

                $cloudconvert->jobs()->wait($job); 

                $updatecount = AuthorBookDraft::where(['id' => $id, 'user_id' => auth()->user()->id])->first();
                $updatecount->count_pages = $num;
                $updatecount->url_book = $job->getExportUrls()[0]->url;
                $updatecount->book_name = $pdf_name;
                $updatecount->save();

            return redirect()->route('author.dashboard')->with('success', 'Book draft published successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('author.dashboard')->with('error', 'Book draft published failed');
        }
    }

    public function draftPdf($id)
    {
        $book = AuthorBookDraft::where(['id' => $id, 'user_id' => auth()->user()->id])->first();
        $pdf = \Barryvdh\Snappy\Facades\SnappyPdf::loadView('author.draftPdf', compact('book'));
        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('javascript-delay', 5000);
        $pdf->setOption('enable-smart-shrinking', true);
        $pdf->setOption('no-stop-slow-scripts', true);

        $path = public_path('files/'.auth()->user()->id.'/');
        $pdf_name = Str::random(5).'.pdf';
        $pdf->save($path.$pdf_name);
        // $pdf->download($pdf_name);
        $path = public_path('files/'.auth()->user()->id.'/'.$pdf_name);
        $pdftext = file_get_contents($path);
        $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);

        $updatecount = AuthorBookDraft::where(['id' => $id, 'user_id' => auth()->user()->id])->first();
        $updatecount->count_pages = $num;
        $updatecount->save();

        return redirect()->route('author.book.editBook', $id)->with(['success' => 'Book draft pdf created successfully', 'pdf' => $pdf_name]);
    }

    public function importImage(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $request->file('upload')->move(public_path('images/'.auth()->user()->id.'/'), $fileName);
   
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/'.auth()->user()->id.'/'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }

    public function viewPdf($id)
    {
        $path =  env('APP_URL').'/'.'files/'.auth()->user()->id.'/';
        $pdf = $path.$id;
        return view('author.viewPdf', compact('pdf'));
    }

    public function downloadEpub($id)
    {
        $book = AuthorBookDraft::where(['id' => $id, 'user_id' => auth()->user()->id])->first();

        return redirect()->away($book->url_book);
    }
}
