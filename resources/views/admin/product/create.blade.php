@extends('admin.layouts.app')

@section('main-content')

    <!-- Main Wrapper -->
    <div class="main-wrapper">

    @include('admin.layouts.header')
    @include('admin.layouts.menu')



    <!-- Page Wrapper -->
        <div class="page-wrapper">

            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Welcome {{ Auth::user() -> name }}!</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Add new product</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Product Information</h4>
                                </div>
                                <div class="card-body">
                            
                                        <div class="form-group">
                                            <label>Product Name</label>
                                            <input name="name" type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input name="price" type="number" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Sale Price</label>
                                            <input name="sale_price" type="number" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input name="quantity" type="number" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="desc" id="" ></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Short Description</label>
                                            <textarea name="sdesc" class="form-control" name="" id="" ></textarea>
                                        </div>
                                        <div class="form-group">
                                        
                                            <input type="checkbox" name="trands" value="trands" id="trands"> <label for="trands">Make it trendign product</label>
                                        </div>

                                
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Product Images</h4>
                                </div>
                                <style>
                                    .cat_list li {
                                        list-style: none;
                                    }
                                </style>
                                <div class="card-body cat_list">
                                    <label for="">Product Featured Image</label>
                                    <input name="image" class="form-control" type="file" multiple="multiple">
                                </div>
                            </div>



                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Product Category</h4>
                                </div>
                                <style>
                                    .cat_list li {
                                        list-style: none;
                                    }

                                    .cat_list ul:first-child {
                                        padding-left: 0px;
                                    }
                                    .var-box {
                                        display: none;
                                    }
                                </style>
                                <div class="card-body cat_list">
                                    <ul>
                                    @foreach($all_cat as $cat1) 
                                        <li><input name="cat[]" value="{{ $cat1 -> id }}" type="checkbox" id="{{ $cat1 -> name }}"> <label for="{{ $cat1 -> name }}">{{ $cat1 -> name }}</label>
                                            
                                            <ul>
                                            @foreach ($cat1 -> getChild as $cat2)
                                            <li><input  name="cat[]"  value="{{ $cat2 -> id }}" type="checkbox" id="{{ $cat2 -> name }}"> <label for="{{ $cat2 -> name }}">{{ $cat2 -> name }}</label>
                                            
                                            
                                                    <ul>
                                                    @foreach ($cat2 -> getChild as $cat3)
                                                    <li><input  name="cat[]"  value="{{ $cat3 -> id }}" type="checkbox" id="{{ $cat3 -> name }}"> <label for="{{ $cat3 -> name }}">{{ $cat3 -> name }}</label>
                                                        
                                                            <ul>
                                                            @foreach ($cat3 -> getChild as $cat4)
                                                            <li><input  name="cat[]"  value="{{ $cat4 -> id }}" type="checkbox" id="{{ $cat4 -> name }}"> <label for="{{ $cat4 -> name }}">{{ $cat4 -> name }}</label>
                                                                
                                                                    <ul>
                                                                    @foreach ($cat4 -> getChild as $cat5)
                                                                    <li><input  name="cat[]"  value="{{ $cat5 -> id }}" type="checkbox" id="{{ $cat5 -> name }}"> <label for="{{ $cat5 -> name }}">{{ $cat5 -> name }}</label></li>
                                                                    @endforeach
                                                                    </ul>
                                                            
                                                            </li>
                                                            @endforeach
                                                            </ul>
                                                        
                                                    </li>
                                                    @endforeach
                                                    </ul>
                                            
                                            
                                            </li>
                                            @endforeach
                                            </ul>

                                        </li>
                                    @endforeach
                                    </ul>   
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Product tags & Brands</h4>
                                </div>
                                <style>
                                    .cat_list li {
                                        list-style: none;
                                    }
                                </style>
                                <div class="card-body cat_list">
                                    <label for="">Select Product tags</label>
                                    <select style="width: 100%;" name="tag[]"  class="post_tag_select" multiple="multiple">
                                        @foreach($all_tag as $tag)
                                        <option value="{{ $tag -> id }}">{{ $tag -> name }}</option>
                                        @endforeach
                                    </select>
                                    <hr>
                                    <label for="">Select a Brand</label>
                                    <select class="form-control" name="brand" id="">
                                        <option value="">-Select-</option>
                                        @foreach( $all_brands as $brand )
                                        <option value="{{ $brand -> id }}">{{ $brand -> name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <a id="add_var_btn" class="btn btn-primary btn-sm" href="#">Add variables features</a>

                            {{-- <input id="var_opt_sw" type="checkbox" value="variables" > <label for="var_opt_sw">Variables Options</label>

                            <div class="var-box">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Product Size</h4>
                                    </div>
                                    <div class="card-body">
                                        <a id="psize-btn" class="btn btn-sm btn-primary" href="#">Add size</a>
                  
    
                                        <style>
    
                                            .size-box .card {
                                                margin-bottom: 5px;
                                            }
                                                                                
                                            .size-box .card .card-header {
                                                padding: 5px ;
                                                background-color: #555;
                                                color: #FFF;
                                                cursor: pointer;
                                            }
    
                                            .size-box .card .card-body {
                                                padding: 5px ;
                        
                                            }
                                        </style>
                                        <div class="size-box">
                                            
                                        </div>
                                    </div>
                                </div>
    
    
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Product color</h4>
                                    </div>
                                    <div class="card-body">
                                        <a id="pcolor-btn" class="btn btn-sm btn-primary" href="#">Add Color</a>
                        
    
                                    
                                        <div class="color-box">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

        


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </div>
                    
                </form>
                <br>
                <br>
                <br>

            </div>
        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    
    <div id="variable_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body" style="min-height:400px;background-color:#eee;">
                    <a id="add_new_var_btn" class="btn btn-primary btn-sm" href="#">Add new variable </a>
                    <hr>
                    <div class="var-element">


                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection


