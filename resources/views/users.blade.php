@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>

<head>
    <title>datas</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<body>

    <!-- edit form -->
    <div class="container">
        <div class="modal fade" id="userinfo" aria-hidden="true">
            <div class=" modal-dialog">
                <div class=" modal-content">
                    <div class=" modal-header">
                        <div class="modal-body">
                            <h4 class="modal-title" id="title"></h4>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container">
        <h1>{{ Auth::user()->name }}<h1>
                <h1>{{ session('user') }}</h1>
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>DOB</th>
                            <th>contact</th>
                            <th>qualify</th>
                            <th>gender</th>
                            <th>address</th>
                            <th>file</th>
                            <th width="100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
    </div>



    <script type="text/javascript">
    //show data 
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('show') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },

                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'birth_date',
                    name: 'birth_date'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'qualification',
                    name: 'qualification'
                },
                {
                    data: 'gender',
                    name: 'gender'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'img_file',
                    name: 'img_file'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });


        //delete
        $('body').on('click', '.delete', function() {

            var id = $(this).data("id");
            $.confirm({
                title: 'Confirm!',
                content: 'are you sure you want to delete data!',
                buttons: {
                    confirm: function() {
                        $.alert('your data has been deleted!');
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('crud.destroy', 'id') }}".replace('id', id),
                            success: function(data) {
                                table.draw();
                            },
                            error: function(data) {
                                console.log('Error:', data);
                            }
                        });
                    },
                    cancel: function() {
                        $.alert('Canceled!');
                    },

                }
            });


        });


        //edit
        $('body').on('click', '.edit', function() {
            var id = $(this).data('id');
           
                $.confirm({
                    title: 'Confirm!',
                    content: 'are you sure you want to edit data!',
                    buttons: {
                        confirm: function() {

                            $.ajax({
                                type: 'GET',
                                url: "{{ route('crud.edit', 'id') }}".replace('id', id),
                                success: function(data) {
                                
                                    $('#title').html("Edit ");
                                    $('#userinfo').modal('show');
                                    $('#id').val(data.id);
                                    $('#name').val(data.name);
                                    $('#email').val(data.email);
                                    $('#date_of_birth').val(data.birth_date);
                                    $('#phone').val(data.phone);
                                    $('input[name="gender"][value="' + data.gender +'"]').prop('checked', true);
                                    $('#qualification').val(data.qualification);
                                    $('#address').val(data.address);
                                    
                                    $("#image_name1").html('<img src="/storage/assets/images/'+ data.file +'" alt="image" width="100" class="img-fluid img-thumbnail">');
                                    alert('<img src="storage/assets/images/'+ data.file +'" alt="image" width="100" class="img-fluid img-thumbnail">')
                                },

                                error: function(data) {
                                    console.log('Error:', data);
                                }
                            });
                        },
                        cancel: function() {
                            $.alert('Canceled!');
                        },

                    }
                });
        
        });


        //update
        $('body').on('click', '#update', function(data) {
            data.preventDefault();
            var id = $('#id').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var birth_date = $('#date_of_birth').val();
            var phone = $('#phone').val();
            var qualification = $('#qualification').val();
            var gender = $('input[name="gender"]:checked').val();
            var address = $('#address').val();
            var file = $('#image')[0].files[0];

            var formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('_method', 'PUT');
            formData.append('id', id);
            formData.append('name', name);
            formData.append('email', email);
            formData.append('birth_date', birth_date);
            formData.append('phone', phone);
            formData.append('gender', gender);
            formData.append('qualification', qualification);
            formData.append('address', address);
            formData.append('image', file);

            $.ajax({
                type: 'POST',
                url: "{{ route('crud.update', 'id') }}".replace('id', id),
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log(data);
                    $('#userinfo').modal('hide');
                    window.location.reload();

                },

                error: function(data) {
                    console.log('Error:', data);
                }
            });

        });

    });
    </script>
</body>

</html>
@endsection