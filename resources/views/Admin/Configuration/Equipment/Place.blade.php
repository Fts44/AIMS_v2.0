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
                <a href="{{ route('Admin.Equipment.Item.Index') }}" class="btn btn-sm btn-outline-danger">Item</a>
                <a href="{{ route('Admin.Equipment.Name.Index') }}" class="btn btn-sm btn-outline-danger">Name</a>
                <a href="{{ route('Admin.Equipment.Brand.Index') }}" class="btn btn-sm btn-outline-danger">Brand</a>
                <a href="{{ route('Admin.Equipment.Type.Index') }}" class="btn btn-sm btn-outline-danger">Type</a>           
                <a href="" class="btn btn-sm btn-outline-danger active">Place</a>
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
                        <th scope="col">Place</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                    @foreach($ie_places as $item)
                        <tr>
                            <td>{{ $item->iep_id }}</td>
                            <td>{{ $item->iep_place }}</td>
                            <td>
                                <span class="badge {{ ($item->iep_status) ? 'bg-success' : 'bg-secondary' }}">{{ ($item->iep_status) ? 'Enabled' : 'Disabled' }}</span>
                            </td>
                            @if($item->iep_id=='1' && $item->iep_place=='none')
                                <td>
                                    <button class="btn btn-primary btn-sm" disabled><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm" disabled><i class="bi bi-eraser"></i></button>
                                </td>
                            @else
                                <td>
                                    <a class="btn btn-primary btn-sm" onclick="update_form('{{ $item->iep_id }}','{{ $item->iep_place }}','{{ $item->iep_status }}')"><i class="bi bi-pencil"></i></a>
                                    <button class="btn btn-danger btn-sm" {{ ($item->iei_id!=null) ? 'disabled' : '' }} onclick="delete_form('{{ $item->iep_id }}','{{ $item->iep_place }}');"><i class="bi bi-eraser"></i></button>
                                </td>
                            @endif
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
                    <h5 class="modal-title" id="modal_title">Add Equipment Place</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <div class="modal-body mb-4">
                        <label class="form-control border-0 p-0">
                            Place:
                            <input class="form-control form-control-sm" type="text" name="place" id="place">
                            <div class="invalid-feedback" id="place_error"></div>
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
        datatable_class('#table');

        $('#hamburgerMenu').click(function(){
            setTimeout(function() { 
                redraw_datatable_class('#table');
            }, 300);
        });

        function clear_form(){
            reset_inputs();
            $("#status").prop("selectedIndex", 0);
            $('#place').val('');
            $('#lbl_form').html('Add');
            $('#form').attr('action', "{{ route('Admin.Equipment.Place.Insert') }}");
        }

        function update_form(item_id, item_place, item_status){
            clear_form();
            var url = "{{ route('Admin.Equipment.Place.Update', ['id'=>'%id%']) }}";
            $('#form').attr('action', url.replace('%id%', item_id));
            $('#place').val(item_place);
            $('#status').val(item_status);
            $('#modal_title').html('Update Equipment Place');
            $('#lbl_form').html('Update');
            $('#modal').modal('show');
        }

        function delete_form(id, place){
            var url = "{{ route('Admin.Equipment.Place.Delete', ['id'=>'%id%']) }}";
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