<?php

namespace App\Http\Controllers;

use App\Models\Productcategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Productcategory::latest()->get();
        $first_level_cat = Productcategory::where('parent', NULL)->latest()->get();
        return view('admin.product.category.index', [
            'all_data'      => $data,
            'all_first_cat' => $first_level_cat
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

        // Category Image Upload 
        $unique_name = $this->imageUpload($request, 'image', 'media/products/category/');



        Productcategory::create([
            'name'      => $request->name,
            'slug'      => $this->getSlug($request->name),
            'icon'      => $request->icon,
            'parent'    => (!empty($request->parent_cat)) ? $request->parent_cat : NULL,
            'image'     => $unique_name
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Productcategory  $productcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Productcategory $productcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Productcategory  $productcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Productcategory $productcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Productcategory  $productcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }


    public function destroy($id)
    {
        # code...
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Productcategory  $productcategory
     * @return \Illuminate\Http\Response
     */
    public function catgoryDestroy($id)
    {
        $delete_cat_data = Productcategory::findOrFail($id);

        $paren_id = $delete_cat_data->parent;
        $data_id = $delete_cat_data->id;

        $this->catManage($data_id, $paren_id);

        $delete_cat_data->delete();
        return back();
    }


    public function catManage($id, $parent)
    {
        $data =   Productcategory::where('parent', $id)->get();

        foreach ($data as $cat) {
            $cat->parent = $parent;
            $cat->update();
        }
    }

    /**
     * Edit Category 
     */
    public function catgoryEdit($id)
    {

        $data = Productcategory::find($id);

        $all_cat = Productcategory::all();


        $cat_list = '<option value="">-select-</option>';
        foreach ($all_cat as $cat) {
            $selected = '';
            if ($cat->id == $data->parent) {
                $selected = 'selected="selected"';
            }
            $cat_list .= "<option {$selected} value=\" {$cat->id} \">{$cat->name}</option>";
        }
        return [
            'id'        => $data->id,
            'name'      => $data->name,
            'image'     => $data->image,
            'icon'      => $data->icon,
            'parent'    => $data->parent,
            'cat_list'  => $cat_list
        ];
    }


    public function catgoryUpdate(Request $request)
    {


        if ($request->hasFile('new_photo')) {
            // Category Image Upload 
            $unique_name = $this->imageUpload($request, 'image', 'media/products/category/');
        } else {
            $unique_name = $request->old_photo;
        }


        $update_data = Productcategory::find($request->edit_id);

        $this->catManage($update_data->id, $update_data->parent);


        $update_data->name = $request->name;
        $update_data->slug = $this->getSlug($request->name);
        $update_data->icon = $request->icon;
        $update_data->image = $unique_name;
        $update_data->parent = $request->parent_cat;
        $update_data->update();
        return back();
    }
}
