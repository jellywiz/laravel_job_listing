<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show all listings
    public function index(){
//        dd(request('tag'));
        $listing = Listing::latest()->filter(request(['tag','search']))->paginate(6);
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

    public function create(){
        return view('listings.create');
    }

    public function store(Request $request){
        $formFields = $request->validate([
           'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);
        if ($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);
        return redirect('/')->with('message', 'List Created');
    }

    public function edit(Listing $listing){
        if (auth()->id() !== $listing->user_id){
            abort (403, 'Unauthorized Action');
        }
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request, Listing $listing){
        if (auth()->id() !== $listing->user_id){
            abort (403, 'Unauthorized Action');
        }
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);
        if ($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }


        $listing->update($formFields);
        return back()->with('message', 'List Updated');
    }

    public function destroy(Listing $listing){
        if (auth()->id() !== $listing->user_id){
            abort (403, 'Unauthorized Action');
        }
        return back()->with('message', 'Unauthenticated');
    }

    public function manage(){
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
