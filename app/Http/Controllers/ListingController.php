<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListingController extends Controller
{
    // Show all listings
    public function index(){
//        dd(request('tag'));
        $listing = Listing::latest()->filter(request(['tag']))->get();
//        $listing = Listing::orderBy('created_at','DESC')->filter(request(['tag']))->get();

//        $listing = Listing::orderBy('created_at','DESC')->where('tags','LIKE','%'.request('tag').'%')->get();
        return view('listings.index', [
            'listings' => $listing
        ]);
    }

    // Show single listing
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
        ]);
    }


}
