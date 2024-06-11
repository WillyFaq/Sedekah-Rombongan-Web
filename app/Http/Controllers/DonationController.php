<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            "page_title" => "Donasi",
            "data" => Donation::with(["project", "user"])->where("status", ">", "0")->latest()->get()
        ];
        return view("donation.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {

        $data = [
            "page_title" => "Detail Donasi",
            "donation" => $donation
        ];
        return view("donation.show", $data);
    }

    public function invoice(Donation $donation)
    {

        $data = [
            "page_title" => "Detail Donasi",
            "donation" => $donation
        ];
        $pdf = Pdf::loadView('donation.invoice', $data);
        return $pdf->stream();
        // return $pdf->download('invoice.pdf');
        // return view("donation.invoice", $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donation $donation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        //
    }
}
