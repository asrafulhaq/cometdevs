(function ($) {
    $(document).ready(function () {

        // Load CK Editors
        CKEDITOR.replace('post_editor');

        // Select 2
        $('.post_tag_select').select2();


        // Logout Features
        $(document).on('click', '#logout_btn', function (e) {
            e.preventDefault();
            $('#logout_form').submit();
        });



        // Category Status
        $(document).on('click', 'input.cat_check', function () {

            let checked = $(this).attr('checked');
            let status_id = $(this).attr('status_id');

            if (checked == 'checked') {
                $.ajax({
                    url: 'category/status-inactive/' + status_id,
                    success: function (data) {
                        swal('Status Inactive successful');
                        $('#blog_table').DataTable().ajax.reload();
                    }
                });
            } else {
                $.ajax({
                    url: 'category/status-active/' + status_id,
                    success: function (data) {
                        swal('Status Active successful');
                        $('#blog_table').DataTable().ajax.reload();
                    }
                });
            }

        });


        // Delete btn fix
        $('.delete-btn').click(function () {

            let conf = confirm('Are  you sure ?');

            if (conf == true) {
                return true;
            } else {
                return false;
            }

        });


        // Category Edit
        $('.edit_cat').click(function (e) {
            e.preventDefault();

            let id = $(this).attr('edit_id');

            $.ajax({
                url: 'category/' + id + '/edit',
                success: function (data) {
                    $('#edit_category_modal form input[name="name"]').val(data.name);
                    $('#edit_category_modal form input[name="edit_id"]').val(data.id);
                    $('#edit_category_modal').modal('show');
                }
            });



        });


        // Post img load
        $('#post_img_select').change(function (e) {

            let img_url = URL.createObjectURL(e.target.files[0]);
            $('.post_img_load').attr('src', img_url);

        });

        // Post img load
        $('#post_img_select_g').change(function (e) {

            let img_gall = '';
            for (let i = 0; i < e.target.files.length; i++) {
                let file_url = URL.createObjectURL(e.target.files[i]);
                img_gall += '<img class="shadow" src="' + file_url + '">';
            }

            $('.post-gallery-img').html(img_gall);


        });






        // Select Post Format
        $('#post_format').change(function () {

            let format = $(this).val();

            if (format == 'Image') {
                $('.post-image').show();
            } else {
                $('.post-image').hide();
            }

            if (format == 'Gallery') {
                $('.post-gallery').show();
            } else {
                $('.post-gallery').hide();
            }

            if (format == 'Video') {
                $('.post-video').show();
            } else {
                $('.post-video').hide();
            }

            if (format == 'Audio') {
                $('.post-audio').show();
            } else {
                $('.post-audio').hide();
            }

        });



        // Admin dash menu manage
        $('#sidebar-menu ul li ul li.ok').parent('ul').slideDown();
        $('#sidebar-menu ul li ul li.ok a').css('color', '#5ae8ff');
        $('#sidebar-menu ul li ul li.ok').parent('ul').parent('li').children('a').css('background-color', '#19c1dc');
        $('#sidebar-menu ul li ul li.ok').parent('ul').parent('li').children('a').addClass('subdrop');

        $('#blog_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'category',
            },
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'slug',
                    name: 'slug'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'sta',
                    name: 'sta',

                },
                {
                    data: 'test',
                    name: 'test'
                }
            ]
        });


        // Product Brand data table 
        $('#brand_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'brand'
            },
            columns: [
                {
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'slug',
                    name: 'slug',
                },
                {
                    data: 'logo',
                    name: 'logo',
                    render: function (data, type, full, meta) {
                        return `<img style="height:60px;" src="media/products/brands/${data}">`;
                    }

                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, full, meta) {
                        return `<div class="status-toggle"><input type="checkbox" ${data == 1 ? 'checked="checked"' : ''} value="${data}" status_id="${full.id}" id="brand_id_${full.id}" class="check brand_check"><label for="brand_id_${full.id}" class="checktoggle">checkbox</label></div>`;
                    }
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        // Add brand 
        $(document).on('submit', '#brand_form', function (e) {
            e.preventDefault();

            $.ajax({
                url: 'brand',
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#brand_form')[0].reset();
                    $('#add_brand_modal').modal('hide');
                    $('#brand_table').DataTable().ajax.reload();
                }
            });

        });



        // Brand status update 
        $(document).on('change', 'input.brand_check', function (e) {
            //get val 
            let status_id = $(this).attr('status_id');
            let status_val = $(this).val();

            $.ajax({
                url: 'brand-status/' + status_id + '/' + status_val,
                success: function (data) {
                    swal(data);
                    $('#brand_table').DataTable().ajax.reload();
                }
            });


        });

        // Delete Brand 
        $(document).on('click', '.brand_del', function (e) {
            e.preventDefault();
            let id = $(this).attr('del_id');

            $.ajax({
                url: 'brand-del/' + id,
                success: function (data) {
                    swal(data);
                    $('#brand_table').DataTable().ajax.reload();
                }
            });

        });

        // Brand edit 
        $(document).on('click', '.brand_edit', function (e) {
            e.preventDefault();

            let id = $(this).attr('edit_id');

            $.ajax({
                url: 'brand-edit/' + id,
                success: function (data) {

                    $('#edit_brand_modal form input[name="name"]').val(data.name);
                    $('#edit_brand_modal form input[name="old_photo"]').val(data.logo);
                    $('#edit_brand_modal form input[name="edit_id"]').val(data.id);
                    $('#edit_brand_modal form').attr('form_no', data.id);
                    $('#edit_brand_photo').attr('src', 'media/products/brands/' + data.logo);

                    $('#edit_brand_modal').modal('show');
                }
            });





        });

        // Brand update 
        $(document).on('submit', '#brand_edit_form', function (e) {
            e.preventDefault();
            let id = $(this).attr('form_no');

            $.ajax({
                url: 'brand/' + id,
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function (data) {
                    swal('Brand updated successful !');
                    $('#brand_table').DataTable().ajax.reload();
                    $('#edit_brand_modal').modal('hide');
                }
            });

        });



        // Product vat list manage options 
        $('.cat_list li').mouseover(function (e) {
            e.stopPropagation();
            $('.cat_list li').removeClass('active');
            $(this).addClass('active');
        });

        // Edit Category Modal 
        $(document).on('click', '.edit_cat', function (e) {
            e.preventDefault();

            let edit_id = $(this).attr('edit_id');

            $.ajax({
                url: 'product-category-edit/' + edit_id,
                success: function (data) {

                    $('#edit_cat_modal input[name="name"]').val(data.name);
                    $('#edit_cat_modal input[name="edit_id"]').val(data.id);
                    $('#edit_cat_modal input[name="icon"]').val(data.icon);
                    $('#edit_cat_modal input[name="old_photo"]').val(data.image);
                    $('#edit_cat_modal select[name="parent_cat"]').html(data.cat_list);
                    $('#edit_cat_modal img').attr('src', 'media/products/category/' + data.image);






                    $('#edit_cat_modal').modal('show');
                }
            });


        });


        // Add size option 

        $('#psize-btn').click(function (e) {
            e.preventDefault();

            let rand_num = Math.floor(Math.random() * 10000);



            let size_container = `<div class="card shadow-sm box-fields">
            <div data-toggle="collapse" data-target="#size-${rand_num}" class="card-header"> Size -  ${rand_num} 
                <button class="close text-light size-close-btn">&times;</button>
            </div>
            <div id="size-${rand_num}" class="collapse">
                <div class="card-body">
                    <div class="form-group">
                        <input name="sizename[]" class="form-control" placeholder="Size Name" type="text">
                    </div>
                    <div class="form-group">
                        <input name="sizeprice[]" class="form-control" placeholder="Price" type="text">
                    </div>
                    <div class="form-group">
                        <input name="sizesaleprice[]" class="form-control" placeholder="Sale Price" type="text">
                    </div>
                </div>
            </div>
        </div>`;

            $('.size-box').append(size_container);


        });


        // Size btn close features 
        $(document).on('click', '.size-close-btn', function () {
            $(this).parent('.card-header').parent('.card').remove();
        });


        // Product Color Btn 
        $('#pcolor-btn').click(function (e) {
            e.preventDefault();

            let rand_num = Math.floor(Math.random() * 10000);



            let color_container = `<div class="card shadow-sm box-fields">
            <div data-toggle="collapse" data-target="#Color-${rand_num}" class="card-header"> Color -  ${rand_num} 
                <button class="close size-close-btn">&times;</button>
            </div>
            <div id="Color-${rand_num}" class="collapse">
                <div class="card-body">
                    <div class="form-group">
                        <input name="colorname[]" class="form-control" placeholder="Color Name" type="text">
                    </div>
                    <div class="form-group">
                        <input name="colorprice[]" class="form-control" placeholder="Price" type="text">
                    </div>
                    <div class="form-group">
                        <input name="colorsaleprice[]" class="form-control" placeholder="Sale Price" type="text">
                    </div>
                </div>
            </div>
        </div>`;

            $('.color-box').append(color_container);


        });

        // var Box Switch
        $('#var_opt_sw').change(function () {
            let opt = $("#var_opt_sw:checked").val();

            if (opt == 'variables') {
                $('.var-box').show();
            } else {
                $('.var-box').hide();
                $('.box-fields input').val(null);
            }
        });



        // Add variable product modal show 
        $('#add_var_btn').click(function (e) {
            e.preventDefault();

            $('#variable_modal').modal('show');
        });

        // Add new var 
        $(document).on('click', '#add_new_var_btn', function (e) {
            e.preventDefault();

            let randnnum = Math.round(Math.random() * 1000);
            $('.var-element').append(`
                
                    <div class="card shadow" style="margin-bottom:0px;">
                    <div data-toggle="collapse" data-target="#card-box-${randnnum}" class="card-header clearfix">
                        <h6 style="float:left;" class="card-title">Variable Box #${randnnum}</h6>

                        <button  class="close float-right var_close_btn" style="z-index:9999;">&times;</button>
                    </div>
                    <div id="card-box-${randnnum}" class="collapse" style="z-index:111;">
                        <div class="card-body">
                            <div class="form-group">
                                <label>variable Name</label>
                                <input class="form-control" type="text" name="var_name[]">
                            </div>
                            <div class="form-group">
                                <label>variable Items</label>
                                <textarea class="form-control" name="var_item[]"></textarea>
                            </div>
                        </div>
                    </div>
                    </div>
            `);


        });

        // close Var box 
        $(document).on('click', 'button.var_close_btn', function (e) {

            e.preventDefault();

            $(this).parent('.card-header').parent('.card').remove();



        });


    });
})(jQuery)
