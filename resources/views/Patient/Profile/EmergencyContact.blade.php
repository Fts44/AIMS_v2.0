@extends('Layouts.PatientMain')

@push('title')
    <title>Emergency Contact</title>
@endpush

@section('content')
<main id="main" class="main">
    <div class="pagetitle mb-2">
        <h1>Emergency Contact</h1>
    </div>

    <section class="section profile">

        <div class="card">

            <div class="card-body pt-4">
                <form id="form_emergency_contact">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                    <div class="row">
                        <div class="col-lg-3 mb-4">
                            Firstname
                            <input type="text" name="firstname" id="firstname" class="form-control form-control-sm" value="{{ $user_emergency_contact_details->ec_firstname }}">
                            <div class="invalid-feedback" id="firstname_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Middlename
                            <input type="text" name="middlename" id="middlename" class="form-control form-control-sm" value="{{ $user_emergency_contact_details->ec_middlename }}">
                            <div class="invalid-feedback" id="middlename_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Lastname
                            <input type="text" name="lastname" id="lastname" class="form-control form-control-sm" value="{{ $user_emergency_contact_details->ec_lastname }}">
                            <div class="invalid-feedback" id="lastname_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Suffixname
                            <input type="text" name="suffixname" id="suffixname" class="form-control form-control-sm" value="{{ $user_emergency_contact_details->ec_suffixname }}">
                            <div class="invalid-feedback" id="suffixname_error"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 mb-4">
                            Landline
                            <input type="text" name="landline" id="landline" class="form-control form-control-sm" value="{{ $user_emergency_contact_details->ec_landline }}">
                            <div class="invalid-feedback" id="landline_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Contact
                            <input type="text" name="contact" id="contact" class="form-control form-control-sm" value="{{ $user_emergency_contact_details->ec_contact }}">
                            <div class="invalid-feedback" id="contact_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Relation
                            <input type="text" name="relation" id="relation" class="form-control form-control-sm" value="{{ $user_emergency_contact_details->ec_relationtopatient }}">
                            <div class="invalid-feedback" id="relation_error"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 mb-4">
                            Province
                            <select name="province" id="province" class="form-select form-select-sm">
                                <option value="">--- choose ---</option>
                                @foreach($ec_provinces as $province)
                                    <option value="{{ $province->prov_code }}" {{ (old('province', $user_emergency_contact_details->prov_code)==$province->prov_code) ? 'selected' : '' }}>{{ $province->prov_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="province_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Municipality
                            <select name="municipality" id="municipality" class="form-select form-select-sm">
                                <option value="">--- choose ---</option>
                                @foreach($ec_municipalities as $mun)
                                    <option value="{{ $mun->mun_code }}" {{ ($user_emergency_contact_details->mun_code==$mun->mun_code) ? 'selected' : '' }}>{{ $mun->mun_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="municipality_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Barangay
                            <select name="barangay" id="barangay" class="form-select form-select-sm">
                                <option value="">--- choose ---</option>
                                @foreach($ec_barangays as $brgy)
                                    <option value="{{ $brgy->brgy_code }}" {{ ($user_emergency_contact_details->brgy_code==$brgy->brgy_code) ? 'selected' : '' }}>{{ $brgy->brgy_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="barangay_error"></div>
                        </div>
                    </div>

                    <div class="col-lg-2 mt-2">
                        <button type="button" class="btn btn-my-danger btn-sm w-100" id="form_emergency_contact_submit">
                            <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_emergency_contact"></div>
                            <div class="text-light" id="lbl_emergency_contact">Save Changes</div>
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </section>

  </main>
  <!-- main -->

@endsection

@push('script')
    <script>
        $('#form_emergency_contact_submit').click(function(){
            reset_inputs();
            load_btn('#lbl_emergency_contact','#lbl_loading_emergency_contact','#form_emergency_contact_submit',true);

            var formData = new FormData($('#form_emergency_contact')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Patient.Profile.EmergencyContact.Update') }}",
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
                load_btn('#lbl_emergency_contact','#lbl_loading_emergency_contact','#form_emergency_contact_submit',false);
            });
        });

        $('#province').change(function(){
            set_municipality('#municipality', '', $(this).val(), '#barangay');
        });

        $('#municipality').change(function(){
            set_barangay('#barangay', '', $(this).val());
        });
    </script>
@endpush