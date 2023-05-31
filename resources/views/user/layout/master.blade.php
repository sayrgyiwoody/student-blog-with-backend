<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
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
    {{-- for dark mode switch  --}}
    <link rel="stylesheet" href="{{asset('user/css/darkmode-switch.css')}}">
    {{-- see more  --}}
    <link rel="stylesheet" href="{{asset('user/css/seemore.css')}}">
    {{-- search  --}}
    <link rel="stylesheet" href="{{asset('user/css/search.css')}}">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        .shadow_2 {
            box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
        }
    </style>
</head>

<body class="body pt-5">
    <!-- Navbar Start -->
    <div class="container bg-dark ">
        <div class="row">
            <div class="col">
                <nav class="navbar navbar-dark navbar-expand-lg bg-dark fixed-top">
                    <div class="container">
                      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      {{-- <div class="form-check form-switch mx-auto">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                      </div> --}}
                      <label class="switch ms-2">
                        <span class="sun"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="#ffd43b"><circle r="5" cy="12" cx="12"></circle><path d="m21 13h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2zm-17 0h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2zm13.66-5.66a1 1 0 0 1 -.66-.29 1 1 0 0 1 0-1.41l.71-.71a1 1 0 1 1 1.41 1.41l-.71.71a1 1 0 0 1 -.75.29zm-12.02 12.02a1 1 0 0 1 -.71-.29 1 1 0 0 1 0-1.41l.71-.66a1 1 0 0 1 1.41 1.41l-.71.71a1 1 0 0 1 -.7.24zm6.36-14.36a1 1 0 0 1 -1-1v-1a1 1 0 0 1 2 0v1a1 1 0 0 1 -1 1zm0 17a1 1 0 0 1 -1-1v-1a1 1 0 0 1 2 0v1a1 1 0 0 1 -1 1zm-5.66-14.66a1 1 0 0 1 -.7-.29l-.71-.71a1 1 0 0 1 1.41-1.41l.71.71a1 1 0 0 1 0 1.41 1 1 0 0 1 -.71.29zm12.02 12.02a1 1 0 0 1 -.7-.29l-.66-.71a1 1 0 0 1 1.36-1.36l.71.71a1 1 0 0 1 0 1.41 1 1 0 0 1 -.71.24z"></path></g></svg></span>
                        <span class="moon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="m223.5 32c-123.5 0-223.5 100.3-223.5 224s100 224 223.5 224c60.6 0 115.5-24.2 155.8-63.4 5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-9.8 1.7-19.8 2.6-30.1 2.6-96.9 0-175.5-78.8-175.5-176 0-65.8 36-123.1 89.3-153.3 6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-6.3-.5-12.6-.8-19-.8z"></path></svg></span>
                        <input type="checkbox" id="flexSwitchCheckDefault" class="input form-check-input">
                        <span class="slider"></span>
                      </label>

                      <form class="" role="search" action="{{route('user#home')}}" method="GET">
                        {{-- <input  name="searchKey" value="{{request('searchKey')}}"  class="form-control me-2" type="search" placeholder="Search for content" aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">Search</button> --}}
                        <div class="container">
                          <input placeholder="search..." required="" class="input" name="searchKey" value="{{request('searchKey')}}" type="text">
                          <div class="icon text-primary">
                              <svg viewBox="0 0 512 512" class="ionicon" xmlns="http://www.w3.org/2000/svg">
                                  <title>Search</title>
                                  <path stroke-width="32" stroke-miterlimit="10" stroke="currentColor" fill="none" d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z"></path>
                                  <path d="M338.29 338.29L448 448" stroke-width="32" stroke-miterlimit="10" stroke-linecap="round" stroke="currentColor" fill="none"></path>
                              </svg>
                          </div>
                      </div>
                      </form>
                      {{-- <div class="btn bg-dark text-primary me-5 darkmode-icon " disabled><i class="bi bi-sun-fill"></i></div> --}}
                      <a class="navbar-brand fw-semibold text-light ms-lg-5" href="#">
                        <img src="{{asset('images/logo_dark.png')}}" style="width: 60px;">
                      </a>

                      <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                        <ul class="navbar-nav me-auto mx-lg-auto mb-2 mb-lg-0 ms-0">
                          <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{route('user#home')}}">Home</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link " href="{{route('saved#list')}}">Saved</a>
                          </li>
                          <li class="nav-item ">
                            <a class="nav-link " href="{{route('feedback#form')}}">Feedback</a>
                          </li>
                          <li class="nav-item ">
                            <a class="nav-link " href="{{route('user#postHome')}}">Create Post</a>
                          </li>
                          <div class="dropdown mt-2  d-lg-none">
                            <button class="btn text-white btn-white border border-primary border-2 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Topics to choose
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{route('user#home')}}">All</a></li>
                                @foreach ($topics as $topic )
                                <li><a class="dropdown-item" href="{{route('user#topicFilter',$topic->id)}}">{{$topic->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        </ul>
                        {{-- <form class="d-flex me-0 me-lg-3" role="search" action="{{route('user#home')}}" method="GET"> --}}
                          {{-- <input  name="searchKey" value="{{request('searchKey')}}"  class="form-control me-2" type="search" placeholder="Search for content" aria-label="Search">
                          <button class="btn btn-outline-primary" type="submit">Search</button> --}}
                          {{-- <div class="container">
                            <input placeholder="Type to search..." required="" class="input" name="text" type="text">
                            <div class="icon">
                                <svg viewBox="0 0 512 512" class="ionicon" xmlns="http://www.w3.org/2000/svg">
                                    <title>Search</title>
                                    <path stroke-width="32" stroke-miterlimit="10" stroke="currentColor" fill="none" d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z"></path>
                                    <path d="M338.29 338.29L448 448" stroke-width="32" stroke-miterlimit="10" stroke-linecap="round" stroke="currentColor" fill="none"></path>
                                </svg>
                            </div>
                        </div>
                        </form> --}}
                        {{-- changes --}}

                        {{-- Changes  --}}
                        <div class="btn-group  mt-1 mb-2 mt-lg-0">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                {{Auth::user()->name}}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{route('user#informationPage')}}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{route('user#changePasswordPage')}}">Change Password</a></li>
                                <form class=" px-2 pt-2 d-flex justify-content-center" method="POST" action="{{route('logout')}}">
                                  @csrf
                                  <button type="submit" class="btn btn-primary w-100">Logout</button>
                              </form>
                            </ul>
                        </div>
                      </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- content container -->
    @yield('content')


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

        @yield('scriptSource')

        <script>
            var currentUrl = window.location.href;

            $('.nav-link').each(function() {
                var linkUrl = $(this).attr('href');

                if(currentUrl.indexOf(linkUrl) != -1) {
                    $(this).addClass('text-primary');
                }
            })


            $(document).ready(function() {
                if(localStorage.getItem('dark-mode') === 'true') {
                    $('.form-check-input').prop('checked', true);
                    enableDarkMode();
                }


                $('#flexSwitchCheckDefault').on('change', function() {
                    if($(this).prop('checked')) {
                        enableDarkMode();
                        localStorage.setItem('dark-mode', true);
                    } else {
                        disableDarkMode();
                        localStorage.setItem('dark-mode', false);
                    }
                });
            });

            function enableDarkMode() {
                // $('.darkmode-icon').html('<i class="bi bi-moon-stars-fill"></i>');
                $('.card').addClass('card-dark border-primary');
                $('.body').addClass('card-dark');
                $('.bg-card').addClass('body-dark');
                $('.btn-white').addClass('btn-dark');
            }

            function disableDarkMode() {
                $('.card').removeClass('card-dark border-primary');
                $('.body').removeClass('card-dark');
                $('.bg-card').removeClass('body-dark');
                $('.btn-white').removeClass('btn-dark');
                // $('.darkmode-icon').html('<i class="bi bi-sun-fill"></i>');

            }

            $(document).ready(function() {
                $('input').focus(function() {
                    if (window.innerWidth <= 768) { // Adjust the breakpoint according to your needs
                    $('.switch').animate({ left: '-200px' }, 500);
                    $('.navbar-brand').css('position', 'relative').animate({ right: '-100px' }, 500);
                    }
                });

                $('input').blur(function() {
                    if (window.innerWidth <= 768) { // Adjust the breakpoint according to your needs
                    $('.switch').animate({ left: '0px' }, 500);
                    $('.navbar-brand').css('position', 'relative').animate({ right: '0px' }, 500);
                    }
                });
            });





        </script>

        <script src="{{asset('user/js/main.js')}}"></script>
</body>

</html>
