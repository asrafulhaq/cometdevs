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
                            <h3 class="page-title">Welcome {{ Auth::user()->name }}!</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Product Category</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                {{-- Category form  --}}
                <div class="row">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add new Category</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('product-category.store') }}" method="POST" enctype="multipart/form-data">   
                                    @csrf                                
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Category Name</label>
                                                <input name="name" type="text" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Category Icon</label>
                                                <input name="icon" type="text" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Category Image</label>
                                                <input name="image" type="file" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Parent Category</label>
                                                <select name="parent_cat" class="form-control" >
                                                    <option value="">Select</option>
                                                    @foreach($all_data as $data)
                                                    <option value="{{ $data -> id }}">{{ $data -> name }}</option>
                                                    @endforeach
                                                    
                                                </select>
                                            </div>
                                            
                                        </div>
                                       
                                    </div>
                                   
 
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header"><h3>Category Structure</h3></div>
                            <div class="card-body">
                               <ul>
                                @foreach ($all_first_cat as $cat1)
                                    <li>{{ $cat1 -> name }} <div class="cat-manage"> <a class="edit_cat" edit_id="{{$cat1 -> id}}" href="#">Edit</a><a href="{{ route('pcat.destroy', $cat1 -> id) }}">Delete</a></div>
                                        
                                            <ul>
                                            @foreach ($cat1 -> getChild as $cat2)
                                                <li>{{ $cat2 -> name }} <div class="cat-manage"> <a class="edit_cat" edit_id="{{$cat2 -> id}}" href="#">Edit</a><a href="{{ route('pcat.destroy', $cat2 -> id) }}">Delete</a></div>
                                                
                                                        <ul>
                                                        @foreach ($cat2 -> getChild as $cat3)
                                                            <li>{{ $cat3 -> name }} <div class="cat-manage"> <a class="edit_cat" edit_id="{{$cat3 -> id}}" href="#">Edit</a><a href="{{ route('pcat.destroy', $cat3 -> id) }}">Delete</a></div>
                                                                
                                                                    <ul>
                                                                    @foreach ($cat3 -> getChild as $cat4)
                                                                        <li>{{ $cat4 -> name }} <div class="cat-manage"> <a class="edit_cat" edit_id="{{$cat4 -> id}}" href="#">Edit</a><a href="{{ route('pcat.destroy', $cat4 -> id) }}">Delete</a></div>
                                                                                <ul>
                                                                                @foreach ($cat4 -> getChild as $cat5)
                                                                                    <li>{{ $cat5 -> name }}</li> <div class="cat-manage"> <a class="edit_cat" edit_id="{{$cat5 -> id}}" href="#">Edit</a><a href="{{ route('pcat.destroy', $cat5 -> id) }}">Delete</a></div>
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
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    

    <div id="edit_cat_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h2>Edit Category</h2>
                    <hr>
                    <form id="cat_edit_form" action="{{ route('pcat.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input name="name" type="text" class="form-control">
                            <input name="edit_id" type="hidden" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Icon</label>
                            <input name="icon" type="text" class="form-control">
                            
                        </div>
                        <div class="form-group">
                            
                           <img style="width: 150px" id="edit_pcat_photo" src="" alt=""> <br>
                           <label for="">Image</label>
                           <input name="new_photo" type="file" class="form-control">
                           <input name="old_photo" type="hidden" class="form-control">
                           
                        </div>

                        <div class="form-group">
                            <label>Parent Category</label>
                            <select name="parent_cat" class="form-control" >
                                                               
                            </select>
                        </div>


                        <div class="form-group">
                            <input class="btn btn-primary btn-sm" type="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
