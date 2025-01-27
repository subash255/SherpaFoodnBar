<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Fooditem;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomePageController extends Controller
{
    public function index()
    {
        $this->visits();
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

    public function cart()
    {
        return view('cart.index');
    }

     //visited people
     public function visits()
     {
         if (!Session::has('visit')) {
 
             $last_date = Visit::latest('visit_date')->first();
             $visit_date = date('Y-m-d');
             if ($last_date) {
                 if ($last_date->visit_date != $visit_date) {
                     $number_of_visits = 1;
                     $d = new Visit();
                     $d->visit_date = $visit_date;
                     $d->number_of_visits = $number_of_visits;
                     $d->save();
                 } else {
                     $newvisit = $last_date->number_of_visits + 1;
                     Visit::where('visit_date', $visit_date)->update(['number_of_visits' => $newvisit]);
                 }
             } else {
                 $number_of_visits = 1;
                 $d = new Visit();
                 $d->visit_date = $visit_date;
                 $d->number_of_visits = $number_of_visits;
                 $d->save();
             }
             Session::put('visit', 'yes');
             Session::save();
         }
     }
 }
