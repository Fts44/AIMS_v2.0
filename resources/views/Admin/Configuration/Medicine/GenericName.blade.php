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
                <a href="{{ route('Admin.Medicine.Brand.Index') }}" class="btn btn-sm btn-outline-danger">Brand</a>
                <a href="" class="btn btn-sm btn-outline-danger active">Generic Name</a>
            </nav>
        </div>
    </div>

    <section class="section profile">
        <div class="card mt-3">
            <div class="card-body pt-4">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <span class="fw-bold sub-heading mb-1">Generic Name</span>
                        <span class="btn btn-my-danger btn-sm w-auto p-auto" style="float: right; height: 30px;" onclick="clear_form()" data-bs-toggle="modal" data-bs-target="#modal"> 
                            <i class="bi bi-plus-circle"></i>  Add
                        </span>
                    </div>
                </div>
                
                <table id="table_brand" class="table table-bordered" style="width: 100%;">
                <thead class="table-light">
                        <th scope="col">ID</th>
                        <th scope="col">Generic Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                    @foreach($generic_names as $gn)
                    <tr>
                        <td>{{ $gn->imgn_id }}</td>
                        <td>{{ $gn->imgn_generic_name }}</td>
                        <td>
                            @if($gn->imgn_status)
                                <span class="badge bg-success">Enabled</span>
                            @else
                                <span class="badge bg-secondary">Disabled</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="update_form('{{ $gn->imgn_id }}','{{ $gn->imgn_generic_name }}','{{ $gn->imgn_status }}')"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger" 
                            @if(!$gn->imi_id)
                                onclick="delete_form('{{ $gn->imgn_id }}','{{ $gn->imgn_generic_name }}')"
                            @else
                                disabled
                            @endif
                            ><i class="bi bi-eraser"></i></button>
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
                    <h5 class="modal-title" id="modal_title">Add Generic Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <div class="modal-body mb-4">
                        <label class="form-control border-0 p-0">
                            Brand:
                            <input class="form-control form-control-sm" type="text" name="generic_name" id="generic_name">
                            <div class="invalid-feedback" id="generic_name_error"></div>
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
        datatable_class('#table_brand');

        $('#hamburgerMenu').click(function(){
            setTimeout(function() { 
                redraw_datatable_class('#table_brand');
            }, 300);
        });

        function clear_form(){
            reset_inputs();
            $("#status").prop("selectedIndex", 0);
            $('#generic_name').val('');
            $('#lbl_form').html('Add');
            $('#form').attr('action', "{{ route('Admin.Medicine.GenericName.Insert') }}");
        }

        function update_form(gn_id, gn_generic_name, gn_status){
            clear_form();
            var url = "{{ route('Admin.Medicine.GenericName.Update', ['id'=>'%id%']) }}";
            $('#form').attr('action', url.replace('%id%', gn_id));
            $('#generic_name').val(gn_generic_name);
            $('#status').val(gn_status);
            $('#modal_title').html('Update Generic Name');
            $('#lbl_form').html('Update');
            $('#modal').modal('show'); 
        }

        function delete_form(id, brand){
            var url = "{{ route('Admin.Medicine.GenericName.Delete', ['id'=>'%id%']) }}";
            url = url.replace('%id%', id)
            swal({
                title: "Are you sure?",
                text: "Your about to delete "+brand+"!",
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