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
        <div class="row">
            <div class="col-lg-4 offset-lg-4 shadow px-4 py-3">
                <h4>Forgot password</h4>
                <hr>
                <p class="text-muted">Enter your email address and we will send you a link to reset your password.</p>
                @if (Session::get('fail'))
                    <div class="alert alert-danger">
                        {{Session::get('fail')}}
                    </div>
                @endif
                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif
                <form action="{{route('forgot.password.link')}}" method="post" autocomplete="off">
                    @csrf
                    <label for="email" class="form-label">Email</label>
                    <input type="text" placeholder="Enter your email address" name="email" value="{{old('email')}}" class="form-control">
                    @error('email')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                    <button type="submit" class="mt-3 btn btn-primary">Send Request Password Link</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
