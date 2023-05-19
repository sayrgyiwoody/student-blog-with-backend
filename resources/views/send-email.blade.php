<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid p-5">
        <div class="row d-flex align-items-center" style="height: 100vh">
            <div class="col-lg-4 offset-lg-4 px-4 py-3 shadow">
                <div class="alert alert-success">
                    You are approved by admin now verify your email !
                </div>
                <h3>Verify your email</h3>
                <p class="text-muted">We will send code to your email.</p>
                <hr>
                <label class="form-lable mb-2">Your Email</label>
                <input type="text" value="{{Auth::user()->email}}" class="form-control mb-3" readonly>
                <form action="{{route('auth#sendCode')}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Send Code</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
