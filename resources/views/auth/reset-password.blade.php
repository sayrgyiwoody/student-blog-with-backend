<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset password</title>
    <link rel="stylesheet" href="{{asset('user/css/custom.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('user/css/login.css')}}"> --}}
    <link rel="stylesheet" href="{{asset('user/css/user.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('user/fontawesome/all.css')}}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,900&display=swap"
        rel="stylesheet">

        <!-- Add SweetAlert CDN -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.min.js"></script>

     <!-- Add SweetAlert styles -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.min.css">

     {{-- bootstrap icon --}}
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <div class="container-fluid">
        <div class="col-lg-4 offset-lg-4 mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3 class="text-center title-2"><strong>Change Account Password</strong></h3>
                    </div>
                    <hr>
                    <form action="{{route('reset.password')}}" method="post" novalidate="novalidate">
                        @csrf
                        <input type="hidden" name="token" value="{{$token}}">
                        <div class="form-group">
                            <label for="email" class="control-label mb-1 mt-3"><strong>Your email</strong></label>
                            <input id="cc-pament" name="email" type="email" class="form-control @error('email') is-invalid @enderror" aria-required="true" aria-invalid="false" value="{{$email}}" readonly>
                            @error('email')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                            @if (session('changePasswordFail'))
                                <span class="invalid-feedback">{{session('changePasswordFail')}}</span>
                            @endif
                            <label for="password" class="control-label mb-1 mt-3"><strong>New Password</strong></label>
                            <input id="cc-pament" name="password" type="password" class="form-control @error('password') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter New Password">
                            @error('password')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                            <label for="password_confirmation" class="control-label mb-1 mt-3"><strong>Confirm Password</strong></label>
                            <input id="cc-pament" name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Confirm Password">
                            @error('password_confirmation')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-3 d-flex justify-content-center">
                            <button id="payment-button" type="submit" class="btn btn-lg btn-primary btn-block text-white w-100">
                                <i class="fa-solid fa-lock-open me-2"></i>
                                <span id="payment-button-amount">Change Password</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


