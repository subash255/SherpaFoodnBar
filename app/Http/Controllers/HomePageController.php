<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Fooditem;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        $fooditems = Fooditem::all();
        $categories = Category::all();
        return view('welcome' , compact('categories', 'fooditems'));
    }
    
    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
