// ====================================================================================
// By: Joseph E. Calma
// 
// Date Updated: 1/29/23
// 
// Description: This is where the function that will be use throughout 
// the system.
//      1. show_password = used to display and show password boxes for 
//         both password and retype password.
//      2. load_btn = used to disable/ enable and show loading icon in 
//         buttons.
//      3. reset_inputs = used to reset invalid status of form-control
//         and form-select
// ====================================================================================

function show_password(inpt_id){
    const pass_type = $(inpt_id).attr('type');
    
    if(pass_type == "password"){
        $('.show-password-icon').removeClass('bi-eye-slash');
        $('.show-password-icon').addClass('bi-eye');
        $('.password').attr('type', 'text');
    }
    else{
        $('.show-password-icon').removeClass('bi-eye');
        $('.show-password-icon').addClass('bi-eye-slash');
        $('.password').attr('type', 'password');
    }
}

function load_btn(lbl_default, lbl_loading, btn, disable){
    if(disable==false){
        $(lbl_loading).addClass('d-none');
        $(lbl_default).removeClass('d-none');
        $(btn).prop('disabled', false);
    }
    else{
        $(lbl_loading).removeClass('d-none');
        $(lbl_default).addClass('d-none');
        $(btn).prop('disabled', true);
    }
}

function reset_inputs(){
    $('.invalid-feedback').html('');
    $('.form-select, .form-control').removeClass('is-invalid');
}

