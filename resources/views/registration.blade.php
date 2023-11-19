<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Members Registration</title>
    <link rel="icon" type="image/x-icon" href="https://designreset.com/cork/html/src/assets/img/favicon.ico"/>


    <link href="{{ asset('assets/layouts/css/light/loader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/layouts/css/dark/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{asset('assets/layouts/loader.js')}}"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

    <link href="{{asset('assets/src/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('assets/layouts/css/light/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/layouts/css/dark/plugins.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('assets/src/assets/css/dark/authentication/auth-boxed.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/src/assets/css/light/authentication/auth-boxed.css')}}" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" href="{{ asset('assets/src/plugins/src/notification/snackbar/snackbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/css/dark/notification/snackbar/custom-snackbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/css/light/notification/snackbar/custom-snackbar.css') }}">
    <!-- END GLOBAL MANDATORY STYLES -->

</head>
<body class="form">

    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">

            <div class="row">

                <div class="col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12 mb-3">

                                    <h2>Insaf Lawyers Forum Balochistan (ILF)</h2>
                                    <p>Application form for (ILF) Membership</p>

                                </div>
                                <form action="{{url('/registration/store')}}" method="post" enctype="multipart/form-data">
                                    @csrf

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" required id="name" name="name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fname">Father Name</label>
                                                <input type="text" class="form-control" required id="fname" name="fname">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cnic">CNIC Number (Without Dashes)</label>
                                                <input type="text" class="form-control" required maxlength="13" id="cnic" name="cnic">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select class="form-select" required name="gender" id="gender">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dist">District</label>
                                                <input type="text" class="form-control" required id="dist" name="dist">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dob">Date of Birth</label>
                                                <input type="date" class="form-control" required id="dob" name="dob">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="row">
                                            <div class="col-12"> <label>Date of Enrollment</label></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lc">L.C</label>
                                                <input type="date" class="form-control" required id="lc" name="lc">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="hc">H.C</label>
                                                <input type="date" class="form-control" required id="hc" name="hc">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="sc">S.C</label>
                                                <input type="date" class="form-control" required id="sc" name="sc">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="barReg">Bar Registration Number</label>
                                                <input type="text" class="form-control" required id="barReg" name="barReg">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Phone Number</label>
                                                <input type="text" class="form-control" required id="phone" name="phone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email Address</label>
                                                <input type="email" class="form-control" required id="email" name="email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="addr">Office Address</label>
                                                <input type="text" class="form-control" required id="addr" name="addr">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="photo">Passport Size Image</label>
                                                <input type="file" id="photo" name="photo" class="form-control" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <img id="photoPreview" src="#" alt="Image Preview" style="display: none; max-width: 150px; max-height: 150px;">
                                        </div>
                                        <div class="col-md-4">
                                            * Fresh Photograph with blue background
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cnicF">CNIC Front</label>
                                                <input type="file" id="cnicF" name="cnicF" class="form-control" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <img id="cnicFPreview" src="#" alt="Image Preview" style="display: none; max-width: 200px; max-height: 100px;">
                                        </div>
                                        <div class="col-md-4">
                                            * Must be a clear/readable image
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cnicB">CNIC Back</label>
                                                <input type="file" id="cnicB" name="cnicB" class="form-control" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <img id="cnicBPreview" src="#" alt="Image Preview" style="display: none; max-width: 200px; max-height: 100px;">
                                        </div>
                                        <div class="col-md-4">
                                            * Must be a clear/readable image
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="bCard">Bar Council Card</label>
                                                <input type="file" id="bCard" name="bCard" class="form-control" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <img id="bCardPreview" src="#" alt="Image Preview" style="display: none; max-width: 200px; max-height: 100px;">
                                        </div>
                                        <div class="col-md-4">
                                            * Must be a clear/readable image
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="license">Licenses</label>
                                                <input type="file" id="license" name="license" class="form-control" accept=".pdf">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <embed id="licensePreview" src="#" alt="Image Preview" style="display: none; max-width: 300px; max-height: 400px;">
                                        </div>
                                        <div class="col-md-4">
                                            * Upload a PDF file. If you want to upload more than one license, combine all the license documents into a single PDF
                                        </div>

                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <div class="alert alert-warning">
                                                    * Please carefully review the form before proceeding, as it cannot be changed after submission.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">

                                                <button type="submit" class="btn btn-success">Apply for Registration</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                               {{--  <div class="col-12 mb-4">
                                    <div class="">
                                        <div class="seperator">
                                            <hr>
                                            <div class="seperator-text"> <span>Forgotten Password?</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="text-center">
                                       <p class="btn btn-default" id="reset" onclick="resetPassword()" class="text-warning">Reset Password</p>
                                    </div>
                                </div> --}}

                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © <span class="dynamic-year">{{date('Y')}}</span> <a target="_blank" href="#">Diamond Software House</a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
                </div>
            </div>
        </div>

    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('assets/src/plugins/src/jquery-ui/jquery.min.js') }}"></script>
    <script src="{{asset('assets/src/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/src/plugins/src/notification/snackbar/snackbar.min.js') }}"></script>


    <!-- END GLOBAL MANDATORY SCRIPTS -->

    @if(Session::get('msg'))
