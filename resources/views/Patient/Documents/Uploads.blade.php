@extends('Layouts.PatientMain')

@push('title')
    <title>Patient Document Uploads</title>
@endpush

@section('content')
<main id="main" class="main">
    <div class="pagetitle mb-2">
        <h1>Uploaded Document</h1>
    </div>

    <section class="section profile">
        <div class="card mt-3 mb-0">
            <div class="card-body pt-3"> 
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <span class="fw-bold sub-heading mb-1">Files</span>
                    
                        <span class="btn btn-my-danger btn-sm w-auto p-auto" style="float: right; height: 30px;" data-bs-toggle="modal" data-bs-target="#uploads"> 
                            <i class="bi bi-plus-circle"></i>  Add
                        </span>
                    </div>

                    <table id="table_uploads" class="table table-bordered" style="width: 100%;">
                        <thead class="table-light">
                            <th scope="col">ID</th>
                            <th scope="col">Document Type</th>
                            <th scope="col">Filename</th>
                            <th scope="col">Date Upload</th>
                            <th scope="col">Verified Status</th>
                            <th scope="col">Action</th>
                        </thead>
                        <tbody>
                        @foreach($uploads as $doc)
                            <tr>
                                <td>{{ $doc->pd_id }}</td>
                                <td>{{ $doc->dt_name }}</td>
                                <td>{{ $doc->pd_filename }}</td>
                                <td>{{ date_format(date_create($doc->pd_date),'F d, Y h:i a') }}</td>
                                <td>
                                    @if(!$doc->pd_verified_status)
                                        <span class="badge bg-secondary">Not Verified</span>
                                    @else
                                        <span class="badge bg-success">Verified</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="display_uploads('{{ $doc->pd_sys_filename }}')">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    @if(!$doc->pd_verified_status)
                                        <button class="btn btn-sm btn-danger" onclick="delete_uploads('{{ $doc->pd_filename }}', '{{ route('Patient.DocumentsUploads.Delete', ['id' => $doc->pd_id]) }}')">
                                            <i class="bi bi-eraser"></i>
                                        </button>
                                    @else 
                                        <button class="btn btn-sm btn-danger" disabled><i class="bi bi-eraser"></i></button>
                                    @endif 
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- main -->
<div class="modal fade" id="uploads" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_file_uploads" action="{{ route('Patient.DocumentsUploads.Insert') }}">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                <div class="modal-body mb-3">
                    <label class="form-control border-0 p-0 mb-3">
                        Document Type:
                        <select name="document_type" id="document_type" class="form-select form-select-sm">
                            <option value="">--- choose ---</option>
                            @foreach($doc_type as $type)
                                <option value="{{ $type->dt_id }}">{{ $type->dt_name }}</option>
                            @endforeach 
                        </select>
                        <div class="invalid-feedback" id="document_type_error"></div>
                    </label>

                    <label class="form-control border-0 p-0 mb-3">
                        File:
                        <input type="file" name="file" id="file" class="form-control form-control-sm">
                        <div class="invalid-feedback" id="file_error"></div>
                    </label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-my-danger btn-sm" id="form_file_uploads_submit">
                        <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_file_uploads"></div>
                        <div class="text-light" id="lbl_file_uploads">Add</div>
                    </button>
                </div>
            </form>
        </div>    
    </div>
</div>
@endsection

@push('script')
    <script>
        datatable_no_btn_class('#table_uploads');

        // file uploads 
        $('#form_file_uploads_submit').click(function(){
            reset_inputs();
            load_btn('#lbl_file_uploads','#lbl_loading_file_uploads','#form_file_uploads_submit',true);

            var formData = new FormData($('#form_file_uploads')[0]);

            $.ajax({
                type: "POST",
                url: $('#form_file_uploads').attr('action'),
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
                        swal(response.title, response.message, response.icon);
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
                load_btn('#lbl_file_uploads','#lbl_loading_file_uploads','#form_file_uploads_submit',false);
            });
        });

        function delete_uploads(doc, href){
            swal({
                title: "Are you sure?",
                text: "Your about to delete "+doc+"!",
                icon: "warning",
                buttons: ["Cancel", "Yes"],
                dangerMode: true,
            }).then(function(value){
                if(value){
                    var formData = new FormData($('#form_file_uploads')[0]);
                    $.ajax({
                        type: "POST",
                        url: href,
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

        function display_uploads(file){
            $('#pdf_viewer').modal('show');
            $('#embed_pdf_viewer').attr('src', "{{ asset('storage/documents/') }}"+"/"+file);
        }

        $('#hamburgerMenu').click(function(){
            setTimeout(function() {
                redraw_datatable_class('#table_uploads');
            }, 300);
        });
    </script>
@endpush