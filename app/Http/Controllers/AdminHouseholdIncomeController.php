<?php

namespace App\Http\Controllers;

use App\Models\HouseholdIncome;
use Illuminate\Http\Request;

class AdminHouseholdIncomeController extends Controller
{
    public function index()
    {
        $totalIncomes = HouseholdIncome::get();
        return view('admin.income.index', compact('totalIncomes'));
    }

    public function create()
    {
        return view('admin.income.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'discount' => 'required',
        ]);

        HouseholdIncome::create([
            'name' => $request->name,
            'discount' => ($request->discount / 100),
        ]);

        return redirect()->route('admin.income.index')->with('success', 'Income created successfully');
    }

    public function edit($id)
    {
        $income = HouseholdIncome::findOrFail($id);
        return view('admin.income.edit', compact('income'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'discount' => 'required',
        ]);

        HouseholdIncome::findOrFail($id)->update([
            'name' => $request->name,
            'discount' => ($request->discount / 100),
        ]);

        return redirect()->route('admin.income.index')->with('success', 'Income updated successfully');
    }

    public function destroy($id)
    {
        HouseholdIncome::findOrFail($id)->delete();
        return redirect()->route('admin.income.index')->with('success', 'Income deleted successfully');
    }
}
