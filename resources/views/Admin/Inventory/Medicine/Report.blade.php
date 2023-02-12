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
                <a onclick="$('#inv_med').submit();" class="btn btn-sm btn-outline-danger">Item</a>
                <a href="" class="btn btn-sm btn-outline-danger active">Report</a>
            </nav>
        </div>
    </div>

    <section class="section mt-2">

        <div class="card" id="card-table">

            <div class="card-body pt-4">
                <div class="row">
                    <div class="col-lg-8 mb-2">
                        <span class="fw-bold sub-heading mb-1">{{ $title }}</span>
                    </div>
                    <div class="col-lg-4 d-flex flex-row-reverse mb-2"> 
                        <button class="btn btn-my-danger btn-sm" id="search" style="max-width: 90px;"  data-bs-toggle="modal" data-bs-target="#modal_filter">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                </div>
                <table id="datatable" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">Generic Name</th>
                        <th scope="col">Stock-In</th>
                        <th scope="col">Stock-Out</th>
                        <th scope="col">Available</th>
                    </thead>
                    <tbody>
                    @foreach($items as $i)
                        @if($i->initial_quantity!=0 || $i->in_quantity!=0 || $i->out_dispense!=0 || $i->out_dispose!=0)
                            <tr>
                                <td>{{ $i->imgn_generic_name }}</td>
                                <td>
                                    Initial: {{ $i->initial_quantity }} <br>
                                    Added: {{ $i->in_quantity }} <br>
                                    Total: {{ $i->initial_quantity+$i->in_quantity }}
                                </td>
                                <td>
                                    Dispense: {{ $i->out_dispense }} <br>
                                    Dispose: {{ $i->out_dispose }} <br>
                                    Total: {{ $i->out_dispense+$i->out_dispose }}
                                </td>
                                <td>
                                    {{ ($i->initial_quantity+$i->in_quantity)-($i->out_dispense+$i->out_dispose) }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <form action="{{ route('Admin.Inventory.Medicine.Report.Print') }}" id="print">
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="mm" value="{{ $mm }}">
                        <input type="hidden" name="my" value="{{ $my }}">
                        <input type="hidden" name="qq" value="{{ $qq }}">
                        <input type="hidden" name="qy" value="{{ $qy }}">
                        <input type="hidden" name="ay" value="{{ $ay }}">
                        <input type="hidden" name="dd" value="{{ $dd }}">

                        <label class="colg-lg-4">
                            <button type="button" class="btn btn-sm btn-my-danger">
                                <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_print"></div>
                                <div class="text-light" id="lbl_print"><i class="bi bi-printer"></i> Print</div>
                            </button>
                        </label>
                    </form>
                </div>
            </div>

        </div>

    </section>

</main>

<div class="modal fade" id="modal_filter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_filter_dispose">Advanced Filter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('Admin.Inventory.Medicine.Report.Index') }}" method="GET">
                <div class="modal-body">
                    @csrf
                    <label class="form-control border-0 p-0">
                        Type:
                        <select name="type" id="type" class="form-select">
                            <option value="daily" {{ (old('type',$type)=='daily') ? 'selected' : '' }}>Daily</option>
                            <option value="monthly" {{ (old('type',$type)=='monthly') ? 'selected' : '' }}>Monthly</option>
                            <option value="quarterly" {{ (old('type',$type)=='quarterly') ? 'selected' : '' }}>Quarterly</option>
                            <option value="annual" {{ (old('type',$type)=='annual') ? 'selected' : '' }}>Annual</option>
                        </select>
                    </label>

                    <div class="row d-label {{ (old('type', $type)=='daily') ? '' : 'd-none' }}">
                        <label class="col-lg-12 mt-2">
                            Date:
                            <input type="date" name="dd" id="dd" value="{{ old('dd', $dd) }}" class="form-control">
                        </label>
                    </div>

                    <div class="row q-label {{ (old('type', $type)=='quarterly') ? '' : 'd-none' }}">
                        <label class="col-lg-6 mt-2">
                            Quarter:
                            <select name="qq" id="qq" class="form-select">
                                @for($i=1; $i<=4; $i++){
                                    <option value="{{ $i }}" {{ (old('qq', $qq)==$i) ? 'selected' : ''  }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </label>
                        <label class="col-lg-6 mt-2">
                            Year:
                            <select name="qy" id="qy" class="form-select">
                                @for($i=date('Y'); $i>=2021; $i--)
                                    <option value="{{$i}}" {{ (old('qy', $qy)==$i) ? 'selected' : ''  }}>{{$i}}</option>
                                @endfor
                            </select>
                        </label>
                    </div>

                    <div class="row m-label {{ (old('type', $type)=='monthly') ? '' : 'd-none' }}">
                        <label class="col-lg-6 mt-2">
                            Month:
                            <select name="mm" id="mm" class="form-select">
                                @for($i=1; $i<=12; $i++){
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT); }}" {{ (old('mm', $mm)==str_pad($i, 2, '0', STR_PAD_LEFT)) ? 'selected' : ''  }}>{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                @endfor
                            </select>
                        </label>
                        <label class="col-lg-6 mt-2">
                            Year:
                            <select name="my" id="my" class="form-select">
                                @for($i=date('Y'); $i>=2021; $i--)
                                    <option value="{{$i}}" {{ (old('my', $my)==$i) ? 'selected' : ''  }}>{{$i}}</option>
                                @endfor
                            </select>
                        </label>
                    </div>

                    <label class="form-control p-0 border-0 mt-2 a-label {{ (old('type', $type)=='annual') ? '' : 'd-none' }}">
                        Year:
                        <select name="ay" id="ay" class="form-select">
                            @for($i=date('Y'); $i>=2021; $i--)
                                <option value="{{$i}}" {{ (old('ay', $ay)==$i) ? 'selected' : ''  }}>{{$i}}</option>
                            @endfor
                        </select>
                    </label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-my-danger">Search</button>
                </div>
            </form>
        </div>    
    </div>
