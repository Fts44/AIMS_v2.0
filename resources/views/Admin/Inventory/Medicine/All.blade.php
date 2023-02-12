@extends('Layouts.AdminMain')

@push('title')
    <title>Inventory</title>
@endpush

@section('content')
<main id="main" class="main">
    <div class="pagetitle mb-2">
        <h1>Medicine Inventory</h1>
        <div class="page-nav">
            <nav class="btn-group">   
                <a href="" class="btn btn-sm btn-outline-danger active">All</a>
                <a onclick="$('#inv_med').submit();" class="btn btn-sm btn-outline-danger">Item</a>
                <a onclick="$('#inv_med_report').submit();" class="btn btn-sm btn-outline-danger">Report</a>
            </nav>
        </div>
    </div>
    
    <section class="section mt-2">

        <div class="card" id="card-table">

            <div class="card-body pt-4">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <span class="fw-bold sub-heading mb-1">Medicine Summary</span>
                    </div>
                </div>
                <table id="datatable" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">Generic Name</th>
                        <th scope="col">Available Quantity</th>
                        <th scope="col">For-dispensing</th>
                        <th scope="col">On-hold</th>
                    </thead>
                    <tbody>
                    @foreach($all as $a)
                        @php $aq = $a->total_quantity-($a->tq_1+$a->tq_0); @endphp 
                        @if($aq!=0)
                            <tr>
                                <td>{{ $a->imgn_generic_name }}</td>
                                <td>{{ $aq }}</td>
                                <td>{{ $a->total_1-$a->tq_1 }}</td>
                                <td>{{ $a->total_0-$a->tq_0 }}</td>
                            </tr>     
                        @endif
                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>

    </section>

</main>

@endsection

@push('script')

    <!-- datatable js -->
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script>
        $(document).ready(function(){
            datatable_class('#datatable');
            $('#hamburgerMenu').click(function(){
                setTimeout(function() { 
                    redraw_datatable_class('#datatable');
                }, 300);
            });
            $('.alert').delay(5000).fadeOut('slow');
        });
    </script>
@endpush