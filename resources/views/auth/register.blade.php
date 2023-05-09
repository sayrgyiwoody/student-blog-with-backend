<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="{{asset('user/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/form.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <section class="form-container-rg bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="login-container bg-white">
            <div class="row">
                <div class="col-lg-5">
                    <div class="bg-primary bg-image border-end">
                      <!-- content here -->
                    </div>
                  </div>
                <div class="col-12 col-lg-7 py-4 px-5 py-lg-3">
                    <div class="text-end fw-semibold mt-1">
                    Already have an account?<a href="{{ route('login') }}" class="ms-3 btn btn-outline-primary fw-semibold ">Login</a>
                    </div>

                        <div class="">
                            <form  method="POST" action="{{route('register')}}" class="pt-2 register-form-container">
                                @csrf
                                <label for="name" class=" form-label mt-4 text-primary fw-semibold " style="font-size: 21px;">Name</label>
                                <input name="name"  value="{{old('name')}}" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"  placeholder="Enter name...">
                                @error('name')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                                <label for="email" for="" class=" form-label mt-4 text-primary fw-semibold" style="font-size: 21px;">Email</label>
                                <input name="email" value="{{old('email')}}" type="text" class="form-control form-control-lg @error('email') is-invalid @enderror"  placeholder="Enter email...">
                                @error('email')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                                <label for="gender" class=" form-label mt-4 text-primary fw-semibold" style="font-size: 21px;">Gender</label>
                                <select name="gender"  value="{{old('gender')}}" class="form-select form-select-lg @error('gender') is-invalid @enderror" >
                                    <option value="">Choose gender</option>
                                    <option value="male" @if (old('gender') == 'male') selected @endif>male</option>
                                    <option value="female" @if (old('gender') == 'female') selected @endif>female</option>
                                </select>
                                @error('gender')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                                <label for="password" class=" form-label mt-4 text-primary fw-semibold" style="font-size: 21px;">Password</label>
                                <input name="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Enter password...">
                                @error('password')
                                <span class="invalid-feedback">
                                    {{$message}}
                                </span>
                                @enderror
                                <label for="password_confirmation" class=" form-label mt-4 text-primary fw-semibold" style="font-size: 21px;">Confirm Password</label>
                                <input name="password_confirmation" type="password" class="form-control form-control-lg" placeholder="Enter password again...">
                                <button type="submit" class="btn btn-lg btn-primary py-2 px-5 mt-4 mb-3">Register</button>
                            </form>
                        </div>

                </div>
            </div>
        </div>
    </section>
</body>
</html>
