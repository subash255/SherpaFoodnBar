<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Fooditem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::with('fooditems')->get();
        return view('menu.index', compact('categories'));
    }
}
