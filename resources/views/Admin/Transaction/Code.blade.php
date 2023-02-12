@extends('Layouts.AdminMain')

@push('title')
    <title>Transaction</title>
@endpush

@section('content')
<main id="main" class="main">

    <div class="pagetitle mb-2">
        <h1>Census Codes</h1>
    </div>

    <section class="section profile">
        <div class="card mt-3">
            <div class="card-body pt-4">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <span class="fw-bold sub-heading mb-1">Codes</span>
                    </div>
                </div>
                
                <table id="table_census_code" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">Date</th>
                        <th scope="col">Code</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                    @foreach($codes as $c)
                    <tr>
                        @php $fac_date = date_format(date_create($c->ac_date), 'F d, Y') @endphp
                        <td>{{ $fac_date }}</td>
                        <td>{{ $c->ac_code }}</td>
                        <td>
                            @if($c->ac_status)
                                <span class="badge bg-success">
                                    Open
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    Closed
                                </span>
                            @endif 
                        </td>
                        <td>
                            <button class="btn btn-sm {{ ($c->ac_status) ? 'btn-secondary' : 'btn-success' }}" onclick="update_status('{{ $fac_date }}', '{{ $c->ac_status }}', '{{ $c->ac_id }}')">
                                <i class="bi {{ ($c->ac_status) ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
                            </button>
                            <button class="btn btn-sm btn-primary" onclick="update_code('{{ $fac_date }}', '{{ $c->ac_id }}')">
                                <i class="bi bi-arrow-repeat"></i>
                            </button>
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
@endsection

@push('script')
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/populate.js') }}"></script>
    <script>    
        datatable_class('#table_census_code');

        $('#hamburgerMenu').click(function(){
            setTimeout(function() { 
                redraw_datatable_class('#table_census_code');
            }, 300);
        });

        function update_status(date, old_status, id){
            var osm = '';
            if(old_status == 1){
                osm = 'Closed';
            }
            else{
                osm = 'Open';
            }
            swal({
                title: "Are you sure?",
                text: "Change the status of "+date+" to "+osm,
                icon: "warning",
                buttons: ["Cancel", "Yes"]
            }).then(function(value){
                if(value){
                    var url = "{{ route('Admin.Transaction.CensusCode.Update', ['id' => '%id%']) }}";
                    url = url.replace('%id%', id);
                    $.ajax({
                        async: false,
                        url: url,
                        type: "GET",
                        success: function (response) {      
                            swal('Success', 'The status was changed', 'success')
                            .then(function(value){
                                history.go(0);
                            });
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });
                }
            });
        }

        function update_code(date, id){
            swal({
                title: "Are you sure?",
                text: "Get new code for "+date+"?",
                icon: "warning",
                buttons: ["Cancel", "Yes"]
            }).then(function(value){
                if(value){
                    var url = "{{ route('Admin.Transaction.CensusCode.Create', ['date' => '%date%' ]) }}";
                    url = url.replace('%date%', date);
                    $.ajax({
                        async: false,
                        url: url,
                        type: "GET",
                        success: function (response) {      
                            swal('Success', 'The code was refresh', 'success')
                            .then(function(value){
                                history.go(0);
                            });
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });
                }
            });
        }
    </script>
@endpush