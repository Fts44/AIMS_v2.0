@extends('Layouts.PatientMain')

@push('title')
    <title>Change Password</title>
@endpush

@section('content')
<main id="main" class="main">
    <div class="pagetitle mb-2">
        <h1>Change Password</h1>
    </div>

    <section class="section profile">

        <div class="card">

            <div class="card-body pt-4">
                <form id="form_change_password">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                    <div class="row">
                        <div class="col-lg-3 mb-4">
                            Old Password
                            <input type="text" name="old_password" id="old_password" class="form-control form-control-sm">
                            <div class="invalid-feedback" id="old_password_error"></div>
                        </div>
                        <div class="col-lg-9"></div>

                        <div class="col-lg-3 mb-4">
                            New Password
                            <input type="text" name="new_password" id="new_password" class="form-control form-control-sm">
                            <div class="invalid-feedback" id="new_password_error"></div>
                        </div>
                        <div class="col-lg-9"></div>

                        <div class="col-lg-3 mb-4">
                            Retype New Password
                            <input type="text" name="retype_new_password" id="retype_new_password" class="form-control form-control-sm">
                            <div class="invalid-feedback" id="retype_new_password_error"></div>
                        </div>
                    </div>

                    <div class="col-lg-2 mt-2">
                        <button type="button" class="btn btn-my-danger btn-sm w-100" id="form_change_password_submit">
                            <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_change_password"></div>
                            <div class="text-light" id="lbl_change_password">Save Changes</div>
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
        $('#form_change_password_submit').click(function(){
            reset_inputs();
            load_btn('#lbl_change_password','#lbl_loading_change_password','#form_change_password_submit',true);

            var formData = new FormData($('#form_change_password')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Patient.ChangePassword.Update') }}",
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
                load_btn('#lbl_change_password','#lbl_loading_change_password','#form_change_password_submit',false);
            });
        });
    </script>
@endpush