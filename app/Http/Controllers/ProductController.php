<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Producttag;
use Illuminate\Http\Request;
use App\Models\Productcategory;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Product::latest()->get();
        return view('admin.product.index', [
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
        $all_cat = Productcategory::where('status', true)->where('parent', NULL)->get();
        $all_tag = Producttag::where('status', true)->get();
        $all_brand = Brand::where('status', true)->get();
        return view('admin.product.create', [
            'all_cat'   => $all_cat,
            'all_tag'   => $all_tag,
            'all_brands'   => $all_brand,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'name'      => 'required'
        // ]);



        $size = [];
        $i = 0;
        if (isset($request->sizename)) {
            foreach ($request->sizename as $name) {
                array_push($size, [
                    'sizename'      => $name,
                    'price'         =>  $request->sizeprice[$i],
                    'saleprice'     => $request->sizesaleprice[$i]
                ]);

                $i++;
            }

            $size_data =   json_encode($size);
        }





        $color = [];
        $c = 0;

        if (isset($request->colorname)) {
            foreach ($request->colorname as $name) {
                array_push($color, [
                    'colorname'      => $name,
                    'price'         =>  $request->colorprice[$c],
                    'saleprice'     => $request->colorsaleprice[$c]
                ]);

                $c++;
            }

            $color_data =   json_encode($color);
        }



        Product::create([
            'name'          => $request->name,
            'slug'          => $this->getSlug($request->name),
            'regular_price' => $request->price,
            'sale_price'    => $request->sale_price,
            'stock'         => $request->quantity,
            'desc'          => $request->desc,
            'srt_desc'      => $request->sdesc,
            'size'          => $size_data,
            'color'         => $color_data
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
