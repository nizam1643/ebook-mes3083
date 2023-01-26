<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminAuthorListController extends Controller
{
    public function index()
    {
        $authors = User::where('role', 'author')->get();
        return view('admin.author.index', compact('authors'));
    }

    public function show($id)
    {
        $author = User::where('role', 'author')->findOrFail($id);
        return view('admin.author.show', compact('author'));
    }

}