<script>
    var msg = "{{Session::get('msg')}}";
    Snackbar.show({
    text: msg,
    duration: 3000,
    actionTextColor: '#fff',
   backgroundColor: '#00ab55'
});
</script>
@endif
@if(Session::get('error'))
<script>
    var msg = "{{Session::get('error')}}";
    Snackbar.show({
    text: msg,
    duration: 3000,
    actionTextColor: '#fff',
   backgroundColor: '#e7515a'
});
</script>
@endif
<script>
    $(document).ready(function () {
    // Listen for changes in the file input
    $("#photo").change(function () {
        // Get the selected file
        var file = this.files[0];
        if (file) {
            // Create a FileReader
            var reader = new FileReader();
            // Set a function to run when the file is loaded
            reader.onload = function (e) {
                // Set the source of the image element to the Data URL
                $("#photoPreview").attr("src", e.target.result);
                // Display the image element
                $("#photoPreview").show();
            };
            // Read the file as a Data URL
            reader.readAsDataURL(file);
        }
    });

    $("#cnicF").change(function () {
        // Get the selected file
        var file = this.files[0];
        if (file) {
            // Create a FileReader
            var reader = new FileReader();
            // Set a function to run when the file is loaded
            reader.onload = function (e) {
                // Set the source of the image element to the Data URL
                $("#cnicFPreview").attr("src", e.target.result);
                // Display the image element
                $("#cnicFPreview").show();
            };
            // Read the file as a Data URL
            reader.readAsDataURL(file);
        }
    });

    $("#cnicB").change(function () {
        // Get the selected file
        var file = this.files[0];
        if (file) {
            // Create a FileReader
            var reader = new FileReader();
            // Set a function to run when the file is loaded
            reader.onload = function (e) {
                // Set the source of the image element to the Data URL
                $("#cnicBPreview").attr("src", e.target.result);
                // Display the image element
                $("#cnicBPreview").show();
            };
            // Read the file as a Data URL
            reader.readAsDataURL(file);
        }
    });
    $("#bCard").change(function () {
        // Get the selected file
        var file = this.files[0];
        if (file) {
            // Create a FileReader
            var reader = new FileReader();
            // Set a function to run when the file is loaded
            reader.onload = function (e) {
                // Set the source of the image element to the Data URL
                $("#bCardPreview").attr("src", e.target.result);
                // Display the image element
                $("#bCardPreview").show();
            };
            // Read the file as a Data URL
            reader.readAsDataURL(file);
        }
    });
    $("#license").change(function () {
        // Get the selected file
        var file = this.files[0];
        if (file) {
            // Create a FileReader
            var reader = new FileReader();
            // Set a function to run when the file is loaded
            reader.onload = function (e) {
                // Set the source of the image element to the Data URL
                $("#licensePreview").attr("src", e.target.result);
                // Display the image element
                $("#licensePreview").show();
            };
            // Read the file as a Data URL
            reader.readAsDataURL(file);
        }
    });
});

</script>
</body>
</html>
