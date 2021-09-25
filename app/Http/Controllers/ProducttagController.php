<?php

namespace App\Http\Controllers;

use App\Models\Producttag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProducttagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Producttag::latest()->get();
        return view('admin.product.tag.index', [
            'all_data'   => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('view.name');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Producttag::create([
            'name'      => $request->name,
            'slug'      => $this->getSlug($request->name)
        ]);

        return redirect()->back()->with('success', 'Product Added successfull');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producttag  $producttag
     * @return \Illuminate\Http\Response
     */
    public function show(Producttag $producttag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producttag  $producttag
     * @return \Illuminate\Http\Response
     */
    public function edit(Producttag $producttag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producttag  $producttag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producttag $producttag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producttag  $producttag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producttag $producttag)
    {
        //
    }
}