</div>
@endsection

@push('script')

    <!-- datatable js -->
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script>
        datatable_no_btn_class('#datatable');
        $('#hamburgerMenu').click(function(){
            setTimeout(function() { 
                redraw_datatable_class('#datatable');
            }, 300);
        });
            
        $('#type').change(function(){
            if($(this).val()=='daily'){
                $('.d-label').removeClass('d-none');
                $('.m-label').addClass('d-none');
                $('.q-label').addClass('d-none');
                $('.a-label').addClass('d-none');
            }
            if($(this).val()=='monthly'){
                $('.m-label').removeClass('d-none');
                $('.d-label').addClass('d-none');
                $('.q-label').addClass('d-none');
                $('.a-label').addClass('d-none');
            }
            else if($(this).val()=='quarterly'){
                $('.q-label').removeClass('d-none');
                $('.d-label').addClass('d-none');
                $('.a-label').addClass('d-none');
                $('.m-label').addClass('d-none');
            }
            else if($(this).val()=='annual'){
                $('.a-label').removeClass('d-none');
                $('.d-label').addClass('d-none');
                $('.m-label').addClass('d-none');
                $('.q-label').addClass('d-none');
            }
        });

        $('#print').click(function(){
            load_btn('#lbl_print','#lbl_loading_print','#print',true);

            $.ajax({
                type: "GET",
                url: "{{ route('Admin.Inventory.Medicine.Report.Print') }}",
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                success: function(response){
                    response = JSON.parse(response);
                    console.log(response);
                    if(response.status == 400){
                        swal(response.title, response.message, response.icon);
                    }
                    else{
                        $('#pdf_viewer').modal('show');
                        $('#embed_pdf_viewer').attr('src', "{{ asset('storage/generated_documents/') }}"+"/"+response.filename);
                    }
                },
                error: function(response){
                    console.log(response);
                    swal('Failed!', 'Something went wrong! Please try again later', 'error');
                }
            }).always(function(){
                load_btn('#lbl_print','#lbl_loading_print','#print',false);
            });
        });   
    </script>
@endpush