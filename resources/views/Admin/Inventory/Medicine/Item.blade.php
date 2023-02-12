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
                    <div class="col-lg-8 mb-2">
                        <span class="fw-bold sub-heading mb-1">Items</span>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <div class="col-lg-12 d-flex flex-row-reverse"> 
                            <button class="btn btn-my-danger btn-sm" id="search" onclick="clear_form()" data-bs-toggle="modal" data-bs-target="#modal">
                                <i class="bi bi-plus-lg"></i> Add         
                            </button>
                            &nbsp;
                            <button class="btn btn-my-danger btn-sm" id="search"  data-bs-toggle="modal" data-bs-target="#modal_filter">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
                
                <table id="datatable" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">ID</th>
                        <th scope="col">Generic Name</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date Added</th>
                        <th scope="col">Expiration</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                    @foreach($items as $i)
                        @php 
                            $formatted_id = 'MDCN-'.str_pad($i->imi_id, 5, 0, STR_PAD_LEFT);
                            $quantity_avlbl = $i->imi_quantity-($i->dispose+$i->dispense);
                            if($qty=='1'){
                                if($quantity_avlbl==0){
                                    continue;
                                }
                            }
                            else{
                                if($quantity_avlbl>0){
                                    continue;
                                }
                            }
                        @endphp
                            <tr>
                                <td>{{ $formatted_id }}</td>
                                <td>{{ $i->imgn_generic_name }}</td>
                                <td>{{ $i->imb_brand }}</td>
                                <td>
                                
                                    Dispense: {{ ($i->dispense) ? $i->dispense : '0' }}<br>
                                    Dispose: {{ ($i->dispose) ? $i->dispose : '0' }}<br>
                                    Available: {{ $quantity_avlbl }}<br>
                                    Total: {{ $i->imi_quantity }}
                                </td>
                                <td><span class="badge 
                                        @if($i->imi_status=='1')
                                            bg-success
                                        @else
                                            bg-danger
                                        @endif
                                        ">{{ ($i->imi_status) ? 'For-dispensing' : 'On-Hold' }}</span></td>
                                <td>{{ date_format(date_create($i->imi_date_added), 'M d, Y') }}</td>
                                <td>{{ date_format(date_create($i->imi_expiration), 'M d, Y') }}</td>
                                <td>
                                    <a class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View Transaction Records"
                                        href="{{ route('Admin.Inventory.Medicine.Item.Transaction.Index', ['id'=>$i->imi_id]) }}">
                                        <i class="bi bi-journal-text"></i>
                                    </a>
                                    <button class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Dispose"
                                        @if($quantity_avlbl!=0)
                                            onclick="dispose('{{ $formatted_id }}', '{{ $i->imgn_generic_name }}', '{{ $i->imb_brand }}', '{{ $i->imi_expiration }}', '{{ $quantity_avlbl }}', '{{ $i->imi_id }}')"
                                        @else
                                            disabled
                                        @endif
                                        >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                        onclick="update_form('{{ $i->imi_id }}', '{{ $i->imgn_id }}', '{{ $i->imb_id }}', '{{ $i->imi_quantity }}', '{{ $i->imi_status }}', '{{ $i->imi_expiration }}', '{{ $i->imi_date_added }}')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                        @if($i->dispose || $i->dispense)
                                            disabled
                                        @else
                                            onclick="delete_form('{{ $formatted_id }}', '{{ $i->imi_id }}')"
                                        @endif
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

