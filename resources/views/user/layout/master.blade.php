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

</head>

<body>
    <!-- Navbar Start -->
    <div class="container-fluid bg-dark">
        <div class="row px-5">
            <div class="col">
                <nav class="navbar navbar-dark navbar-expand-lg bg-dark ">
                    <div class="container-fluid">
                      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <a class="navbar-brand fw-semibold text-light" href="#">LOGO</a>
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
                          <div class="dropdown  d-lg-none">
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
                        <form class="d-flex me-0 me-lg-3" role="search" action="{{route('user#home')}}" method="GET">
                          <input  name="searchKey" value="{{request('searchKey')}}"  class="form-control me-2" type="search" placeholder="Search for content" aria-label="Search">
                          <button class="btn btn-outline-primary" type="submit">Search</button>
                        </form>
                        <form method="POST" action="{{route('logout')}}">
                        @csrf
                        <button type="submit" class="btn btn-primary mt-3 mt-lg-0">Logout</button>
                        </form>
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
        </script>
</body>

</html>
