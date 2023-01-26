<?php

namespace App\Http\Controllers;

use App\Models\AuthorPackage;
use Illuminate\Http\Request;

class AdminPackageController extends Controller
{
    public function index()
    {
        $totalPackages = AuthorPackage::get();
        return view('admin.package.index', compact('totalPackages'));
    }

    public function create()
    {
        return view('admin.package.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sub_name' => 'required',
            'price' => 'required',
            'task' => 'required',
        ]);

        AuthorPackage::create([
            'name' => $request->name,
            'sub_name' => $request->sub_name,
            'price' => $request->price,
            'task' => $request->task,
        ]);

        return redirect()->route('admin.package.index')->with('success', 'Package created successfully');
    }

    public function edit($id)
    {
        $package = AuthorPackage::findOrFail($id);
        return view('admin.package.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'sub_name' => 'required',
            'price' => 'required',
            'task' => 'required',
        ]);

        AuthorPackage::findOrFail($id)->update([
            'name' => $request->name,
            'sub_name' => $request->sub_name,
            'price' => $request->price,
            'task' => $request->task,
        ]);

        return redirect()->route('admin.package.index')->with('success', 'Package updated successfully');
    }

    public function destroy($id)
    {
        AuthorPackage::findOrFail($id)->delete();
        return redirect()->route('admin.package.index')->with('success', 'Package deleted successfully');
    }
}
