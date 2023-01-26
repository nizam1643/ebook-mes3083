<?php

namespace App\Http\Controllers;

use App\Models\AuthorPackage;
use App\Models\AuthorPayment;
use App\Models\AuthorProfile;
use App\Models\AuthorTask;
use App\Models\HouseholdIncome;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalAuthors = User::where('role', 'author')->count();
        $totalPackage = AuthorPackage::count();
        $totalPurchase = AuthorPayment::count();

        $labelIncome = HouseholdIncome::pluck('name')->toArray();
        $dataIncome = AuthorProfile::selectRaw('count(*) as total, income_id')->groupBy('income_id')->pluck('total')->toArray();

        $labelPayment = AuthorPayment::pluck('status')->toArray();
        $dataPayment = AuthorPayment::selectRaw('count(*) as total, status')->groupBy('status')->pluck('total')->toArray();
        return view('admin.dashboard', compact('totalAuthors', 'totalPackage', 'totalPurchase', 'labelIncome', 'dataIncome', 'labelPayment', 'dataPayment'));
    }
}
