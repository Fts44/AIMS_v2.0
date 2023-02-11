@extends('Layouts.PatientMain')

@push('title')
    <title>Patient Attendance</title>
@endpush

@section('content')
<main id="main" class="main">

    <div class="pagetitle mb-2">
        <h1>Attendance</h1>
    </div>

    <section class="section profile">
        <div class="card mt-3">
            <div class="card-body pt-4">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <span class="fw-bold sub-heading mb-1">File Uploads</span>

                        <span class="btn btn-my-danger btn-sm w-auto p-auto" style="float: right; height: 30px;" data-bs-toggle="modal" data-bs-target="#time_in"> 
                            <i class="bi bi-plus-circle"></i>  Add
                        </span>
                    </div>
                </div>
                
                <table id="table_attendance" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">Date</th>
                        <th scope="col">TimeIn</th>
                        <th scope="col">TimeOut</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Purpose</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                        @foreach($all_attendance as $item)
                        <tr>
                            <td>{{ date_format(date_create($item->trans_date), 'F d, Y') }}</td>
                            <td>{{ date_format(date_create($item->trans_time_in),'h:i a') }}</td>
                            <td>
                                <span>
                                    {{ ($item->trans_time_out) ? date_format(date_create($item->trans_time_out),'h:i a') : 'Not timed out yet' }}
                                </span>
                            </td>
                            @php 
                                $time_in = \Carbon\Carbon::parse($item->trans_time_in);
                                $time_out = \Carbon\Carbon::parse($item->trans_time_out);
                                $resultMinutes = $time_in->diffInMinutes($time_out, false);
                                $resultMinutes = $resultMinutes%60;
                                $resultHours = $time_in->diffInHours($time_out, false);
                                $resultHours = $resultHours%60;
                            @endphp 
                            <td>
                                <span>
                                    {{ ($item->trans_time_out) ? $resultHours.' hr(s) '.$resultMinutes.' min(s)' : 'NA' }}
                                </span>
                            </td>
                            <td>{{ $item->trans_purpose}} {{ ($item->trans_purpose_specify) ? '"'.$item->trans_purpose_specify.'"' : '' }}</td>
                            <td>
                                @if($item->trans_time_out) 
                                    <button class="btn btn-sm btn-danger" disabled><i class="bi bi-box-arrow-left"></i> Time Out</button>
                                @else
                                    <button class="btn btn-sm btn-danger" onclick="time_out('{{ json_encode($item) }}');"><i class="bi bi-box-arrow-left"></i> Time Out</button>
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

  <!-- main -->

    <div class="modal fade" id="time_in" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">Time In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_time_in">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                    <div class="modal-body mb-4">
                        <label class="form-control p-0 border-0 mb-3">
                            Date:
                            <input type="date" name="date" id="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                            <div class="invalid-feedback" id="date_error"></div>
                        </label>

                        <label class="form-control p-0 border-0 mb-3">
                            Attendance Code:
                            <input type="text" name="code" id="code" class="form-control form-control-sm">
                            <div class="invalid-feedback" id="code_error"></div>
                        </label>

                        <label class="form-control border-0 p-0 mb-3">
                            Purpose of Visit:
                            <select name="purpose" id="purpose" class="form-select form-select-sm">
                                <option value="">--- choose ---</option>
                                <option value="BP">BP</option>
                                <option value="Consultation">Consultation</option>
                                <option value="Medicine">Medicine</option>
                                <option value="Medical Certificate">Medical Certificate</option>
                                <option value="Others">Others</option>
                            </select>
                            <div class="invalid-feedback" id="purpose_error"></div>
                        </label>

                        <label class="form-control border-0 p-0 mb-3 d-none" id="specify_purpose_label">
                            Specify (Purpose):
                            <input type="text" name="specify_purpose" id="specify_purpose" class="form-control form-control-sm">
                            <div class="invalid-feedback" id="specify_purpose_error"></div>
                        </label>

                        <label class="form-control border-0 p-0">
                            Your Password:
                            <div class="input-group input-group-sm">
                                <input type="password" name="password" id="password" class="form-control form-control-sm password" placeholder="Password">
                                <span class="input-group-text label-icon" onclick="show_password('#password')">
                                    <i class="bi bi-eye-slash show-password-icon"></i>
                                </span>
                                <div class="invalid-feedback" id="password_error"></div>
                            </div>
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-my-danger" id="form_time_in_submit">
                            <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_time_in"></div>
                            <div class="text-light" id="lbl_time_in">Time In</div>
                        </button>
                    </div>
                </form>
            </div>    
        </div>
    </div>

    <div class="modal fade" id="time_out" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">Time Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_time_out">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                    <div class="modal-body">
                        <label class="form-control border-0 p-0 mb-3">                     
                            Date:
                            <input type="date" name="time_out_date" id="time_out_date" class="form-control form-control-sm" readonly>
                            <div class="invalid-feedback" id="time_out_date_error"></div>
                        </label>

                        <label class="form-control border-0 p-0 mb-3">                     
                            Time In:
                            <input type="text" name="time_out_timein" id="time_out_timein" class="form-control" readonly>
                            <div class="invalid-feedback" id="time_out_timein_error"></div>
                        </label>

                        <label class="form-control border-0 p-0">
                            Your Password:
                            <div class="input-group input-group-sm">
                                <input type="password" name="time_out_pass" id="time_out_pass" class="form-control form-control-sm password" placeholder="Password">
                                <span class="input-group-text label-icon" onclick="show_password('#time_out_pass')">
                                    <i class="bi bi-eye-slash show-password-icon"></i>
                                </span>
                                <div class="invalid-feedback" id="time_out_pass_error"></div>
                            </div>
                        </label>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-my-danger btn-sm" id="form_time_out_submit">
                            <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_time_out"></div>
                            <div class="text-light" id="lbl_time_out">Time Out</div>
                        </button>
                    </div>
                </form>
            </div>    
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/populate.js') }}"></script>
    <script>    
        datatable_class('#table_attendance');

        $('#hamburgerMenu').click(function(){
            setTimeout(function() { 
                redraw_datatable_class('#table_attendance');
            }, 300);
        });

        $('#purpose').change(function(){
            if($(this).val()!='Others'){
                $('#specify_purpose_label').addClass('d-none');
            }
            else{
                $('#specify_purpose_label').removeClass('d-none');
            }
        });

        $('#form_time_in_submit').click(function(){
            reset_inputs();
            load_btn('#lbl_time_in','#lbl_loading_time_in','#form_time_in_submit',true);

            var formData = new FormData($('#form_time_in')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('Patient.Attendance.TimeIn') }}",
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
                load_btn('#lbl_time_in','#lbl_loading_time_in','#form_time_in_submit',false);
            });
        });

        function time_out(details){
            details = JSON.parse(details);
            let time_in = new Date(details.trans_date+" "+details.trans_time_in);
            let url = "{{ route('Patient.Attendance.TimeOut', ['id' => 'id']) }}";
            $('#form_time_out').attr('action', url.replace('id', details.trans_id));
            $('#time_out_timein').val(time_in.toLocaleTimeString());
            $('#time_out_date').val(details.trans_date);
            $('#time_out').modal('show');
        }

        $('#form_time_out_submit').click(function(){
            reset_inputs();
            load_btn('#lbl_time_out','#lbl_loading_time_out','#form_time_out_submit',true);

            var formData = new FormData($('#form_time_out')[0]);

            $.ajax({
                type: "POST",
                url: $('#form_time_out').attr('action'),
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
                load_btn('#lbl_time_out','#lbl_loading_time_out','#form_time_out_submit',false);
            });
        });
    </script>
@endpush