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
                                <li class="breadcrumb-item active">Category</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->


                <div class="row">

                    <div class="col-lg-12">

                        @include('validate')

                        <a class="btn btn-sm btn-primary" data-toggle="modal" href="#add_category_modal">Add new
                            Category</a>

                        <br>
                        <br>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">All Categories</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="blog_table" class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Category Name</th>
                                                <th>Category Slug</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->


    <div id="add_category_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h2>Add new Category</h2>
                    <hr>
                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input name="name" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary btn-sm" type="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>






    <div id="edit_brand_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h2>Edit Brand</h2>
                    <hr>
                    <form method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input name="name" type="text" class="form-control">
                            <input name="edit_id" type="hidden" class="form-control">
                        </div>
                        <div class="form-group">
                            
                           <img id="edit_brand_photo" src="" alt=""> <br>
                           <label for="">Photo</label>
                           <input name="new_photo" type="file" class="form-control">
                           
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
