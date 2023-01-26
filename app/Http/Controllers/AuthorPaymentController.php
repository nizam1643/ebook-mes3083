<?php

namespace App\Http\Controllers;

use App\Models\AuthorPackage;
use App\Models\AuthorPayment;
use App\Models\AuthorTask;
use App\Models\HouseholdIncome;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthorPaymentController extends Controller
{
    public function payment($plan)
    {
        $plan = AuthorPackage::where('id', $plan)->first();
        $income = HouseholdIncome::where('id', auth()->user()->authorProfile->income_id)->first();

        $api_key = env('BILLPLZ_KEY');
        $url_billplz  = env('BILLPLZ_ENDPOINT');
        $collection_id = env('BILLPLZ_COLLECTION_ID');
        $bill = Http::withBasicAuth($api_key, '')->post($url_billplz, [
            'collection_id' => $collection_id,
            'email' => auth()->user()->email,
            'mobile' => null,
            'name' => auth()->user()->name,
            'amount' => ($plan->price - ($plan->price * $income->discount)) * 100,
            'callback_url' => env('APP_URL') . '/api/author/callback-payment',
            'redirect_url' =>  route('author.paymentRedirect'),
            'description' => auth()->user()->name . ' : '. $plan->name,
            [
                'reference_1_label' => 'Author ID : '. auth()->user()->id,
                'reference_1' => auth()->user()->id,
            ]
        ]);

        $response = $bill->body();
        $get_response = json_decode($response);

        $orderPending = new AuthorPayment();
        $orderPending->user_id = auth()->user()->id;
        $orderPending->author_package_id = $plan->id;
        $orderPending->payment_id = $get_response->id;
        $orderPending->status = 'pending';
        $orderPending->save();

        $return_url = $get_response->url;
        return redirect($return_url);
    }

    public function callbackRedirect()
    {
        $response = request()->all();

        if ($response['paid'] == 'true') {
            try {
                $record_exist = AuthorPayment::where('payment_id', $response['id'])->first();
                $record_exist->status = 'success';
                $record_exist->save();

                $user = User::find($record_exist->user_id);
                if (!$user->authorTask) {
                    $task = new AuthorTask();
                    $task->user_id = $user->id;
                    $task->task_allotted = $record_exist->authorPackage->task;
                    $task->task_remaining = $record_exist->authorPackage->task;
                    $task->save();
                }
                if ($user->authorTask) {
                    $task = AuthorTask::where('user_id', $user->id)->first();
                    $task->task_allotted = $task->task_allotted + $record_exist->authorPackage->task;
                    $task->task_remaining = $task->task_remaining + $record_exist->authorPackage->task;
                    $task->save();
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        } else {
            try {
                $record_exist = AuthorPayment::where('payment_id', $response['id'])->first();
                $record_exist->status = 'failed';
                $record_exist->save();
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }

    public function paymentRedirect()
    {
        $response = request()->all();
        if($response['billplz']['paid'] == 'true'){
            return redirect()->route('author.dashboard')->with('success', 'Payment successfully.');
        }
        elseif($response['billplz']['paid'] == 'false'){
            return redirect()->route('author.dashboard')->with('error', 'Payment unsuccesfully.');
        }
        else {
            return redirect()->route('author.dashboard')->with('error', 'Payment unsuccesfully.');
        }
    }

    public function paymentHistory()
    {
        $payments = AuthorPayment::where('user_id', auth()->user()->id)->get();
        return view('author.paymentHistory', compact('payments'));
    }
}
