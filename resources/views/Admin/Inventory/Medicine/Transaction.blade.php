@extends('Layouts.AdminMain')

@push('title')
    <title>Inventory Medicine</title>
@endpush

@section('content')
<main id="main" class="main">
    <div class="pagetitle mb-2">
        <h1>Medicine Inventory</h1>
        <div class="page-nav">
            <nav class="btn-group">   
                <a href="{{ route('Admin.Inventory.Medicine.All.Index') }}" class="btn btn-sm btn-outline-danger">All</a>
                <a onclick="$('#inv_med').submit();" class="btn btn-sm btn-outline-danger active">Item</a>
                <a onclick="$('#inv_med_report').submit();" class="btn btn-sm btn-outline-danger">Report</a>
            </nav>
        </div>
    </div>

    <section class="section mt-2">

        <div class="card" id="card-table">

            <div class="card-body pt-4">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <span class="fw-bold sub-heading mb-1">{{ $id->imgn_generic_name.(($id->imb_brand!='none') ? " (".$id->imb_brand.") " : "").' #MDCN-'.str_pad($id->imi_id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
                <table id="datatable" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">Transaction ID</th>
                        <th scope="col">Patient</th>
                        <th scope="col">Type</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                    @foreach($transactions as $t)
                    <tr>
                        @php $formatted_id = 'MDCN-TRNSC-'.str_pad($t->imt_id, 5, '0', STR_PAD_LEFT) @endphp
                        <td>{{ $formatted_id }}</td>
                        <td>
                            @if($t->acc_id)
                               <a href="{{ route('AdminAccountsPatientsView', ['id' => $t->acc_id]) }}">{{ $t->ttl_title.'. '.$t->firstname.' '.(($t->middlename) ? $t->middlename[0].'. ' : ' ').$t->lastname }}</a> 
                            @else 
                                N/A
                            @endif
                        </td>
                        <td>{{ $t->imt_type }}</td>
                        <td>{{ $t->imt_quantity }}</td>
                        <td>{{ date_format(date_create($t->imt_date),"F d, Y H:i a") }}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                            onclick="delete_form('{{ $formatted_id }}', '{{ $t->imt_id }}')"
                            >
                                <i class="bi bi-eraser"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>

    </section>

</main>

<form id="form" style="display: none;">
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
</form>
@endsection

@push('script')

    <!-- datatable js -->
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script>
        datatable_class('#datatable');
        $('#hamburgerMenu').click(function(){
            setTimeout(function() { 
                redraw_datatable_class('#datatable');
            }, 300);
        });

        function delete_form(item, id){
            var url = "{{ route('Admin.Inventory.Medicine.Item.Transaction.Delete', ['id'=>'%id%']) }}";
            url = url.replace('%id%', id);

            swal({
                title: "Are you sure?",
                text: "Your about to delete "+item+"!",
                icon: "warning",
                buttons: ["Cancel", "Yes"],
                dangerMode: true,
            }).then(function(value){
                if(value){
                    var formData = new FormData($('#form')[0]);
                    $.ajax({
                        type: "POST",
                        url: url,
                        contentType: false,
                        processData: false,
                        data: formData,
                        enctype: 'multipart/form-data',
                        success: function(response){
                            response = JSON.parse(response);
                            console.log(response);
                            if(response.status == 200){
                                swal(response.title, response.message, response.icon).then(function(){
                                    history.go(0);
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
                    });
                }
            });   
        }
    </script>
@endpush