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
                <a href="" class="btn btn-sm btn-outline-danger active">Brand</a>
                <a href="{{ route('Admin.Medicine.GenericName.Index') }}" class="btn btn-sm btn-outline-danger">Generic Name</a>
            </nav>
        </div>
    </div>

    <section class="section profile">
        <div class="card mt-3">
            <div class="card-body pt-4">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <span class="fw-bold sub-heading mb-1">Brands</span>
                        <span class="btn btn-my-danger btn-sm w-auto p-auto" style="float: right; height: 30px;" onclick="clear_brand()" data-bs-toggle="modal" data-bs-target="#modal"> 
                            <i class="bi bi-plus-circle"></i>  Add
                        </span>
                    </div>
                </div>
                
                <table id="table_brand" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">Date</th>
                        <th scope="col">Code</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                    @foreach($brands as $b)
                    <tr>
                        <td>{{ $b->imb_id }}</td>
                        <td>{{ $b->imb_brand }}</td>
                        <td> 
                            @if($b->imb_status)
                                <span class="badge bg-success">Enabled</span>
                            @else
                                <span class="badge bg-secondary">Disabled</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="update_brand('{{ $b->imb_id }}','{{ $b->imb_brand }}','{{ $b->imb_status }}')"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger" 
                                @if($b->imb_id!=1 && !$b->imi_id)
                                    onclick="delete_brand('{{ $b->imb_id }}','{{ $b->imb_brand }}')"
                                @else
                                    disabled
                                @endif><i class="bi bi-eraser"></i></button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
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
                    <h5 class="modal-title" id="modal_title">Add Generic Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_medicine_brand">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <div class="modal-body mb-4">
                        <label class="form-control border-0 p-0">
                            Brand:
                            <input class="form-control form-control-sm" type="text" name="brand" id="brand">
                            <div class="invalid-feedback" id="brand_error"></div>
                        </label>
                        <label class="form-control border-0 p-0 mt-2">
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
                        <button type="button" class="btn btn-my-danger btn-sm" id="form_medicine_brand_submit">
                            <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_medicine_brand"></div>
                            <div class="text-light" id="lbl_medicine_brand">Add</div>
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
        datatable_class('#table_brand');

        $('#hamburgerMenu').click(function(){
            setTimeout(function() { 
                redraw_datatable_class('#table_brand');
            }, 300);
        });

        function clear_brand(){
            reset_inputs();
            $("#status").prop("selectedIndex", 0);
            $('#brand').val('');
            $('#lbl_medicine_brand').html('Add');
            $('#form_medicine_brand').attr('action', "{{ route('Admin.Medicine.Brand.Insert') }}");
        }

        function update_brand(id, brand, status){
            clear_brand();
            var url = "{{ route('Admin.Medicine.Brand.Update', ['id'=>'%id%']) }}";
            $('#form_medicine_brand').attr('action', url.replace('%id%', id));
            $('#brand').val(brand);
            $('#status').val(status);
            $('#modal_title').html('Update Brand Name');
            $('#lbl_medicine_brand').html('Update');
            $('#modal').modal('show'); 
        }

        function delete_brand(id, brand){
            var url = "{{ route('Admin.Medicine.Brand.Delete', ['id'=>'%id%']) }}";
            url = url.replace('%id%', id)
            swal({
                title: "Are you sure?",
                text: "Your about to delete "+brand+"!",
                icon: "warning",
                buttons: ["Cancel", "Yes"],
                dangerMode: true,
            }).then(function(value){
                if(value){
                    var formData = new FormData($('#form_medicine_brand')[0]);
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

        $('#form_medicine_brand_submit').click(function(){
            reset_inputs();
            load_btn('#lbl_medicine_brand','#lbl_loading_medicine_brand','#form_medicine_brand_submit',true);

            var formData = new FormData($('#form_medicine_brand')[0]);

            $.ajax({
                type: "POST",
                url: $('#form_medicine_brand').attr('action'),
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
                load_btn('#lbl_medicine_brand','#lbl_loading_medicine_brand','#form_medicine_brand_submit',false);
            });
        });
    </script>
@endpush