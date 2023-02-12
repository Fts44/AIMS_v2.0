@extends('Layouts.AdminMain')

@push('title')
    <title>Announcement</title>
@endpush

@section('content')
<main id="main" class="main">
    <div class="pagetitle mb-2">
        <h1 class="mb-1">Announcement</h1>
        <div class="page-nav">
        </div>
    </div>
    <section class="section mt-2">

        <div class="row d-flex justify-content-around">
            <div class="col-lg-2">
                <div class="card">
                    <button type="button" class="btn btn-sm btn-my-danger" data-bs-toggle="modal" data-bs-target="#modal" onclick='post_clear()'><i class="bi bi-plus-circle"></i> Add</button>
                </div>
            </div>

            <div class="col-lg-10">
                @foreach($announcements as $a)
                    <div class="card col-lg-8 mx-2" style="margin-left: 20px;">
                        <div class="card-body p-4">  
                            <h5><b>{{ $a->anm_title }}</b></h5>
                            <label>Status: 
                                @if($a->anm_active_until>=date('Y-m-d'))
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Not Active</span>
                                @endif
                            </label>
                            <br><br>

                            <textarea class="a-body" id="{{ $a->anm_id }}" borderless>
                                {{ $a->anm_body }}
                            </textarea>

                            <label class="mt-4 action-button">
                                <button class="btn btn-sm btn-primary" onclick='post_edit("{{ $a->anm_id }}","{{ $a->anm_active_until }}","{{ $a->anm_title }}")'><i class="bi bi-pencil"></i> Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="post_delete('{{ $a->anm_id }}')"><i class="bi bi-eraser"></i> Delete</button>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>        
        
    </section>

    {{ $announcements->links() }}
</main>

    <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">Add New Announcement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="form_announcement">
                    <div class="modal-body">
                        <label class="form-control border-0 p-0 mb-3">
                            Active Until:
                            <input type="date" name="active_until" id="active_until" class="form-control form-control-sm">
                            <span class="invalid-feedback" id="active_until_error"></span>
                        </label>

                        <label class="form-control border-0 p-0 mb-3">
                            Title:
                            <input type="text" name="title" id="title" class="form-control form-control-sm">
                            <span class="invalid-feedback" id="title_error"></span>
                        </label>

                        <label class="form-control border-0 p-0 mb-3">
                            Body:
                            <textarea name="body" id="body"></textarea>
                            <span class="invalid-feedback" id="body_error"></span>
                        </label>

                        <label class="form-control border-0 p-0 mb-3">
                            Send as Email messages:
                            <select name="send_as_email" id="send_as_email" class="form-select form-select-sm">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                            <div class="invalid-feedback" id="send_as_email_error"></div>
                        </label>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-my-danger btn-sm" id="announcement_save">
                            <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_announcement"></div>
                            <div class="text-light" id="lbl_announcement">Add</div>
                        </button>
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
        const divArea = tinymce.init({
            selector: "textarea.a-body",
            plugins: ['autoresize'],
            menubar:false,
            statusbar: false,
            toolbar: false,
            readonly: true,
            skin: 'naked'
        });

        const textArea = tinymce.init({
            selector: "textarea#body",
            height: 200,
            plugins: [
                'lists'
            ],
            menubar:false,
            statusbar: false,
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist',
            spellchecker_dialog: true,
            skin: 'jam',
            icons: 'jam',

        });

        function post_clear(){
            reset_inputs();
            $('#lbl_announcement').html('Add');
            $("#form_announcement").attr('action', "{{ route('Admin.Announcement.Insert') }}");
            $('#modal_title').html('Add Announcement');
            $('#id').val('');
            $('#title').val('');
            $('#active_until').val('');
            tinymce.get('body').setContent('');
            $('#modal').modal('show');
        }

        function post_edit(id, active_until, title){
            var url = "{{ route('Admin.Announcement.Update', ['id'=>'%id%']) }}";
            url = url.replace('%id%', id);
            $('#lbl_announcement').html('Update');
            $('#modal_title').html('Update Announcement');
            $('#form_announcement').attr('action', url);
            $('#title').val(title);
            $('#active_until').val(active_until);
            tinymce.get('body').setContent(tinymce.get(id).getContent());
            $('#modal').modal('show');
        }

        function post_delete(id){
            swal({
                title: 'Warning',
                text: ('Your about to delete anouncement #'+id),
                icon: 'warning',
                buttons: ["Cancel", "Yes"],
                dangerMode: true,
            }).then(function(value) {
                if(value){
                    var url = "{{ route('Admin.Announcement.Delete', ['id'=>'%id%']) }}";
                    url = url.replace('%id%', id);
                    console.log(url);
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            "_token": "{{csrf_token()}}",
                        },
                        success: function(response){
                            console.log(response);
                            response = JSON.parse(response);
                            swal(response.title,response.message,response.icon).then(function() {
                                location.reload();
                            });
                        },
                        error: function(response){
                            console.log(response);
                        }
                    })
                }
            });
        }

        $('#announcement_save').click(function(){
            reset_inputs();
            load_btn('#lbl_announcement','#lbl_loading_announcement','#announcement_save',true);

            $.ajax({
                type: "POST",
                url: $('#form_announcement').attr('action'),
                data: {
                    "_token": "{{csrf_token()}}",
                    "send_as_email": $('#send_as_email').val(),
                    "active_until": $('#active_until').val(),
                    "title": $('#title').val(),
                    "body": tinymce.get("body").getContent()
                },
                success: function(response){
                    console.log(response);
                    response = JSON.parse(response);
                    
                    if(response.status == 400){
                        swal(response.title, response.message, response.icon);
                        $.each(response.errors, function(key, err_values){
                            $('#'+key+'_error').html(err_values);
                            $('#'+key).addClass('is-invalid');
                        });
                    }
                    else{
                        swal(response.title, response.message, response.icon).then(function() {
                            history.go(0);
                        });
                    }
                },
                error: function(response){
                    console.log(response);
                }
            }).always(function(){
                load_btn('#lbl_announcement','#lbl_loading_announcement','#announcement_save',false);
            });
        });
    </script>
@endpush