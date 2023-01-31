@extends('Layouts.Authentication')

@push('welcome_message')
    Enter your credentials to login your account
@endpush

@section('content')

    <form class="row" id="form_login">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

        <div class="col-lg-12 mb-2">
            <input type="text" name="userid" id="userid" class="form-control form-control-sm" placeholder="Email or SR-Code"> 
            <div class="invalid-feedback" id="userid_error"></div>
        </div>

        <div class="col-lg-12 mb-3">
            <div class="input-group input-group-sm">
                <input type="password" name="password" id="password" class="form-control form-control-sm password" placeholder="Password">
                <span class="input-group-text label-icon" onclick="show_password('#password')">
                    <i class="bi bi-eye-slash show-password-icon"></i>
                </span>
                <div class="invalid-feedback" id="password_error"></div>
            </div>
        </div>

        <div class="col-12 reCaptcha mb-3">
            <div id="g-recaptcha" class="g-recaptcha" data-callback="recaptchaCallback" data-expired-callback="recaptchaExpired" data-sitekey="6LcasJsgAAAAADf5Toas_DlBccLh5wyGIzmDmjQi"></div>
        </div>

        <div class="col-12 mb-2">
            <button class="btn btn-sm btn-my-danger w-100" id="form_login_submit" type="button" disabled>
                <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_login"></div>
                <div class="text-light" id="lbl_login">Login</div>
            </button>
        </div>

        <div class="col-12 mb-1">
            <p class="small mb-0">Don't have an account? <a href="{{ route('Registration.Index') }}">Create an account</a></p>
        </div>

        <div class="col-12 mb-1">
            <p class="small mb-0"><a href="{{ route('Recover.Index') }}">Forgot password?</a></p>
        </div>
    </form>

@endsection

@push('script')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="{{ asset('js/functions.js') }}"></script>
    <script>
        function recaptchaCallback(){
            const btn = document.querySelector('#form_login_submit');
            btn.removeAttribute('disabled');
        }

        function recaptchaExpired(){
            const btn = document.querySelector('#form_login_submit');
            btn.setAttribute('disabled', '');
        }

        $('#form_login_submit').click(function(e){

            reset_inputs();
            load_btn('#lbl_login','#lbl_loading_login','#form_login_submit',true);

            var formData = new FormData($('#form_login')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Login.Create') }}",
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
                },
                error: function(response){
                    console.log(response);
                    swal('Failed!', 'Something went wrong! Please try again later', 'error');
                }
            }).always(function(){
                load_btn('#lbl_login','#lbl_loading_login','#form_login_submit',false);
            });
        });
    </script>
@endpush