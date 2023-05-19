<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Add SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.min.js"></script>

    <!-- Add SweetAlert styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col-lg-4 offset-lg-4 shadow px-4 py-3">
                <h4>Verify Email</h4>
                <hr>
                <p class="text-muted">Enter the verification code that we have sent to your gmail. Note that the email will be found at gmail spam for the first time.</p>
                @error('code')
                    <div class="alert alert-danger">
                        Code incorrect!
                    </div>
                @enderror
                    <div class="alert alert-success">
                        We have sent code to your email.
                    </div>
                <form action="{{route('auth#checkCode')}}" method="post" autocomplete="off">
                    @csrf
                    <label for="code" class="form-label">Verification Code</label>
                    <input type="text" placeholder="Enter verification code" name="code"  class="form-control">
                    <button type="submit" class="mt-3 btn btn-primary">Check</button>
                </form>
                <a href="{{route('auth#dashboard')}}" class="btn bg-white text-dark mt-3">Back</a>
            </div>
        </div>
    </div>
    @if (session('error'))

        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                showConfirmButton: true,
            })
        </script>

    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>


