<?php

namespace App\Http\Controllers;

use App\Offer;
use Illuminate\Http\Response;

class OfferController extends Controller
{
    /**
     * Display a listing of the Offers.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(Offer::all(), 200);
    }
}
