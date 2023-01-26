<?php

namespace App\Http\Controllers;

use App\Models\AuthorBook;
use App\Models\AuthorBookDraft;
use App\Models\AuthorPackage;
use App\Models\AuthorPayment;
use App\Models\AuthorProfile;
use App\Models\AuthorTask;
use App\Models\HouseholdIncome;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{
    public function dashboard()
    {
        if (auth()->user()->authorProfile == null) {
            return redirect()->route('author.createForm')->with('error', 'Please complete your profile first.');
        }

        $listPrices = AuthorPackage::get();
        $tasks = AuthorTask::where('user_id', auth()->user()->id)->first();
        $listBooks = AuthorBookDraft::where('user_id', auth()->user()->id)->get();
        $books = AuthorBook::where('user_id', auth()->user()->id)->first();
        $income = HouseholdIncome::where('id', auth()->user()->authorProfile->income_id ?? 0)->first();
        $firstBook = auth()->user()->authorBookDraft()->exists() ? auth()->user()->authorBookDraft->first() : null;
        $firstProfile = auth()->user()->authorProfile()->exists() ? auth()->user()->authorProfile->first() : null;
        $statusBook =[
            'book_complete' => $books->book_complete ?? 0,
            'book_incomplete' => $books->book_incomplete ?? 0,
        ];
        return view('author.dashboard', compact('listPrices', 'tasks', 'listBooks', 'books', 'firstBook', 'firstProfile', 'statusBook', 'income'));
    }

    public function createForm()
    {
        if (auth()->user()->authorProfile) {
            return redirect()->route('author.editForm');
        }
        $incomes = HouseholdIncome::select('id', 'name')->get();
        return view('author.profile.create', compact('incomes'));
    }

    public function storeForm(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|regex:/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/|unique:author_profiles,phone_number',
            'address' => 'required',
            'income_id' => 'required|exists:household_incomes,id',
            'subsidy_number' => 'required|min:10|max:10',
        ]);

        try {
            $user = User::find(auth()->user()->id);
            $user->authorProfile()->create([
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'income_id' => $request->income_id,
                'subsidy_number' => $request->subsidy_number,
            ]);
            return redirect()->route('author.editForm')->with('success', 'Profile created successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!, please try again later.');
        }
    }

    public function editForm()
    {
        if (!auth()->user()->authorProfile) {
            return redirect()->route('author.createForm');
        }
        $profile = AuthorProfile::where('user_id', auth()->user()->id)->first();
        $incomes = HouseholdIncome::select('id', 'name')->get();
        $user = User::find(auth()->user()->id);
        return view('author.profile.edit', compact('profile', 'incomes', 'user'));
    }

    public function updateForm(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|regex:/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/',
            'address' => 'required',
            'income_id' => 'required|exists:household_incomes,id',
            'subsidy_number' => 'required|min:10|max:10',
        ]);

        try {
            $user = User::find(auth()->user()->id);
            $user->authorProfile()->update([
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'income_id' => $request->income_id,
                'subsidy_number' => $request->subsidy_number,
            ]);
            return redirect()->route('author.editForm')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!, please try again later.');
        }
    }

    public function updateUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'password' => 'nullable|min:8|confirmed',
            'password_confirmation' => 'same:password',
        ]);

        try {
            $user = User::find(auth()->user()->id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return redirect()->route('author.editForm')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!, please try again later.');
        }
    }
}
