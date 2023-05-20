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
        <div class="row mt-4">
            <div class="col-lg-4 offset-lg-4 px-4 py-3 shadow">

                <h3>Admin Approve</h3>
                <p>Click next to check for admin approve.</p>
                @if (session('message'))
                <div class="alert alert-danger">
                    {{session('message')}}
                </div>
                @endif
                <hr>
                <form action="{{route('auth#approveRequest')}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Next</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    @if (session('error'))

        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Oops...',
                text: 'you are not still approved by admin',
                showConfirmButton: true,
            })
        </script>

    @endif

</body>
</html>
