<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('welcome' , compact('categories'));
    }
    
    public function about()
    {
        return view('about');
    }
}
