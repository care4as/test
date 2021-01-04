<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;

class OfferController extends Controller
{
    public function store(Request $request)
    {
      // dd($request);
      $request->validate([
        'name' => 'required|unique:offers',
        'volume' => 'required',
        'price' => 'required',
        'telefon' => 'required',
      ]);

      $offer = new Offer;
      $offer->saveOffer($request->name,$request->volume,$request->price,$request->telefon,$request->Categories);

      return redirect()->back();
    }

    public function create()
    {
      return view('OffersCreate');
    }
    public function edit($id)
    {
      // code...
    }
    public function OffersInJSON()
    {
      $offers = Offer::all();
      return response()->json($offers);
    }
    public function OfferInJSON($id)
    {
      $offer = Offer::find($id);
      return response()->json($offer);
    }
    public function OffersByCategoryInJSON($category)
    {
      $offers = Offer::where($category,1)->get();
      return response()->json($offers);
    }
}