<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Add Medicine</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="modal-body">
                    <label class="form-control p-0 border-0">
                        Date Added:
                        <input type="date" name="date_added" id="date_added" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                        <div class="invalid-feedback" id="date_added_error"></div>
                    </label>

                    <label class="form-control p-0 border-0 mt-2">
                        Generic Name:
                        <select name="generic_name" id="generic_name" class="form-select form-select-sm">
                            <option value="">--- choose ---</option>
                            @foreach($generic as $g)
                                <option value="{{ $g->imgn_id }}" {{ ($g->imgn_status) ? '' : 'hidden' }}>{{ $g->imgn_generic_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="generic_name_error"></div>
                    </label>

                    <label class="form-control p-0 border-0 mt-2">
                        Brand:
                        <select name="brand" id="brand" class="form-select form-select-sm">
                            <option value="">--- choose ---</option>
                            @foreach($brand as $b)
                                <option value="{{ $b->imb_id }}" {{ ($b->imb_status) ? '' : 'hidden' }}>{{ $b->imb_brand }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="brand_error"></div>
                    </label>

                    <label class="form-control p-0 border-0 mt-2">
                        Quantity:
                        <input type="number" name="quantity" id="quantity" class="form-control form-control-sm">
                        <div class="invalid-feedback" id="quantity_error"></div>
                    </label>

                    <label class="form-control p-0 border-0 mt-2">
                        Status:
                        <select name="status" id="status" class="form-select form-select-sm">
                            <option value="0">On-hold</option>
                            <option value="1">For-dispensing</option>
                        </select>
                        <div class="invalid-feedback" id="status_error"></div>
                    </label>

                    <label class="form-control p-0 border-0 mt-2">
                        Expiration:
                        <input type="date" name="expiration" id="expiration" class="form-control form-control-sm">
                        <div class="invalid-feedback" id="expiration_error"></div>
                    </label>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-my-danger" id="form_submit">
                        <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_form"></div>
                        <div class="text-light" id="lbl_form">Add</div>
                    </button>
                </div>
            </form>
        </div>    
    </div>
</div>

<div class="modal fade" id="modal_dispose" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title_dispose">Dispose Medicine</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_dispose">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                
                <div class="modal-body">
                    <label class="form-control border-0 p-0">
                        ID:
                        <input type="text" name="dispose_id" id="dispose_id" class="form-control" value="{{ old('dispose_id') }}" readonly>
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Generic Name:
                        <input type="text" name="dispose_generic_name" id="dispose_generic_name" class="form-control" value="{{ old('dispose_generic_name') }}" readonly>
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Brand:
                        <input type="text" name="dispose_brand" id="dispose_brand" class="form-control" value="{{ old('dispose_brand') }}" readonly>
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Expiration:
                        <input type="date" name="dispose_expiration" id="dispose_expiration" class="form-control" value="{{ old('dispose_expiration') }}" readonly>
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Available:
                        <input type="number" name="dispose_available" id="dispose_available" class="form-control" value="{{ old('dispose_available') }}" readonly>
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Quantity to Dispose:
                        <input type="number" name="dispose_quantity" id="dispose_quantity" class="form-control" value="{{ old('dispose_quantity') }}">
                        <div class="invalid-feedback" id="dispose_quantity_error"></div>
                    </label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-my-danger" id="form_dispose_submit">
                        <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_form_dispose"></div>
                        <div class="text-light" id="lbl_form_dispose">Add</div>
                    </button>
                </div>
            </form>
        </div>    
    </div>
</div>

<div class="modal fade" id="modal_filter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_filter_dispose">Advanced Filter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('Admin.Inventory.Medicine.Item.Index') }}" method="GET" id="form_filter">
                <div class="modal-body">
                    @csrf
                    <label class="form-control border-0 p-0">
                        Quantity:
                        <select name="quantity" id="quantity" class="form-select">
                            <option value="1" {{ ($qty=='1') ? 'selected' : '' }}>Not Empty</option>
                            <option value="0" {{ ($qty=='0') ? 'selected' : '' }}>Empty</option>
                        </select>
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Status:
                        <select name="status" id="status" class="form-select">
                            <option value="1" {{ ($status=='1') ? 'selected' : '' }}>Not Expired</option>
                            <option value="2" {{ ($status=='2') ? 'selected' : '' }}>Expiring</option>
                            <option value="0" {{ ($status=='0') ? 'selected' : '' }}>Expired</option>
                        </select>
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Generic Name:
                        <select name="gn" id="gn" class="form-select">
                            <option value="">All</option>
                            @foreach($generic as $g)
                                <option value="{{ $g->imgn_id }}" {{ (old('gn', $gn)==('="'.$g->imgn_id.'"')) ? 'selected' : ''  }}>{{ $g->imgn_generic_name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Brand:
                        <select name="br" id="br" class="form-select">
                            <option value="">All</option>
                            @foreach($brand as $b)
                                <option value="{{ $b->imb_id }}" {{ (old('br', $br)==('="'.$b->imb_id.'"')) ? 'selected' : ''  }}>{{ $b->imb_brand }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Date Added:
                        <div class="row">
                            <label class="col-lg-6">
                                <select name="dam" id="dam" class="form-select">
                                    <option value="">All</option>
                                    @for($i=1; $i<=12; $i++){
                                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT); }}" {{ (old('dam', $dam)==('="'.str_pad($i, 2, '0', STR_PAD_LEFT).'"')) ? 'selected' : ''  }}>{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                    @endfor
                                </select>
                            </label>
                            <label class="col-lg-6">
                                <select name="day" id="day" class="form-select">
                                    <option value="">All</option>
                                    @for($i=date('Y'); $i>=2020; $i--)
                                        <option value="{{$i}}" {{ (old('day', $day)==('="'.$i.'"')) ? 'selected' : ''  }}>{{$i}}</option>
                                    @endfor
                                </select>
                            </label>
                        </div>
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Expiration:
                        <div class="row">
                            <label class="col-lg-6">
                                <select name="em" id="em" class="form-select">
                                    <option value="">All</option>
                                    @for($i=1; $i<=12; $i++){
                                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT); }}" {{ (old('em', $em)==('="'.str_pad($i, 2, '0', STR_PAD_LEFT).'"')) ? 'selected' : ''  }}>{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                    @endfor
                                </select>
                            </label>
                            <label class="col-lg-6">
                                <select name="ey" id="ey" class="form-select">
                                    <option value="" {{ (old('ey', $ey)=='all') ? 'selected' : '' }}>All</option>
                                    @for($i=date('Y'); $i>=2020; $i--)
                                        <option value="{{$i}}" {{ (old('ey', $ey)==('="'.$i.'"')) ? 'selected' : ''  }}>{{$i}}</option>
                                    @endfor
                                </select>
                            </label>
                        </div>
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
        datatable_class('#datatable');
        $('#hamburgerMenu').click(function(){
            setTimeout(function() { 
                redraw_datatable_class('#datatable');
            }, 300);
        });

        function dispose(id, gn, brand, expr, avlbl, imi_id){
            var url = "{{ route('Admin.Inventory.Medicine.Item.Dispose.Insert', ['id'=>'%id%']) }}";
            url = url.replace('%id%', imi_id);
            $('#dispose_id').val(id);
            $('#dispose_generic_name').val(gn);
            $('#dispose_brand').val(brand);
            $('#dispose_expiration').val(expr);
            $('#dispose_available').val(avlbl);
            $('#dipose_quantity').val(avlbl);
            $('#form_dispose').attr('action', url);
            $('#modal_dispose').modal('show'); 
        }

        function clear_form(){
            reset_inputs();
            $('#form').attr('action', "{{ route('Admin.Inventory.Medicine.Item.Insert') }}");
            $('#expiration, #generic_name, #brand', '#quantity').val('');
            $('#date_added').val("{{ date('Y-m-d') }}");
            $('#lbl_form').html('Add');
        }

        function update_form(id, gn, brand, qty, status, expr, da){
            reset_inputs();
            var url = "{{ route('Admin.Inventory.Medicine.Item.Update', ['id'=>'%id%']) }}";
            url = url.replace('%id%', id);
            $('#form').attr('action', url);
            $('#date_added').val(da);
            $('#generic_name').val(gn);
            $('#brand').val(brand);
            $('#quantity').val(qty);
            $('#status').val(status);
            $('#expiration').val(expr);
            $('#modal_title').html('Update Medicine');
            $('#lbl_form').html('Update');
            $('#modal').modal('show'); 
        }

        function delete_form(item, id){
            var url = "{{ route('Admin.Inventory.Medicine.Item.Delete', ['id'=>'%id%']) }}";
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

        $('#form_submit').click(function(){
            reset_inputs();
            load_btn('#lbl_form','#lbl_loading_form','#form_submit',true);

            var formData = new FormData($('#form')[0]);

            $.ajax({
                type: "POST",
                url: $('#form').attr('action'),
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
                load_btn('#lbl_form','#lbl_loading_form','#form_submit',false);
            });
        });

        $('#form_dispose_submit').click(function(){
            reset_inputs();
            load_btn('#lbl_form_dispose','#lbl_loading_form_dispose','#form_dispose_submit',true);

            var formData = new FormData($('#form_dispose')[0]);

            $.ajax({
                type: "POST",
                url: $('#form_dispose').attr('action'),
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
                load_btn('#lbl_form_dispose','#lbl_loading_form_dispose','#form_dispose_submit',false);
            });
        });
        
    </script>
@endpush