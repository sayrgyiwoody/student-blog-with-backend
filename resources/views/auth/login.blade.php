<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="{{asset('user/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/form.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <section class="form-container bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="login-container bg-white ">
            <div class="row">
                <div class="col-lg-5 ">
                    <div class="bg-primary bg-image border-end">
                      <!-- image here -->
                    </div>
                  </div>
                <div class="col-sm-12 col-lg-7 px-5 py-4  p-lg-5">
                    <div class="text-end fw-semibold">
                    Do you have an account?<a href="{{ route('register') }}" class="ms-3 btn btn-sm btn-outline-primary fw-semibold ">Register</a>
                    </div>
                    <div class="mt-4 mt-lg-5  login-form-container">
                        <div class="mb-4">
                            <h2 class=" fw-semibold">Welcome to Students' blog</h2>
                            <p class="mt-3 text-muted" style="font-size: 21px;">Login your account</p>
                        </div>
                        <div class="">
                            <form method="POST" action="{{route('login')}}" class="pt-lg-4">
                                @csrf
                                <label for="email" class=" form-label text-primary fw-semibold" style="font-size: 21px;">Email</label>
                                <input name="email" value="{{old('email')}}" type="text" class=" @error('email') is-invalid @enderror form-control form-control-lg " placeholder="Enter email...">
                                @error('email')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                                <label for="password" class="mt-4 form-label text-primary fw-semibold" style="font-size: 21px;">Password</label>
                                <input name="password" type="password" class=" @error('password') is-invalid @enderror form-control form-control-lg" placeholder="Enter password...">
                                @error('password')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                                <button type="submit" class="btn btn-lg btn-primary py-2 px-5 mt-3 mb-1 mt-lg-4 mb-lg-3">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
