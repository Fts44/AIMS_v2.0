@extends('Layouts.AdminMain')

@push('title')
    <title>Transaction</title>
@endpush

@section('content')
<main id="main" class="main">

    <div class="pagetitle mb-2">
        <h1>Transaction</h1>
    </div>

    <section class="section profile">
        <div class="col-lg-3">
            <div class="card px-4 py-3 mb-3">
                <h5 class="card-title flex-row justify-content-start m-0">
                    Today's Census Code:
                </h5>
                <span class="mt-1 mb-2">
                    <span class="{{ ($todays_code->ac_status) ? 'text-success' : 'text-danger' }}">● </span>
                    <span id="todays_code">{{$todays_code->ac_code}}</span>
                </span>
                <label class="form-control border-0 px-0 pt-1 pb-0">
                    <button class="btn btn-sm btn-my-danger" id="new_code">
                        <i class="bi bi-arrow-clockwise"></i> New Code
                    </button>
                </label>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body pt-4">
                <div class="row">
                    <div class="col-lg-8 mb-2">
                        <span class="fw-bold sub-heading mb-1">Attendance</span>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <div class="col-lg-12 d-flex flex-row-reverse"> 
                            <button class="btn btn-my-danger btn-sm" id="search" style="max-width: 90px;">
                                Search
                            </button>
                            <input type="date" name="date" id="date" class="form-control form-control-sm" value="{{ $date }}" style="max-width: 120px;">
                        </div>
                    </div>
                </div>
              
                <table id="table_attendance" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time In</th>
                        <th scope="col">Time Out</th>
                        <th scope="col">Patient Name</th>
                        <th scope="col">Dept - SRCode - Course</th>
                        <th scope="col">Classification</th>
                        <th scope="col">Purpose</th>
                    </thead>
                    <tbody>
                    @foreach($attendance as $trans)
                    <tr>
                        <td>{{ $trans->trans_id }}</td>
                        <td>{{ date_format(date_create($trans->trans_date), 'M d, Y') }}</td>
                        <td>{{ date_format(date_create($trans->trans_time_in),'h:i a') }}</td>
                        <td>{{ ($trans->trans_time_out) ? date_format(date_create($trans->trans_time_out),'h:i a') : 'Not timed out yet' }}</td>
                        <td><a href="" style="text-decoration: underline; color: blue;">{{ $trans->trans_patient_name }}</a></td>
                        <td>{{ $trans->trans_department." - ".$trans->trans_srcode." - ".$trans->trans_program }}</td>
                        <td>
                            @if($trans->trans_classification == 'st')
                                Student
                            @elseif($trans->trans_classification == 'tr')
                                Teacher
                            @elseif($trans->trans_classification == 'sp')
                                School Personnel
                            @endif
                        </td>
                        <td>{{ ($trans->trans_purpose=='Others') ? $trans->trans_purpose_specify : $trans->trans_purpose }}</td>
                    </tr>
                    @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
        </div> 
    </section>
  <!-- main -->
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

        $('#new_code').click(function(){
            swal({
                title: "Are you sure?",
                text: "Your about to get new attendance code for today.",
                icon: "warning",
                buttons: ["Cancel", "Yes"]
            }).then(function(value){
                $(this).attr('disabled', true);
                $.ajax({
                    async: false,
                    url: "{{ route('Admin.Transaction.CensusCode.Create', ['date' => date('Y-m-d') ]) }}",
                    type: "GET",
                    success: function (response) {      
                        $('#todays_code').html(response);
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
                $(this).attr('disabled', false);
            });  
        });

        $('#search').click(function(){
            var url = "{{ route('Admin.Transaction.Attendance.Index', ['date'=>'%date%']) }}";
            window.location.href = url.replace('%date%', $('#date').val());
        });
    </script>
@endpush