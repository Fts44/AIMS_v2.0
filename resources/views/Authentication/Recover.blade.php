@extends('Layouts.Authentication')

@push('welcome_message')
    Enter your credentials to recover your account
@endpush

@section('content')

    <form class="row" id="form_recover">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

        <div class="col-lg-12 mb-2">
            <input type="text" name="email" id="email" class="form-control form-control-sm" placeholder="Gsuite or Personal Email"> 
            <div class="invalid-feedback" id="email_error"></div>
        </div>

        <div class="col-lg-12 mb-2">
            <div class="input-group input-group-sm">
                <input type="number" name="otp" id="otp" class="form-control form-control-sm" placeholder="One Time Pin">
                <button class="btn btn-my-danger btn-sm" id="btn_otp" type="button">
                    <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_otp"></div>
                    <div class="text-light" id="lbl_otp">Get OTP</div>
                </button>
                <div class="invalid-feedback" id="otp_error"></div>
            </div>
        </div>

        <div class="col-lg-12 mb-2">
            <div class="input-group input-group-sm">
                <input type="password" name="password" id="password" class="form-control form-control-sm password" placeholder="Password">
                <span class="input-group-text label-icon" onclick="show_password('#password')">
                    <i class="bi bi-eye-slash show-password-icon"></i>
                </span>
                <div class="invalid-feedback" id="password_error"></div>
            </div>
        </div>

        <div class="col-lg-12 mb-3">
            <div class="input-group input-group-sm">
                <input type="password" name="retype_password" id="retype_password" class="form-control form-control-sm password" placeholder="Retype Password">
                <span class="input-group-text label-icon" onclick="show_password('#password')">
                    <i class="bi bi-eye-slash show-password-icon"></i>
                </span>
                <div class="invalid-feedback" id="retype_password_error"></div>
            </div>
        </div>

        <div class="col-12 mb-2">
            <button class="btn btn-my-danger btn-sm w-100" type="button" id="form_recover_submit">
                <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_recover"></div>
                <div class="text-light" id="lbl_recover">Recover</div>
            </button>
        </div>

        <div class="col-12">
            <p class="small mb-0">Already have an account? <a href="{{ route('Login.Index') }}">Login</a></p>
        </div>
    </form>

@endsection

@push('script')
    <script src="{{ asset('js/functions.js') }}"></script>
    <script>

        $('#btn_otp').click(function(e){
            reset_inputs();
            load_btn('#lbl_otp','#lbl_loading_otp','#btn_otp',true);

            $.ajax({
                type: "POST",
                url: "{{ route('SendOTP') }}",
                contentType: 'application/json',
                data: JSON.stringify({
                    "email": $('#email').val(),
                    "msg_type": "recover",
                    "_token": "{{ csrf_token() }}",
                }),
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
                        swal(response.title, response.message, response.icon);
                    }
                },
                error: function(response){
                    console.log(response);
                }
            }).always(function(){
                load_btn('#lbl_otp','#lbl_loading_otp','#btn_otp',false);
            });
        });
        
        $('#form_recover_submit').click(function(e){
            reset_inputs();
            load_btn('#lbl_recover','#lbl_loading_recover','#form_recover_submit',true);

            var formData = new FormData($('#form_recover')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Recover.Create') }}",
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
                        swal(response.title, response.message, response.icon)
                        .then(function(){
                            location.reload();
                        });
                    }
                },
                error: function(response){
                    console.log(response);
                    swal('Failed!', 'Something went wrong! Please try again later', 'error');
                }
            }).always(function(){
                load_btn('#lbl_recover','#lbl_loading_recover','#form_recover_submit',false);
            });
        });
    </script>
@endpush