@extends('Layouts.PatientMain')

@push('title')
    <title>COVID Vaccination Insurance</title>
@endpush

@section('content')
<main id="main" class="main">
    <div class="pagetitle mb-2">
        <h1>COVID Vaccination Insurance</h1>
    </div>

    <section class="section profile">

        <div class="card mb-0">
            <div class="card-body pt-4">   
                <form id="form_vaccination_status">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                    <div class="col-lg-12">
                        <span class="fw-bold sub-heading mb-1">Vaccination Status</span>

                        <div class="row mb-4">
                            <label for="not" class="col-lg-2 mt-2">
                                <input type="radio" name="vaccination_status" id="not" value="unvaccinated" {{ ($user_details->vs_status=='unvaccinated') ? 'checked' : '' }}> Unvaccinated
                            </label>
                            <label for="partially" class="col-lg-2 mt-2">
                                <input type="radio" name="vaccination_status" id="partially" value="partially vaccinated" {{ ($user_details->vs_status=='partially vaccinated') ? 'checked' : '' }}> Partially Vaccinated
                            </label>
                            <label for="fully" class="col-lg-2 mt-2">
                                <input type="radio" name="vaccination_status" id="fully" value="fully vaccinated" {{ ($user_details->vs_status=='fully vaccinated') ? 'checked' : '' }}> Fully Vaccinated
                            </label>
                            <label for="boosted" class="col-lg-2 mt-2">
                                <input type="radio" name="vaccination_status" id="boosted" value="boosted" {{ ($user_details->vs_status=='boosted') ? 'checked' : '' }}> Boosted
                            </label>
                            <div class="col-lg-12 mt-1 text-danger my-invalid-feedback" id="vaccination_status_error"></div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <span class="fw-bold sub-heading">Insurance</span>

                        <div class="row mb-4">
                            <div class="col-lg-3 mt-2">
                                PhilHealth No:
                                <input class="form-control form-control-sm" type="text" name="philhealth_no" id="philhealth_no" value="{{ $user_details->vs_philhealth_no }}">
                                <div class="invalid-feedback" id="philhealth_no_error"></div>
                            </div>
                            <div class="col-lg-3 mt-2">
                                Others:
                                <input class="form-control form-control-sm" type="text" name="others" id="others" value="{{ $user_details->vs_others }}">
                                <div class="invalid-feedback" id="others_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-2 mt-4">
                        <button type="button" class="btn btn-my-danger btn-sm w-75" id="form_vaccination_status_submit">
                            <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_vaccination_status"></div>
                            <div class="text-light" id="lbl_vaccination_status">Save Changes</div>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3 mb-0">
            <div class="card-body pt-4"> 
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <span class="fw-bold sub-heading mb-1">Dossage Details</span>
                    
                        <span class="btn btn-my-danger btn-sm w-auto p-auto" style="float: right; height: 30px;" onclick="clear_dosage()" data-bs-toggle="modal" data-bs-target="#dosage"> 
                            <i class="bi bi-plus-circle"></i>  Add
                        </span>
                    </div>

                    <table id="table_vaccination" class="table table-bordered" style="width: 100%;">
                        <thead class="table-light">
                            <th scope="col">Dosage No.</th>
                            <th scope="col">Vaccination Date</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Lot No.</th>
                            <th scope="col">Location</th>
                            <th scope="col">Action</th>
                        </thead>
                        <tbody>
                        @foreach($user_dose_details as $dose)
                            <tr>
                                <td>{{ $dose->vdd_dose_number }}</td>
                                <td>{{ date_format(date_create($dose->vdd_date),'F d, Y') }}</td>
                                <td>{{ $dose->cvb_brand }}</td>
                                <td>{{ $dose->vdd_lot_number }}</td>
                                <td>{{ $dose->mun_name.", ".$dose->prov_name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" id="update_btn_{{ $dose->vdd_id }}" onclick="update_dossage({{ json_encode($dose) }})">
                                        <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_update_btn_{{ $dose->vdd_id }}"></div>
                                        <div class="text-light" id="lbl_update_btn_{{ $dose->vdd_id }}"><i class="bi bi-pencil"></i></div>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="delete_dosage('{{ $dose->vdd_dose_number }}', '{{ route('Patient.COVIDDossageDetails.Delete', ['id' => $dose->vdd_id]) }}')">
                                        <i class="bi bi-eraser"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body pt-4"> 
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <span class="fw-bold sub-heading mb-1">File Uploads</span>
                        
                        <span class="btn btn-my-danger btn-sm w-auto p-auto" style="float: right; height: 30px;" data-bs-toggle="modal" data-bs-target="#uploads"> 
                            <i class="bi bi-plus-circle"></i>  Add
                        </span>
                    </div>

                    <table id="table_uploads" class="table table-bordered" style="width: 100%;">
                        <thead class="table-light">
                            <th scope="col">#</th>
                            <th scope="col">Document Type</th>
                            <th scope="col">Filename</th>
                            <th scope="col">Date Upload</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </thead>
                        <tbody>
                            @php $num = 1; @endphp
                            @foreach($user_documents as $doc)
                            <tr>
                                <td>{{ $num++ }}</td>
                                <td>{{ $doc->dt_name }}</td>
                                <td>{{ $doc->pd_filename }}</td>
                                <td>{{ date_format(date_create($doc->pd_date),'F d, Y h:i a') }}</td>
                                <td>
                                    <span class="badge {{ ($doc->pd_verified_status) ? 'bg-success' : 'bg-secondary' }}">{{ ($doc->pd_verified_status) ? 'Verified' : 'Not Verified' }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="display_uploads('{{ $doc->pd_sys_filename }}')">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    @if(!$doc->pd_verified_status)
                                        <button class="btn btn-sm btn-danger" onclick="delete_uploads('{{ $doc->pd_filename }}', '{{ route('Patient.COVIDFileUploads.Delete', ['id' => $doc->pd_id]) }}')">
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

<div class="modal fade" id="dosage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Dosage Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_dossage_details" action="">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                <div class="modal-body mb-3">
                    <label class="form-control border-0 p-0 mb-3">
                        Dose Number:
                        <input class="form-control" type="number" name="vdd_dose_number" id="vdd_dose_number">
                        <div class="invalid-feedback" id="vdd_dose_number_error"></div>
                    </label>

                    <label class="form-control border-0 p-0 mb-3">
                        Date:
                        <input class="form-control" type="date" name="date" id="date">
                        <div class="invalid-feedback" id="date_error"></div>
                    </label>
                    
                    <label class="form-control border-0 p-0 mb-3">
                        Brand
                        <select class="form-select" name="brand" id="brand">
                            <option value="">--- choose ---</option>
                            @foreach($covid_vaccination_brands as $brand)
                                <option value="{{ $brand->cvb_id }}">{{ $brand->cvb_brand }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="brand_error"></div>
                    </label>

                    <label class="form-control border-0 p-0 mb-3">
                        Lot Number:
                        <input class="form-control" type="text" name="lot_number" id="lot_number" oninput="this.value = this.value.toUpperCase()">
                        <div class="invalid-feedback" id="lot_number_error"></div>
                    </label>

                    <label class="form-control border-0 p-0">
                        Location
                        <div class="row">
                            <label class="col-lg-6 mb-1">
                                Province:
                                <select name="province" id="province" class="form-select">
                                    <option value="">--- choose ---</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->prov_code }}" {{ (old('province')==$province->prov_code) ? 'selected' : '' }}>{{ $province->prov_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="province_error"></div>
                            </label>
                            <div class="col-lg-6">
                                Municipality:
                                <select name="municipality" id="municipality" class="form-select">
                                    <option value="">--- choose ---</option>
                                </select>
                                <div class="invalid-feedback" id="municipality_error"></div>
                            </div>
                        </div>
                    </label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-my-danger btn-sm" id="form_dossage_details_submit">
                        <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_dossage_details"></div>
                        <div class="text-light" id="lbl_dossage_details">Add</div>
                    </button>
                </div>
            </form>
        </div>    
    </div>
</div>

<div class="modal fade" id="uploads" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Upload Files</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_file_uploads" action="{{ route('Patient.COVIDFileUploads.Insert') }}">
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
        datatable_no_btn_class('#table_vaccination');
        datatable_no_btn_class('#table_uploads');

        $('#form_vaccination_status_submit').click(function(){
            reset_inputs();
            load_btn('#lbl_vaccination_status','#lbl_loading_vaccination_status','#form_vaccination_status_submit',true);

            var formData = new FormData($('#form_vaccination_status')[0]);

            $.ajax({
                type: "POST",
                url: $('#form_vaccination_status').attr('action'),
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
                        swal(response.title, response.message, response.icon);
                    }
                },
                error: function(response){
                    console.log(response);
                    swal('Failed!', 'Something went wrong! Please try again later', 'error');
                }
            }).always(function(){
                load_btn('#lbl_vaccination_status','#lbl_loading_vaccination_status','#form_vaccination_status_submit',false);
            });
        });

        // dossage details
        $('#province').change(function(){
            set_municipality('#municipality', '', $(this).val(), '');   
        });

        $('#form_dossage_details_submit').click(function(){
            reset_inputs();
            load_btn('#lbl_dossage_details','#lbl_loading_dossage_details','#form_dossage_details_submit',true);

            var formData = new FormData($('#form_dossage_details')[0]);
            var url = $('#form_dossage_details').attr('action');

            console.log(url);
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
                load_btn('#lbl_dossage_details','#lbl_loading_dossage_details','#form_dossage_details_submit',false);
            });
        });

        function clear_dosage(){
            clear_select('#municipality', '--- choose ---');
            reset_inputs();
            $('#form_dossage_details .form-control, #form_dossage_details .form-select').val('');
            $('#form_dossage_details').attr('action', "{{ route('Patient.COVIDDossageDetails.Insert') }}");
            $('#lbl_dossage_details').html('Add');
        }

        function update_dossage(details){
            load_btn('#lbl_update_btn_'+details.vdd_id,'#lbl_loading_update_btn_'+details.vdd_id,'#update_btn_'+details.vdd_id, true);
            clear_dosage();

            var url = "{{ route('Patient.COVIDDossageDetails.Update', ['id' => '%ID%']) }}";
            var select_mun = '#municipality';
            var mun_code = details.vdd_mun_code;
            var prov_code = details.vdd_prov_code;

            $('#form_dossage_details').attr('action', url.replace('%ID%', details.vdd_id));
            $('#vdd_dose_number').val(details.vdd_dose_number);
            $('#date').val(details.vdd_date);
            $('#brand').val(details.cvb_id);
            $('#lot_number').val(details.vdd_lot_number);
            $('#province').val(details.prov_code);
            $('#lbl_dossage_details').html('Update');

            clear_select(select_mun,'--- choose ---');
            $.ajax({
                url: window.location.origin+"/populate/municipality/"+prov_code,
                type: "GET",
                success: function (response) {
                    $.each( response, function( key, item ) {
                        $(select_mun).append($('<option>', { 
                            value: item.mun_code,
                            text : item.mun_name,
                            selected: (item.mun_code==mun_code) ? true : false
                        }));
                    });
                },
                error: function(response) {
                    console.log(response);
                }
            }).done(function(){
                load_btn('#lbl_update_btn_'+details.vdd_id,'#lbl_loading_update_btn_'+details.vdd_id,'#update_btn_'+details.vdd_id, false);
                $('#dosage').modal('show');
            });
        }

        function delete_dosage(dose, href){
            swal({
                title: "Are you sure?",
                text: "Your about to delete dosage no."+dose+"!",
                icon: "warning",
                buttons: ["Cancel", "Yes"],
                dangerMode: true,
            }).then(function(value){
                if(value){
                    var formData = new FormData($('#form_dossage_details')[0]);
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
                redraw_datatable_class('#table_vaccination');
                redraw_datatable_class('#table_uploads');
            }, 300);
        });
    </script>
@endpush