<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Brand;
use Illuminate\Http\Request;


class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->ajax()) {

            return datatables()->of(Brand::latest()->get())->addColumn('action', function ($data) {

                $output = '';
                $output .= '<a class="btn btn-sm btn-warning brand_edit" edit_id="' . $data['id'] . '" href="#">Edit</a>';
                $output .= ' <a class="btn btn-sm btn-danger brand_del" del_id="' . $data['id'] . '" href="#">Delete</a>';

                return $output;
            })->rawColumns(['action'])->make(true);
        }

        return view('admin.product.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $file_name = '';
        if ($request->hasFile('logo')) {
            $img  = $request->file('logo');
            $file_name = md5(time() . rand()) . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('media/products/brands/'), $file_name);
        }

        Brand::create([
            'name'      => $request->name,
            'slug'      => $this->getSlug($request->name),
            'logo'      => $file_name
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $brand->name = $request->name;
        $brand->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //
    }


    // Status update 
    public function statusUpdate($id)
    {

        $data =  Brand::find($id);

        if ($data->status == true) {
            $data->status = false;
            $data->update();
            return 'Status deactivate successful';
        } else {
            $data->status = true;
            $data->update();
            return 'Status activate successful';
        }
    }

    /**
     * Delete Brand 
     */
    public function deleteBrand($id)
    {
        try {
            $data = Brand::find($id);

            $brand_logo = $data->logo;
            $brand_name = $data->name;

            $data->delete();

            if (file_exists('media/products/brands/' . $brand_logo)) {
                unlink('media/products/brands/' . $brand_logo);
            }

            return $brand_name . ' is sesssssss !';
        } catch (Exception $err) {
            return "Brand Failed";
        }
    }


    /**
     * Edit brand 
     */
    public function editBrand($id)
    {
        $brand_data = Brand::find($id);

        return $brand_data;
    }
}
