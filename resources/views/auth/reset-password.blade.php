{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('reset.password') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $email)"  autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password"  autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"  autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}

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
        <div class="col-lg-4 offset-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3 class="text-center title-2"><strong>Change Account Password</strong></h3>
                    </div>
                    <hr>
                    <form action="{{route('reset.password')}}" method="post" novalidate="novalidate">
                        @csrf
                        <div class="form-group">
                            <label for="oldPassword" class="control-label mb-1"><strong>Old Password</strong></label>
                            <input id="cc-pament" name="oldPassword" type="password" class="form-control @if (session('changePasswordFail')) is-invalid @endif @error('oldPassword') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Old Password">
                            @error('oldPassword')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                            @if (session('changePasswordFail'))
                                <span class="invalid-feedback">{{session('changePasswordFail')}}</span>
                            @endif
                            <label for="newPassword" class="control-label mb-1 mt-3"><strong>New Password</strong></label>
                            <input id="cc-pament" name="newPassword" type="password" class="form-control @error('newPassword') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter New Password">
                            @error('newPassword')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                            <label for="confirmPassword" class="control-label mb-1 mt-3"><strong>Confirm Password</strong></label>
                            <input id="cc-pament" name="confirmPassword" type="password" class="form-control @error('confirmPassword') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Confirm Password">
                            @error('confirmPassword')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-3 d-flex justify-content-center">
                            <button id="payment-button" type="submit" class="btn btn-lg btn-primary btn-block text-white w-100">
                                <i class="fas fa-key me-2"></i>
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


