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
                <form id="form_family_details">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                    
                    <div class="row">
                        <span class="fw-bold sub-heading mb-2">Father's Details</span>

                        <div class="col-lg-3 mb-2">
                            Firstname
                            <input type="text" name="father_firstname" id="father_firstname" class="form-control form-control-sm" value="{{ $user_details->fd_father_firstname }}">
                            <div class="invalid-feedback" id="father_firstname_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Middlename
                            <input type="text" name="father_middlename" id="father_middlename" class="form-control form-control-sm" value="{{ $user_details->fd_father_middlename }}">
                            <div class="invalid-feedback" id="father_middlename_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Lastname
                            <input type="text" name="father_lastname" id="father_lastname" class="form-control form-control-sm" value="{{ $user_details->fd_father_lastname }}">
                            <div class="invalid-feedback" id="father_lastname_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Suffixname
                            <input type="text" name="father_suffixname" id="father_suffixname" class="form-control form-control-sm" value="{{ $user_details->fd_father_suffixname }}">
                            <div class="invalid-feedback" id="father_suffixname_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Occupation
                            <input type="text" name="father_occupation" id="father_occupation" class="form-control form-control-sm" value="{{ $user_details->fd_father_occupation }}">
                            <div class="invalid-feedback" id="father_occupation_error"></div>
                        </div>
                    </div>

                    <div class="row">
                        <span class="fw-bold sub-heading mb-2">Mother's Details</span>

                        <div class="col-lg-3 mb-2">
                            Firstname
                            <input type="text" name="mother_firstname" id="mother_firstname" class="form-control form-control-sm" value="{{ $user_details->fd_mother_firstname }}">
                            <div class="invalid-feedback" id="mother_firstname_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Middlename
                            <input type="text" name="mother_middlename" id="mother_middlename" class="form-control form-control-sm" value="{{ $user_details->fd_mother_middlename }}">
                            <div class="invalid-feedback" id="mother_middlename_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Lastname
                            <input type="text" name="mother_lastname" id="mother_lastname" class="form-control form-control-sm" value="{{ $user_details->fd_mother_lastname }}">
                            <div class="invalid-feedback" id="mother_lastname_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Suffixname
                            <input type="text" name="mother_suffixname" id="mother_suffixname" class="form-control form-control-sm" value="{{ $user_details->fd_mother_suffixname }}">
                            <div class="invalid-feedback" id="mother_suffixname_error"></div>
                        </div>

                        <div class="col-lg-3 mb-4">
                            Occupation
                            <input type="text" name="mother_occupation" id="mother_occupation" class="form-control form-control-sm" value="{{ $user_details->fd_mother_occupation }}">
                            <div class="invalid-feedback" id="mother_occupation_error"></div>
                        </div>

                        <div class="col-lg-9"></div>

                        <div class="col-lg-3 mb-4">
                            Parent's Marital Status
                            <select name="marital_satus" id="marital_satus" class="form-select form-select-sm">
                                <option value="">--- choose ---</option>
                                <option value="married" {{ ($user_details->fd_marital_status=='married') ? 'selected' : '' }}>Married</option>
                                <option value="unmarried" {{ ($user_details->fd_marital_status=='unmarried') ? 'selected' : '' }}>Unmarried</option>
                                <option value="separated" {{ ($user_details->fd_marital_status=='separated') ? 'selected' : '' }}>Separated</option>
                            </select>
                            <div class="invalid-feedback" id="marital_satus_error"></div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <span class="fw-bold sub-heading mb-2">Family Illness History</span>

                        <div class="col-lg-3 mb-2">
                            Diabetes
                            <i class="bi bi-question-circle text-muted"  data-bs-toggle="tooltip" data-bs-placement="top" title='If your family have history of diabetes choose "Yes", else "No"'></i>
                            <select name="family_illness_history_diabetes" id="family_illness_history_diabetes" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->fih_diabetes=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->fih_diabetes=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="family_illness_history_diabetes_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Heart Disease
                            <i class="bi bi-question-circle text-muted"  data-bs-toggle="tooltip" data-bs-placement="top" title='If your family have history of heart disease choose "Yes", else "No"'></i>
                            <select name="family_illness_history_heart_disease" id="family_illness_history_heart_disease" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->fih_heart_disease=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->fih_heart_disease=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="family_illness_history_heart_disease_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Mental
                            <i class="bi bi-question-circle text-muted"  data-bs-toggle="tooltip" data-bs-placement="top" title='If your family have history of mental illness choose "Yes", else "No"'></i>
                            <select name="family_illness_history_mental" id="family_illness_history_mental" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->fih_mental=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->fih_mental=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="family_illness_history_mental_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Cancer
                            <i class="bi bi-question-circle text-muted"  data-bs-toggle="tooltip" data-bs-placement="top" title='If your family have history of cancer choose "Yes", else "No"'></i>
                            <select name="family_illness_history_cancer" id="family_illness_history_cancer" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->fih_cancer=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->fih_cancer=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="family_illness_history_cancer_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Hypertension
                            <i class="bi bi-question-circle text-muted"  data-bs-toggle="tooltip" data-bs-placement="top" title='If your family have history of hypertension choose "Yes", else "No"'></i>
                            <select name="family_illness_history_hypertension" id="family_illness_history_hypertension" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->fih_hypertension=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->fih_hypertension=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="family_illness_history_hypertension_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Kidney Disease
                            <i class="bi bi-question-circle text-muted"  data-bs-toggle="tooltip" data-bs-placement="top" title='If your family have history of kidney disease choose "Yes", else "No"'></i>
                            <select name="family_illness_history_kidney_disease" id="family_illness_history_kidney_disease" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->fih_kidney_disease=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->fih_kidney_disease=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="family_illness_history_kidney_disease_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Epilepsy
                            <i class="bi bi-question-circle text-muted"  data-bs-toggle="tooltip" data-bs-placement="top" title='If your family have history of epilepsy choose "Yes", else "No"'></i>
                            <select name="family_illness_history_epilepsy" id="family_illness_history_epilepsy" class="form-select form-select-sm">
                                <option value="0" {{ ($user_details->fih_epilepsy=='0') ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($user_details->fih_epilepsy=='1') ? 'selected' : '' }}>Yes</option>
                            </select>
                            <div class="invalid-feedback" id="family_illness_history_epilepsy_error"></div>
                        </div>

                        <div class="col-lg-3 mb-2">
                            Others
                            <i class="bi bi-question-circle text-muted"  data-bs-toggle="tooltip" data-bs-placement="top" title='If your family have history of epilepsy choose "Yes", else "No"'></i>
                            <input type="text" name="family_illness_history_others" id="family_illness_history_others" class="form-control form-control-sm" value="{{ $user_details->fih_others }}">
                            <div class="invalid-feedback" id="family_illness_history_others_error"></div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <button type="button" class="btn btn-my-danger btn-sm w-100" id="form_family_details_submit">
                            <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_family_details"></div>
                            <div class="text-light" id="lbl_family_details">Save Changes</div>
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
        $('#form_family_details_submit').click(function(){
            reset_inputs();
            load_btn('#lbl_family_details','#lbl_loading_family_details','#form_family_details_submit',true);

            var formData = new FormData($('#form_family_details')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Patient.Profile.FamilyDetails.Update') }}",
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
                load_btn('#lbl_family_details','#lbl_loading_family_details','#form_family_details_submit',false);
            });
        });
    </script>
@endpush