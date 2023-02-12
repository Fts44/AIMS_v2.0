@extends('Layouts.AdminMain')

@push('title')
    <title>Inventory Equipment</title>
@endpush

@section('content')
<main id="main" class="main">
    <div class="pagetitle mb-2">
        <h1>Equipment Inventory</h1>
        <div class="page-nav">
            <nav class="btn-group">   
                <a href="{{ route('Admin.Inventory.Equipment.All.Index') }}" class="btn btn-sm btn-outline-danger">All</a>
                <a href="" class="btn btn-sm btn-outline-danger active">Item</a>
                <a href="" class="btn btn-sm btn-outline-danger">Report</a>
            </nav>
        </div>
    </div>
    
    <section class="section mt-2">

        <div class="card" id="card-table">

            <div class="card-body pt-4">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <span class="fw-bold sub-heading mb-1">Place</span>
                        <span class="btn btn-my-danger btn-sm w-auto p-auto" style="float: right; height: 30px;" onclick="clear_form()" data-bs-toggle="modal" data-bs-target="#modal"> 
                            <i class="bi bi-plus-circle"></i>  Add
                        </span>
                    </div>
                </div>
                <table id="datatable" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">ID</th>
                        <th scope="col">Description</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Place</th>
                        <th scope="col">Condition</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                        @foreach($inventory_items as $item)
                        <tr>
                            <td>{{ 'ITM-'.str_pad($item->iei_id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>
                               NAME: {{ $item->ien_name }} <br>
                               TYPE: {{ $item->iet_type }} <br>
                               BRAND: {{ $item->ieb_brand }} <br>
                            </td>
                            <td>{{ $item->iei_qty.' '.$item->ieid_unit }}</td>
                            <td>{{ $item->iep_place }}</td>
                            <td>
                                <span class="badge 
                                @if($item->iei_condition=='1')
                                    bg-success
                                @else
                                    bg-danger
                                @endif
                                ">{{ ($item->iei_condition) ? 'Working' : 'Not working' }}</span>
                            </td>
                            <td>{{ $item->iei_date_added }}</td>
                            <td>
                                <button class="btn btn-secondary btn-sm"  onclick="copy('{{ $item->ieid_id }}', '{{ $item->iei_qty }}', '{{ $item->iei_condition }}', '{{ $item->iep_id }}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy and Insert">
                                    <i class="bi bi-link-45deg"></i>
                                </button>
                                <button class="btn btn-primary btn-sm" onclick="update_form('{{ $item->iei_id }}','{{ $item->ieid_id }}', '{{ $item->iei_qty }}', '{{ $item->iei_date_added }}', '{{ $item->iei_condition }}', '{{ $item->iep_id }}')"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="delete_form('{{ $item->iei_id }}', '{{ $item->ien_name.(($item->iet_type!='none') ? ', '.$item->iet_type : ' ' ).(($item->ieb_brand!='none') ? ' ('.$item->ieb_brand.')' : '').$item->iei_id }}');"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
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
                    <h5 class="modal-title" id="modal_title">Add New Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <label class="form-control border-0 p-0 mb-3">
                            Item:
                            <select name="item" id="item" class="form-select form-select-sm">
                                <option value="">--- choose ---</option>
                                @foreach($item_details as $item)
                                    <option value="{{ $item->ieid_id }}" {{($item->ieid_status) ? '' : 'hidden' }} {{ (old('item')==$item->ieid_id) ? 'selected' : '' }}>{{ $item->ien_name.(($item->iet_type!='none') ? ", ".$item->iet_type : ' ' ).(($item->ieb_brand!='none') ? " (".$item->ieb_brand.")" : '') }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="item_error"></div>
                        </label>

                        <label class="form-control border-0 p-0 mb-3">
                            Quantity:
                            <input type="number" name="quantity" id="quantity" class="form-control form-control-sm" value="1">
                            <div class="invalid-feedback" id="quantity_error"></div>
                        </label>

                        <label class="form-control border-0 p-0 mb-3">
                            Date Added:
                            <input type="date" name="date_added" id="date_added" class="form-control form-control-sm" value="{{ old('date_added',date('Y-m-d')) }}">
                            <div class="invalid-feedback" id="date_added_error"></div>
                        </label>

                        <label class="form-control border-0 p-0 mb-3" id="date_condition">
                            Date of Update:
                            <input type="date" name="date_condition_update" id="date_condition_update" class="form-control form-control-sm" value="{{ old('date_condition_update',date('Y-m-d')) }}">
                            <div class="invalid-feedback" id="date_condition_update_error"></div>
                        </label>

                        <label class="form-control border-0 p-0 mb-3">
                            Condition:
                            <select name="condition" id="condition" class="form-select">
                                <option value="">--- choose ---</option>
                                <option value="1">Working</option>
                                <option value="0">Not working</option>
                            </select>
                            <div class="invalid-feedback" id="condition_error"></div>
                        </label>
                        
                        <label class="form-control border-0 p-0 ">
                            Place:
                            <select name="place" id="place" class="form-select">
                                <option value="">--- choose ---</option>
                                <option value="1">none</option>
                                @foreach($places as $item)
                                    <option value="{{ $item->iep_id }}" {{ ($item->iep_status) ? '' : 'hidden' }}>{{ $item->iep_place }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="place_error"></div>
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

    <form id="delete_form" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
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

        function clear_form(){
            reset_inputs();
            $('#form').attr('action', "{{ route('Admin.Inventory.Equipment.Item.Insert') }}");
            $('#lbl_form').html('Add');
            $('#item, #place, #condition').val('');
            $('#quantity').attr('readonly', false);
            $('#date_added').val("{{ date('Y-m-d') }}");
            $('#date_condition').addClass('d-none');
        }
        
        function update_form(id, item, qty, date_added, condition, place){
            clear_form();
            var url = "{{ route('Admin.Inventory.Equipment.Item.Update', ['id'=>'%id%']) }}";
            $('#form').attr('action', url.replace('%id%', id));
            $('#lbl_form').html('Update');
            $('#item').val(item);
            $('#quantity').val(qty);
            $('#quantity').attr('readonly', true);
            $('#date_added').val(date_added);
            $('#date_condition').removeClass('d-none');
            $('#condition').val(condition);
            $('#place').val(place);
            $('#modal_title').html('Update Item Details');
            $('#submit_button').html('Update');
            $('#modal').modal('show'); 
        }
        
        function copy(item, qty, condition, place){
            clear_form();
            $('#item').val(item);
            $('#quantity').val(qty);
            $('#quantity').attr('readonly', false);
            $('#date_condition').addClass('d-none');
            $('#condition').val(condition);
            $('#place').val(place);
            $('#modal').modal('show'); 
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

        function delete_form(id, place){
            var url = "{{ route('Admin.Inventory.Equipment.Item.Delete', ['id'=>'%id%']) }}";
            url = url.replace('%id%', id)
            swal({
                title: "Are you sure?",
                text: "Your about to delete "+place+"!",
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