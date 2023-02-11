@extends('Layouts.PatientMain')

@push('title')
    <title>Assessment Diagnosis</title>
@endpush

@section('content')
<main id="main" class="main">
    <div class="pagetitle mb-2">
        <h1>Assessment Diagnosis</h1>
    </div>

    <section class="section profile">

        <div class="card">

            <div class="card-body pt-4">
                <form id="form_assessment_diagnosis">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                    <div class="row mb-2">
                        <span class="fw-bold sub-heading mb-1">Question #1</span>
                    
                        <div class="col-lg-3 mb-2">
                            Are you drinking?
                            <select name="drinking" id="drinking" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->ad_drinking_how_much) ? '' : 'selected' }}>No</option>
                                <option value="1" {{ ($user_details->ad_drinking_how_much) ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="drinking_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            How much do you drink? (Bottles)
                            <input type="text" name="drinking_how_much" id="drinking_how_much" class="form-control form-control-sm" value="{{ $user_details->ad_drinking_how_much }}" {{ ($user_details->ad_drinking_how_much) ? '' : 'disabled' }}>
                            <div class="invalid-feedback" id="drinking_how_much_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            How often do you drink?
                            <select class="form-select" name="drinking_how_often" id="drinking_how_often" {{ (!$user_details->ad_drinking_how_much) ? 'disabled' : '' }}>
                                <option value="" {{ ($user_details->ad_drinking_how_often) ? '' : 'selected' }}>--- choose ---</option>
                                <option value="one time a week" {{ ($user_details->ad_drinking_how_often=='one time a week') ? 'selected' : '' }}>One time a week</option>
                                <option value="two times a week" {{ ($user_details->ad_drinking_how_often=='two times a week') ? 'selected' : '' }}>Two times a week</option>
                                <option value="three times a week" {{ ($user_details->ad_drinking_how_often=='three times a week') ? 'selected' : '' }}>Three times a week</option>
                                <option value="four times a week" {{ ($user_details->ad_drinking_how_often=='four times a week') ? 'selected' : '' }}>Four times a week</option>
                                <option value="five times a week" {{ ($user_details->ad_drinking_how_often=='five times a week') ? 'selected' : '' }}>Five times a week</option>
                                <option value="six times a week" {{ ($user_details->ad_drinking_how_often=='six times a week') ? 'selected' : '' }}>Six times a week</option>
                                <option value="seven times a week" {{ ($user_details->ad_drinking_how_often=='seven times a week') ? 'selected' : '' }}>Seven times a week</option>
                            </select>
                            <div class="invalid-feedback" id="drinking_how_often_error"></div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <span class="fw-bold sub-heading mb-1">Question #2</span>
                    
                        <div class="col-lg-3 mb-2">
                            Are you smoking?
                            <select name="smoking" id="smoking" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->ad_smoking_sticks_per_day) ? '' : 'selected' }}>No</option>
                                <option value="1" {{ ($user_details->ad_smoking_sticks_per_day) ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="smoking_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            How many stick per day?
                            <input type="text" name="smoking_sticks_per_day" id="smoking_sticks_per_day" class="form-control form-control-sm" value="{{ $user_details->ad_smoking_sticks_per_day }}" {{ ($user_details->ad_smoking_sticks_per_day) ? '' : 'disabled' }}>
                            <div class="invalid-feedback" id="smoking_sticks_per_day_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Since when? (Age)
                            <input type="text" name="smoking_since_when" id="smoking_since_when" class="form-control form-control-sm"  value="{{ $user_details->ad_smoking_since_when }}" {{ ($user_details->ad_smoking_sticks_per_day) ? '' : 'disabled' }}>
                            <div class="invalid-feedback" id="smoking_since_when_error"></div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <span class="fw-bold sub-heading mb-1">Question #3</span>
                    
                        <div class="col-lg-3 mb-2">
                            Are you using any drug/medication?
                            <select name="drug" id="drug" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->ad_drug_kind) ? '' : 'selected' }}>No</option>
                                <option value="1" {{ ($user_details->ad_drug_kind) ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="drug_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Drug/Medication kind?
                            <input type="text" name="drug_kind" id="drug_kind" class="form-control form-control-sm" value="{{ $user_details->ad_drug_kind }}" {{ ($user_details->ad_drug_kind) ? '' : 'disabled' }}>
                            <div class="invalid-feedback" id="drug_kind_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Regular use?
                            <select name="drug_regular_use" id="drug_regular_use" class="form-select form-select-sm"  {{ ($user_details->ad_drug_kind) ? '' : 'disabled' }}>
                                <option value="" {{ ($user_details->ad_drug_kind) ? '' : 'selected' }}>--- choose ---</option>
                                <option value="0" {{ ($user_details->ad_drug_kind) ? ($user_details->ad_drug_regular_use=='0') ? 'selected' : '' : '' }}>No</option>
                                <option value="1" {{ ($user_details->ad_drug_kind) ? ($user_details->ad_drug_regular_use=='1') ? 'selected' : '' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="drug_regular_use_error"></div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <span class="fw-bold sub-heading mb-1">Question #4</span>
                    
                        <div class="col-lg-3 mb-2">
                            Are you driving?
                            <select name="driving" id="driving" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->ad_driving_specify) ? '' : 'selected' }}>No</option>
                                <option value="1" {{ ($user_details->ad_driving_specify) ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="driving_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            What kind of vehicle?
                            <input type="text" name="driving_specify" id="driving_specify" class="form-control form-control-sm" value="{{ $user_details->ad_driving_specify }}" {{ ($user_details->ad_driving_specify) ? '' : 'disabled' }}>
                            <div class="invalid-feedback" id="driving_specify_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Do you have driving license?
                            <select class="form-select" name="driving_with_license" id="driving_with_license" {{ (!old('driving', $user_details->ad_driving_specify)) ? 'disabled' : '' }}>
                                <option value="">--- choose ---</option>
                                <option value="0" {{ ($user_details->ad_driving_specify) ? ($user_details->ad_driving_with_license=='0') ? 'selected' : '' : '' }}>No</option>
                                <option value="1" {{ ($user_details->ad_driving_specify) ? ($user_details->ad_driving_with_license=='1') ? 'selected' : '' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="driving_with_license_error"></div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <span class="fw-bold sub-heading mb-1">Question #5</span>
                    
                        <div class="col-lg-3 mb-2">
                            Experience any kind of abuse?
                            <select name="abuse" id="abuse" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->ad_abuse_specify) ? '' : 'selected' }}>No</option>
                                <option value="1" {{ ($user_details->ad_abuse_specify) ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="abuse_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            What kind of abuse?
                            <input type="text" name="abuse_specify" id="abuse_specify" class="form-control form-control-sm" value="{{ $user_details->ad_abuse_specify }}" {{ ($user_details->ad_abuse_specify) ? '' : 'disabled' }}>
                            <div class="invalid-feedback" id="abuse_specify_error"></div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <button type="button" class="btn btn-my-danger btn-sm w-100" id="form_assessment_diagnosis_submit">
                            <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_assessment_diagnosis"></div>
                            <div class="text-light" id="lbl_assessment_diagnosis">Save Changes</div>
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
        $('#drinking').change(function(){ clear_disable_enable_input(this, $('#drinking_how_much, #drinking_how_often')); });
        $('#smoking').change(function(){ clear_disable_enable_input(this, $('#smoking_sticks_per_day, #smoking_since_when')); });
        $('#drug').change(function(){ clear_disable_enable_input(this, $('#drug_kind, #drug_regular_use')); });
        $('#driving').change(function(){ clear_disable_enable_input(this, $('#driving_specify, #driving_with_license')); });
        $('#abuse').change(function(){ clear_disable_enable_input(this, $('#abuse_specify')); });

        $('#form_assessment_diagnosis_submit').click(function(){
            reset_inputs();
            load_btn('#lbl_assessment_diagnosis','#lbl_loading_assessment_diagnosis','#form_assessment_diagnosis_submit',true);

            var formData = new FormData($('#form_assessment_diagnosis')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Patient.Profile.AssessmentDiagnosis.Update') }}",
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
                load_btn('#lbl_assessment_diagnosis','#lbl_loading_assessment_diagnosis','#form_assessment_diagnosis_submit',false);
            });
        });
    </script>
@endpush