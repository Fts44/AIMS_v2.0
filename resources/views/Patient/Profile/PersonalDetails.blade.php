@extends('Layouts.PatientMain')

@push('title')
    <title>Personal Details</title>
@endpush

@section('content')
<main id="main" class="main">
    <div class="pagetitle mb-2">
        <h1>Personal Details</h1>
    </div>

    <section class="section profile">

        <div class="card">

            <div class="card-body pt-4">
                <form id="form_personal_details">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                    <!-- profile picture -->
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-3 mb-4">
                                    SR-Code
                                    <input type="text" name="sr_code" id="sr_code" class="form-control form-control-sm" value="{{ $user_details->sr_code }}">
                                    <div class="invalid-feedback" id="srcode_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Personal Email
                                    <input type="text" name="personal_email" id="personal_email" class="form-control form-control-sm" value="{{ $user_details->prsn_email }}">
                                    <div class="invalid-feedback" id="personal_email_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Gsuite Email
                                    <input type="text" name="gsuite_email" id="gsuite_email" class="form-control form-control-sm" value="{{ $user_details->gsuite_email }}" {{ ($user_details->gsuite_email) ? 'disabled' : '' }}>
                                    <div class="invalid-feedback" id="gsuite_email_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4 {{ ($user_details->gsuite_email) ? 'd-none' : '' }}">
                                    One Time Pin (Gsuite)
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="otp" id="otp" class="form-control form-control-sm">
                                        <span id="btn_otp" class="btn btn-my-danger">
                                            <div class="spinner-border spinner-border-sm d-none" role="status" id="lbl_loading_btn_otp"></div>
                                            <div id="lbl_btn_otp">Get OTP</div>
                                        </span>
                                        <div class="invalid-feedback" id="otp_error"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 mb-4">
                                    Firstname
                                    <input type="text" name="firstname" id="firstname" class="form-control form-control-sm" value="{{ $user_details->firstname }}">
                                    <div class="invalid-feedback" id="firstname_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Middlename
                                    <input type="text" name="middlename" id="middlename" class="form-control form-control-sm" value="{{ $user_details->middlename }}">
                                    <div class="invalid-feedback" id="middlename_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Lastname
                                    <input type="text" name="lastname" id="lastname" class="form-control form-control-sm" value="{{ $user_details->lastname }}">
                                    <div class="invalid-feedback" id="lastname_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Suffixname
                                    <input type="text" name="suffixname" id="suffixname" class="form-control form-control-sm" value="{{ $user_details->suffixname }}">
                                    <div class="invalid-feedback" id="suffixname_error"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 mb-4">
                                    Grade Level
                                    <select name="grade_level" id="grade_level" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        @foreach($grade_levels as $grade_level)
                                            <option value="{{ $grade_level->gl_id }}" {{ ($user_details->gl_id==$grade_level->gl_id) ? 'selected' : '' }}>{{ ucwords($grade_level->gl_name) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="grade_level_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Department
                                    <select name="department" id="department" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->dept_id }}" {{ ($user_details->dept_id==$dept->dept_id) ? 'selected' : '' }}>{{ ucwords($dept->dept_code) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="department_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Program
                                    <select name="program" id="program" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        @foreach($programs as $prog)
                                            <option value="{{ $prog->prog_id }}" {{ ($user_details->prog_id==$prog->prog_id) ? 'selected' : '' }}>{{ ucwords($prog->prog_code) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="program_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Year Level
                                    <select name="year_level" id="year_level" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        @foreach($year_levels as $yl)
                                            <option value="{{ $yl->yl_id }}" {{ ($user_details->yl_id==$yl->yl_id) ? 'selected' : '' }}>{{ ucwords($yl->yl_name) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="year_level_error"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 mb-4">
                                    Sex
                                    <select name="sex" id="sex" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        <option value="male" {{ ($user_details->sex=='male') ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ ($user_details->sex=='female') ? 'selected' : '' }}>Female</option>
                                    </select>
                                    <div class="invalid-feedback" id="sex_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Civil Status
                                    <select name="civil_status" id="civil_status" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        <option value="single" {{ ($user_details->civil_status=='single') ? 'selected' : '' }}>Single</option>
                                        <option value="married" {{ ($user_details->civil_status=='married') ? 'selected' : '' }}>Married</option>
                                        <option value="separated" {{ ($user_details->civil_status=='separated') ? 'selected' : '' }}>Separated</option>
                                        <option value="widowed" {{ ($user_details->civil_status=='widowed') ? 'selected' : '' }}>Widowed</option>
                                    </select>
                                    <div class="invalid-feedback" id="civil_status_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Contact
                                    <input type="tel" name="contact" id="contact" class="form-control form-control-sm" value="{{ $user_details->contact }}">
                                    <div class="invalid-feedback" id="contact_error"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 mb-4">
                                    Home Province
                                    <select name="home_province" id="home_province" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->prov_code }}" {{ (old('home_province', $user_details->home_prov)==$province->prov_code) ? 'selected' : '' }}>{{ $province->prov_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="home_province_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Home Municipality
                                    <select name="home_municipality" id="home_municipality" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        @foreach($home_municipalities as $mun)
                                            <option value="{{ $mun->mun_code }}" {{ ($user_details->home_mun==$mun->mun_code) ? 'selected' : '' }}>{{ $mun->mun_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="home_municipality_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Home Barangay
                                    <select name="home_barangay" id="home_barangay" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        @foreach($home_barangays as $brgy)
                                            <option value="{{ $brgy->brgy_code }}" {{ ($user_details->home_brgy==$brgy->brgy_code) ? 'selected' : '' }}>{{ $brgy->brgy_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="home_barangay_error"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 mb-4">
                                    Religion
                                    <select name="religion" id="religion" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        @foreach($religions as $religion)
                                            <option value="{{ $religion->religion_id }}" {{ (old('religion', $user_details->religion)==$religion->religion_id) ? 'selected' : '' }}>{{ $religion->religion_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="religion_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Birthdate
                                    <input type="date" name="birthdate" id="birthdate" class="form-control form-control-sm" value="{{ $user_details->birthdate }}">
                                    <div class="invalid-feedback" id="birthdate_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Classification
                                    <select name="classification" id="classification" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        <option value="st" {{ (old('classification',$user_details->classification)=='st') ? 'selected' : '' }}>Student</option>
                                        <option value="tr" {{ (old('classification',$user_details->classification)=='tr') ? 'selected' : '' }}>Teacher</option>
                                        <option value="sp" {{ (old('classification',$user_details->classification)=='sp') ? 'selected' : '' }}>School Personnel</option>
                                    </select>
                                    <div class="invalid-feedback" id="classification_error"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 mb-4">
                                    Birthplace Province
                                    <select name="birthplace_province" id="birthplace_province" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->prov_code }}" {{ (old('birthplace_province', $user_details->birth_prov)==$province->prov_code) ? 'selected' : '' }}>{{ $province->prov_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="birthplace_province_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Birthplace Municipality
                                    <select name="birthplace_municipality" id="birthplace_municipality" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        @foreach($birthplace_municipalities as $mun)
                                            <option value="{{ $mun->mun_code }}" {{ ($user_details->birth_mun==$mun->mun_code) ? 'selected' : '' }}>{{ $mun->mun_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="birthplace_municipality_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Birthplace Barangay
                                    <select name="birthplace_barangay" id="birthplace_barangay" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        @foreach($birthplace_barangays as $brgy)
                                            <option value="{{ $brgy->brgy_code }}" {{ ($user_details->birth_brgy==$brgy->brgy_code) ? 'selected' : '' }}>{{ $brgy->brgy_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="birthplace_barangay_error"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 mb-4">
                                    Height in meters
                                    <input type="number" name="height" id="height" class="form-control form-control-sm" value="{{ $user_details->height }}">
                                    <div class="invalid-feedback" id="height_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Weight in kg
                                    <input type="number" name="weight" id="weight" class="form-control form-control-sm" value="{{ $user_details->weight }}">
                                    <div class="invalid-feedback" id="weight_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Blood Type
                                    <select name="blood_type" id="blood_type" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        <option value="a positive"  {{ ($user_details->blood_type=='a positive') ? 'selected' : '' }}>A Positive</option>
                                        <option value="a negative"  {{ ($user_details->blood_type=='a negative') ? 'selected' : '' }}>A Negative</option>
                                        <option value="ab positive" {{ ($user_details->blood_type=='ab positive') ? 'selected' : '' }}>AB Positive</option>
                                        <option value="ab negative" {{ ($user_details->blood_type=='ab negative') ? 'selected' : '' }}>AB Negative</option>
                                        <option value="b positive"  {{ ($user_details->blood_type=='b positive') ? 'selected' : '' }}>B Positive</option>
                                        <option value="b negative"  {{ ($user_details->blood_type=='b negative') ? 'selected' : '' }}>B Negative</option>
                                        <option value="o positive"  {{ ($user_details->blood_type=='o positive') ? 'selected' : '' }}>O Positive</option>
                                        <option value="o negative"  {{ ($user_details->blood_type=='o negative') ? 'selected' : '' }}>O Negative</option>
                                    </select>
                                    <div class="invalid-feedback" id="blood_type_error"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 mb-4">
                                    Dormitory Province
                                    <select name="dormitory_province" id="dormitory_province" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->prov_code }}" {{ (old('dormitory_province',$user_details->dorm_prov)==$province->prov_code) ? 'selected' : '' }}>{{ $province->prov_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="dormitory_province_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Dormitory Municipality
                                    <select name="dormitory_municipality" id="dormitory_municipality" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        @foreach($dormitory_municipalities as $mun)
                                            <option value="{{ $mun->mun_code }}" {{ ($user_details->dorm_mun==$mun->mun_code) ? 'selected' : '' }}>{{ $mun->mun_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="dormitory_municipality_error"></div>
                                </div>

                                <div class="col-lg-3 mb-4">
                                    Dormitory Barangay
                                    <select name="dormitory_barangay" id="dormitory_barangay" class="form-select form-select-sm">
                                        <option value="">--- choose ---</option>
                                        @foreach($dormitory_barangays as $brgy)
                                            <option value="{{ $brgy->brgy_code }}" {{ ($user_details->dorm_brgy==$brgy->brgy_code) ? 'selected' : '' }}>{{ $brgy->brgy_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="dormitory_barangay_error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 d-flex flex-column align-items-center">
                            <input type="hidden" name="old_profile_picture" id="old_profile_picture" class="form-control form-control-sm" value="{{ ($user_details->pfp!=NULL) ? asset('storage/profile_picture/'.$user_details->pfp) : '' }}">
                            <img id="pfp_preview" class="form-control p-1 mb-2" src="{{ ($user_details->pfp!=NULL) ? asset('storage/profile_picture/'.$user_details->pfp) : asset('image/pfp-default.png') }}" alt="Profile Picture" style="height: 200px; width: 200px;">
                            <div class="input-group input-group-sm mb-4">
                                <input type="file" name="profile_picture" id="profile_picture" class="form-control form-control-sm" accept=".jpg,.png">
                                <span class="btn btn-my-danger" id="profile_picture_reset">Reset</span>
                                <div class="invalid-feedback" id="profile_picture_error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 mt-2">
                        <button class="btn btn-my-danger btn-sm w-100" type="button" id="form_personal_details_submit">
                            <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_personal_details"></div>
                            <div class="text-light" id="lbl_personal_details">Save Changes</div>
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
  
        $('#btn_otp').click(function(){
            let gsuite_email = $('#gsuite_email').val();
            let token = $('#token').val();

            load_btn('#lbl_btn_otp','#lbl_loading_btn_otp','#btn_otp',true);
            reset_inputs();

            if(!gsuite_email.includes('@g.batstate-u.edu.ph') || gsuite_email==''){          
                if(gsuite_email==''){
                    $('#gsuite_email_error').html('The email is required.');
                }
                else{
                    $('#gsuite_email_error').html('The email must be gsuite email.');
                }
                $('#gsuite_email').addClass('is-invalid');
                load_btn('#lbl_btn_otp','#lbl_loading_btn_otp','#btn_otp',false);
            }
            else{
                $.ajax({
                    type: "POST",
                    url: "{{ route('SendOTP') }}",
                    contentType: false,
                    processData: false,
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "email": gsuite_email,
                        "msg_type": "register",
                        "_token": token,
                    }),
                    enctype: 'multipart/form-data',
                    success: function(response){
                        response = JSON.parse(response);
                        console.log(response);
                        if(response.status == 400){
                            $.each(response.errors, function(key, err_values){
                                $('#gsuite_email_error').html(err_values);
                                $('#gsuite_email').addClass('is-invalid');
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
                }).always(function(){
                    load_btn('#lbl_btn_otp','#lbl_loading_btn_otp','#btn_otp',false);
                });
            }
        });

        $('#form_personal_details_submit').click(function(){
            reset_inputs();
            load_btn('#lbl_personal_details','#lbl_loading_personal_details','#form_personal_details_submit',true);

            var formData = new FormData($('#form_personal_details')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Patient.Profile.PersonalDetails.Update') }}",
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
                load_btn('#lbl_personal_details','#lbl_loading_personal_details','#form_personal_details_submit',false);
            });
        });

        $('#grade_level').change(function(){
            set_department('#department', '', $(this).val(), '#program');
            set_year_level('#year_level', '', $(this).val());
        });
        $('#department').change(function(){
            set_program('#program', '', $(this).val());
        });

        // address populate select
        $('#home_province').change(function(){
            set_municipality('#home_municipality', '', $(this).val(), '#home_barangay');
        });
        $('#home_municipality').change(function(){
            set_barangay('#home_barangay', '', $(this).val());
        });

        $('#birthplace_province').change(function(){
            set_municipality('#birthplace_municipality', '', $(this).val(), '#birthplace_barangay');
        });
        $('#birthplace_municipality').change(function(){
            set_barangay('#birthplace_barangay', '', $(this).val());
        });

        $('#dormitory_province').change(function(){
            set_municipality('#dormitory_municipality', '', $(this).val(), '#dormitory_barangay');
        });
        $('#dormitory_municipality').change(function(){
            set_barangay('#dormitory_barangay', '', $(this).val());
        });

        // profile picture
        $('#profile_picture').change(function(){
            $('#profile_picture_error').html('');
            $('#profile_picture').removeClass('is-invalid');

            let file = $("input[type=file]").get(0).files[0];

            if(file.size > (2 * 1024 * 1024)){
                $('#profile_picture_error').html('The maximum size is 2mb!');
                $('#profile_picture').addClass('is-invalid');
            }
            else{
                if(file){
                    var reader = new FileReader();
                    reader.onload = function(){
                        $("#pfp_preview").attr("src", reader.result);
                    }
                    reader.readAsDataURL(file);
                }
            }
        });

        // reset picture
        $('#profile_picture_reset').click(function(){
            $('#pfp_preview').attr("src", "{{ ($user_details->pfp!=NULL) ? asset('storage/profile_picture/'.$user_details->pfp) : asset('image/pfp-default.png') }}");
            $('#profile_picture').val('');
        });
        
    </script>
@endpush