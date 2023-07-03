@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, inBCAitial-scale=1.0">
    <title>Document</title>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="container"">
                            <h1>{{ Auth::user()->name }} Information Form</h1>
                            @if ($errors->any())
                                <div class=" alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        {{ Auth::user()->name }}
                        <span id="field_error"></span>
                        <form action="#" method="POST" id="add" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"
                                    value="{{ old('name') }}">
                                <!-- <span class="error">
                                    your name is mssing
                                </span> -->
                            </div>

                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter email" value="{{ old('email') }}">
                                <small id="emailvalid">Your email must be a valid email</small>
                                <!-- <span class="error">
                                    your email is missing
                                </span> -->
                            </div>


                            <div class="form-group">
                                <label for="name">Date Of Birth</label>
                                <input type="date" class="form-control" name="birth_date" id="date_of_birth"
                                    max="<?php echo date("Y-m-d"); ?>" value="{{ old('birth_date') }}">
                            </div>

                            <div class="form-group">
                                <label for="phone">Contact</label>
                                <input type="tel" name="phone" id="phone" class="form-control"
                                    value="{{ old('phone') }}" autocomplete="off" maxlength="10" required>
                                <span class="text-danger " id="phone_error"></span>
                            </div>

                            <div class="form-group">
                                <label for="qualification">Qualification</label>
                                <select name="qualification" class="form-control" id="qualification">
                                    <option value="{{ old('qualification') }}">{{ old('qualification') }}</option>
                                    <option value="b.tech">B.TECH</option>
                                    <option value="MBA">MBA</option>
                                    <option value="BSC">BSC</option>
                                    <option value="BCA">BCA</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sports">Sports</label>
                                <select class="dynamic-option-create-multiple form-control" name="sports[]" id="sports">
                                    <option></option>
                                    <option value="cricket">Cricket</option>
                                    <option value="volleyball">Volleyball</option>
                                    <option value="football">Football</option>
                                    <option value="kabaddi">Kabaddi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Gender:</label>
                                <input type="radio" name="gender" value="male" id="male" style="margin-left: 5%;">
                                <label for="male">Male</label>
                                <input type="radio" name="gender" value="female" id="female" style="margin-left: 5%;">
                                <label for="female">Female</label>
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control"
                                    value="{{ old('address') }}"></textarea>
                            </div>

                            <!-- <div class="form-group">
                                <label for="image">Upload Profile Picture:</label>
                                <input type="file" name="image" id="image" accept="image/*" value="{{ old('image') }}">
                            </div><div class="form-group"> -->
                            <label for="image">Upload excel data:</label>
                            <input type="file" name="image" id="image" value="{{ old('image') }}">
                            <span class="text-danger " id="image_error"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="add_btn" class="btn btn-primary" style="float: right;">update</button>

                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
</body>
<script>
$("#add").submit(function(e) {
    e.preventDefault();
    $('#add_btn').html('loading...');
    var fd = new FormData(this);
    $.ajax({
        url: "{{ route('crud.store') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(data) {
            $('#add')[0].reset();
            $.alert({
                title: 'Added!',
                content: 'data Added Successfully!',
            });
            $('#add_btn').html('update');
        },
        error: function(reject) {
    if (reject.status === 422) {
        var errorResponse = $.parseJSON(reject.responseText);
        console.log(errorResponse);

        // Display the general error message
        console.log(errorResponse.message);

        // Iterate over the errors object
        $.each(errorResponse.errors, function(key, val) {
            console.log(key);
            console.log(val[0]); // Display the error message for each field
            
            // Display the error message on the form, assuming you have corresponding elements
            $("#" + key + "_error").text(val[0]);
        });
    }
}



    });

});

// $(document).ready(function() {
//     $('.error').hide();
//     $('#add_btn').click(function(e) {
//         var name = $('#name').val();
//         var email = $('#email').val();
//         var dob = $('#date_of_birth').val();
//         var phone = $('#phone').val();
//         var qualify = $('#qualification').val();
//         var gender = $('input[name="gender"]:checked').val();
//         var address = $('#address').val();
//         var fileInput = document.getElementById('image');
//         var filePath = fileInput.value;
//         var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.jfif)$/i;
//         if (name == '') {
//             $.alert({
//                 title: 'required!',
//                 content: 'Please Enter Your name!',
//             });
//             return false;
//         }

//         if (email == '') {
//             $.alert({
//                 title: 'required!',
//                 content: 'Please Enter Your Email!',
//             });
//             return false;
//         }

//         if (dob == '') {
//             $.alert({
//                 title: 'required!',
//                 content: 'Please Enter Your Date Of Birth!',
//             });
//             return false;
//         }

//         if (phone == '') {
//             $.alert({
//                 title: 'required!',
//                 content: 'Please Enter Your Phone Number!',
//             });
//             return false;
//         }

//         if (qualify == '') {
//             $.alert({
//                 title: 'required!',
//                 content: 'Please Select Qualification!',
//             });
//             return false;
//         }

//         if (!gender) {
//             $.alert({
//                 title: 'required!',
//                 content: 'Please Select Gender!',
//             });
//             return false;
//         }

//         if (address = '') {
//             $.alert({
//                 title: 'required!',
//                 content: 'Please Enter Your Address!',

//             });
//             return false;
//         }

//         if ($('#image').get(0).files.length === 0) {
//             e.preventDefault();
//             $.alert({
//                 title: 'required!',
//                 content: 'Pleace Upload Profile!',
//             });
//             return false;
//         }

//         if (!allowedExtensions.exec(filePath)) {
//             $.alert({
//                 title: 'required!',
//                 content: 'Invalid file type. Please upload an image file (JPG, JPEG, PNG ).',
//             });
//             fileInput.value = '';
//             return false;
//         }
//     })
// });
// $(document).ready(function() {
//     $("select.dynamic-option-create-multiple").select2({
//         tags: true,
//         multiple: true
//     });

// });
</script>

</html>
@endsection