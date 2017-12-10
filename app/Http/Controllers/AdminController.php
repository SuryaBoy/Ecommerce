<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class AdminController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('admin.categories.index',compact('category'));
    }
}
