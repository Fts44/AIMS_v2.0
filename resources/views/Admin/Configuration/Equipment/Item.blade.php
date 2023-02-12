@extends('Layouts.AdminMain')

@push('title')
    <title>Medicine Configuration</title>
@endpush

@section('content')
<main id="main" class="main">

    <div class="pagetitle mb-2">
        <h1>Medicine Configuration</h1>
        <div class="page-nav">
            <nav class="btn-group">   
                <a href="" class="btn btn-sm btn-outline-danger active">Item</a>
                <a href="{{ route('Admin.Equipment.Name.Index') }}" class="btn btn-sm btn-outline-danger">Name</a>
                <a href="{{ route('Admin.Equipment.Brand.Index') }}" class="btn btn-sm btn-outline-danger">Brand</a>
                <a href="{{ route('Admin.Equipment.Type.Index') }}" class="btn btn-sm btn-outline-danger">Type</a>           
                <a href="{{ route('Admin.Equipment.Place.Index') }}" class="btn btn-sm btn-outline-danger">Place</a>
            </nav>
        </div>
    </div>

    <section class="section profile">
        <div class="card mt-3">
            <div class="card-body pt-4">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <span class="fw-bold sub-heading mb-1">Place</span>
                        <span class="btn btn-my-danger btn-sm w-auto p-auto" style="float: right; height: 30px;" onclick="clear_form()" data-bs-toggle="modal" data-bs-target="#modal"> 
                            <i class="bi bi-plus-circle"></i>  Add
                        </span>
                    </div>
                </div>
                
                <table id="table" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Type</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Category</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                    @foreach($ieid_details as $item)
                        <tr>
                            <td>{{ $item->ieid_id }}</td>
                            <td>{{ $item->ien_name }}</td>
                            <td>{{ ucwords($item->ieid_unit) }}</td>
                            <td>{{ ucwords($item->iet_type) }}</td>
                            <td>{{ ucwords($item->ieb_brand) }}</td>
                            <td>{{ ucwords($item->ieid_category) }}</td>
                            <td>
                                <span class="badge {{ ($item->ieid_status) ? 'bg-success' : 'bg-secondary' }}">{{ ($item->ieid_status) ? 'Enabled' : 'Disabled' }}</span>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" onclick="update_form('{{ $item->ieid_id }}','{{ $item->ien_id }}','{{ $item->ieid_unit }}','{{ $item->iet_id }}','{{ $item->ieb_id }}', '{{ $item->ieid_category }}', '{{ $item->ieid_status }}')"><i class="bi bi-pencil"></i></a>
                                <button class="btn btn-danger btn-sm" {{ ($item->iei_id!=null) ? 'disabled' : '' }} onclick="delete_form('{{ $item->ieid_id }}','{{ $item->ien_name.'#'.$item->ieid_id }}')"><i class="bi bi-eraser"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
        </div> 
    </section>
    <!-- main -->

    <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">Add Equipment Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <div class="modal-body mb-4">
                        <label class="form-control border-0 p-0 mb-3">
                            Name:
                            <select class="form-select form-select-sm" name="name" id="name">
                                <option value="">--- choose ---</option>
                                @foreach($ien_names as $name)
                                    <option value="{{ $name->ien_id }}" {{ ($name->ien_status==0) ? 'hidden' : '' }}>{{ $name->ien_name }}</option>
                                @endforeach 
                            </select>
                            <div class="invalid-feedback" id="name_error"></div>
                        </label>

                        <label class="form-control border-0 p-0 mb-3">
                            Unit:
                            <select class="form-select form-select-sm" name="unit" id="unit">
                                <option value="">--- choose ---</option>
                                <option value="pair">Pair</option>
                                <option value="pcs">Pcs</option>
                                <option value="unit">Unit</option>
                            </select>
                            <div class="invalid-feedback" id="unit_error"></div>
                        </label>

                        <label class="form-control border-0 p-0 mb-3">
                            Type:
                            <select class="form-select form-select-sm" name="type" id="type">
                                <option value="">--- choose ---</option>
                                <option value="1">none</option>
                                @foreach($iet_types as $type)
                                    @if($type->iet_type != 'none')
                                        <option value="{{ $type->iet_id }}" {{ ($type->iet_status==0) ? 'hidden' : '' }}>{{ $type->iet_type }}</option>
                                    @endif        
                                @endforeach 
                            </select>
                            <div class="invalid-feedback" id="type_error"></div>
                        </label>

                        <label class="form-control border-0 p-0 mb-3">
                            Brand:
                            <select class="form-select form-select-sm" name="brand" id="brand">
                                <option value="">--- choose ---</option>
                                <option value="1">none</option>
                                @foreach($ieb_brands as $brand)
                                    @if($brand->ieb_brand != 'none')
                                        <option value="{{ $brand->ieb_id }}" {{($brand->ieb_status==0) ? 'hidden' : '' }}>{{ $brand->ieb_brand }}</option>
                                    @endif        
                                @endforeach 
                            </select>
                            <div class="invalid-feedback" id="brand_error"></div>
                        </label>

                        <label class="form-control border-0 p-0 mb-3">
                            Category:
                            <select class="form-select form-select-sm" name="category" id="category">
                                <option value="">--- choose ---</option>
                                <option value="none">none</option>
                                <option value="dental set">Dental Set</option>
                                <option value="minor set">Minor Set</option>
                            </select>
                            <div class="invalid-feedback" id="category_error"></div>
                        </label>

                        <label class="form-control border-0 p-0">
                            Status:
                            <select class="form-select form-select-sm" name="status" id="status">
                                <option value="1">Enable</option>
                                <option value="0">Disable</option>
                            </select>
                            <div class="invalid-feedback" id="status_error"></div>
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-my-danger btn-sm" id="form_submit">
                            <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_form"></div>
                            <div class="text-light" id="lbl_form">Add</div>
                        </button>
                    </div>
                </form>
            </div>    
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/populate.js') }}"></script>
    <script>    
        datatable_class('#table');

        $('#hamburgerMenu').click(function(){
            setTimeout(function() { 
                redraw_datatable_class('#table');
            }, 300);
        });

        function clear_form(){
            reset_inputs();
            $("#status").prop("selectedIndex", 0);
            $('#name').val('');
            $('#unit').val('');
            $('#type').val('');
            $('#brand').val('');
            $('#category').val('');
            $('#lbl_form').html('Add');
            $('#form').attr('action', "{{ route('Admin.Equipment.Item.Insert') }}");
        }

        function update_form(item_id, item_name, item_unit, item_type, item_brand, item_category, item_status){
            clear_form();
            var url = "{{ route('Admin.Equipment.Item.Update', ['id'=>'%id%']) }}";
            $('#form').attr('action', url.replace('%id%', item_id));
            $('#name').val(item_name);
            $('#unit').val(item_unit);
            $('#type').val(item_type);
            $('#brand').val(item_brand);
            $('#category').val(item_category);
            $('#status').val(item_status);
            $('#modal_title').html('Update Equipment Item');
            $('#lbl_form').html('Update');
            $('#modal').modal('show');
        }

        function delete_form(id, place){
            var url = "{{ route('Admin.Equipment.Item.Delete', ['id'=>'%id%']) }}";
            url = url.replace('%id%', id)
            swal({
                title: "Are you sure?",
                text: "Your about to delete "+place+"!",
                icon: "warning",
                buttons: ["Cancel", "Yes"],
                dangerMode: true,
            }).then(function(value){
                if(value){
                    var formData = new FormData($('#form')[0]);
                    $.ajax({
                        type: "POST",
                        url: url,
                        contentType: false,
                        processData: false,
                        data: formData,
                        enctype: 'multipart/form-data',
                        success: function(response){
                            response = JSON.parse(response);
                            console.log(response);
                            if(response.status == 200){
                                swal(response.title, response.message, response.icon).then(function(){
                                    history.go(0);
                                }); 
                            }
                            else{
                                swal(response.title, response.message, response.icon);
                            }
                        },
                        error: function(response){
                            console.log(response);
                            swal('Failed!', 'Something went wrong! Please try again later', 'error');
                        }
                    });
                }
            });   
        }

        $('#form_submit').click(function(){
            reset_inputs();
            load_btn('#lbl_form','#lbl_loading_form','#form_submit',true);

            var formData = new FormData($('#form')[0]);

            $.ajax({
                type: "POST",
                url: $('#form').attr('action'),
                contentType: false,
                processData: false,
                data: formData,
                enctype: 'multipart/form-data',
                success: function(response){
                    response = JSON.parse(response);
                    console.log(response);
                    if(response.status == 400){
                        $.each(response.errors, function(key, err_values){
                            $('#'+key+'_error').html(err_values);
                            $('#'+key).addClass('is-invalid');
                        });
                    }
                    else{
                        swal(response.title, response.message, response.icon).then(function(){
                            history.go(0);
                        });
                    }
                },
                error: function(response){
                    console.log(response);
                    swal('Failed!', 'Something went wrong! Please try again later', 'error');
                }
            }).always(function(){
                load_btn('#lbl_form','#lbl_loading_form','#form_submit',false);
            });
        });
    </script>
@endpush