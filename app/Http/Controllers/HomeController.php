<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function showHome()
    {
        $products = Product::orderBy('created_at', 'desc')->take(4)->get();
        return view('home', ['products' => $products]);
    }

    public function showServices()
    {
        return view('services');
    }
}