@extends('layouts.app')


@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- export  -->
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>

<!-- pdf -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>


<style>
.dt-buttons {
    display: inline-block;
    margin-left: 5%;
}


.dt-buttons .custom-button {
    background-color: #e0e0e0;
    color: #000000;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
    margin-right: 10px;
}

.dt-buttons .custom-button:first-child {
    margin-left: 0;
}

.dt-buttons .custom-button:last-child {
    margin-right: 0;
}

.dt-buttons .custom-button:hover {
    background-color: #bdbdbd;
}

hr {
    margin: 5px 0 15px 0;
}

.btn-group {
    position: absolute;
}
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <input type="hidden" name="_token" id="csrf_token" value="{!! csrf_token() !!}">
                <div class="row">
                    <h4 class="card-title">
                        Filter Option
                    </h4>
                </div>
                <hr>

                <div class="row">
                   <div class="col-md-4">
                        <div class="row">
                            <label for="from_date" class="col-lg-4 col-form-label"style="text-align:right;">From and to</label>
                            <div class="col-lg-8" style="padding:0;">
                                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2" style="text-align:center;">

                        <input type="submit" id="report" class="btn btn-primary waves-effect waves-light"
                            value="filter">
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


    <!-- edit form -->
    <div class="container">
        <div class="modal fade" id="userinfo" aria-hidden="true">
            <div class=" modal-dialog">
                <div class=" modal-content">
                    <div class=" modal-header">
                        <div class="modal-body">
                            <h4 class="modal-title" id="title"></h4>
                            <form>
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" name="image_name" id="image_name">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter name">
                                    <!-- <span class="error">
                                        your name is mssing
                                    </span> -->
                                </div>

                                <div class="form-group">
                                    <label for="name">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter email">
                                    <small id="emailvalid">Your email must be a valid email</small>
                                    <!-- <span class="error">
                                        your email is missing
                                    </span> -->
                                </div>


                                <div class="form-group">
                                    <label for="date_of_birth">Date Of Birth</label>
                                    <input type="date" class="form-control" name="date_of_birth" id="date_of_birth"
                                        max="<?php echo date("Y-m-d"); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="phone">Contact</label>
                                    <input type="tel" name="phone" id="phone" class="form-control" autocomplete="off"
                                        maxlength="10" required>
                                </div>

                                <div class="form-group">
                                    <label for="qualification">Qualification</label>
                                    <select name="qualification" class="form-control" id="qualification">
                                        <option></option>
                                        <option value="b.tech">B.TECH</option>
                                        <option value="MBA">MBA</option>
                                        <option value="BSC">BSC</option>
                                        <option value="BCA">BCA</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Gender:</label>
                                    <input type="radio" name="gender" value="male" id="gender" style="margin-left:5%;">
                                    <label for="male">Male</label>
                                    <input type="radio" name="gender" value="female" id="gender"
                                        style="margin-left:5%;">
                                    <label for="female">Female</label>
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="image">Upload Profile Picture:</label>
                                    <input type="file" name="image" id="image" accept="image/*">
                                    <div class="mt-2" id="image_name1"></div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="update" class="btn btn-primary"
                                        style="float: right;">update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="row" id="report_div" style="display:none;">
    <div class="col-12">
        <div class="card">
            <div class="card-body">



                <div class="mb-3 row">

                    <div class="col-md-12">

                        <table class="table table-bordered dt-responsive nowrap data-table"
                            style="border-collapse: collapse; background:#fff; border-spacing: 0; width: 100%;">
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
                                    <th>created</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<script>
// $(document).ready(function() {
//     $("#from_date,#to_date").datepicker({
//         dateFormat: 'dd-mm-yy',

//     });
// });

$(function() {
    var start = moment();
    var end = moment();
    var fromDate; // Declare fromDate variable
    var toDate; // Declare toDate variable

    function cb(selectedStart, selectedEnd) {
        $('#reportrange span').html(selectedStart.format('MMMM D, YYYY') + ' - ' + selectedEnd.format('MMMM D, YYYY'));
        fromDate = selectedStart.format('YYYY-MM-DD'); // Assign value to fromDate
        toDate = selectedEnd.format('YYYY-MM-DD'); // Assign value to toDate
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

        $('#report').click(function() {
            $("#report_div").show();
            $(".data-table").DataTable().destroy();
            var from_date = fromDate;
            var to_date = toDate;
            var tempcsrf = $('#csrf_token').val();
            var table = $('.data-table').DataTable({
                "scrollX": true,
                "order": [1, 'asc'],
                "pageLength": 10,
                "processing": true,
                "serverSide": true,
                "paging": true,
                "ordering": false,
                "info": true,
                "searching": true,
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": true,
                    "searchable": true,
                }],
                dom: 'lBfrtip',
                buttons: [{
                        extend: 'excel',
                        className: 'custom-button'
                    },
                    {
                        extend: 'csv',
                        className: 'custom-button'
                    },
                    {
                        extend: 'pdf',
                        className: 'custom-button'
                    },
                    {
                        extend: 'copy',
                        className: 'custom-button'
                    }
                ],
                ajax: {
                    url: "{{ route('users.index') }}",
                    type: "POST",
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        _token: tempcsrf,
                    }
                },
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
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            return data.split('T')[0];
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });



        });

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

</script>
@endsection



