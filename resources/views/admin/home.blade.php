@extends('admin.layout.master')

@section('title','Admin Home')

@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="overview-wrap">
                        <h2 class="title-1 ">overview</h2>
                    </div>
                </div>
            </div>
            <div class="row m-t-25">
                <div class="col-sm-6 col-lg-4">
                    <div class="overview-item overview-item--c1">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <div class="text">
                                    <h2>{{$user_count}}</h2>
                                    <span>Users</span>
                                </div>
                            </div>
                            <div class="overview-chart">
                                <canvas id="widgetChart1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="overview-item overview-item--c2">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="fa-solid fa-user-shield"></i>
                                </div>
                                <div class="text">
                                    <h2>{{$admin_count}}</h2>
                                    <span>Admins</span>
                                </div>
                            </div>
                            <div class="overview-chart">
                                <canvas id="widgetChart2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="overview-item overview-item--c4">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="fa-solid fa-newspaper"></i>
                                </div>
                                <div class="text">
                                    <h2>{{$post_count}}</h2>
                                    <span>total posts</span>
                                </div>
                            </div>
                            <div class="overview-chart">
                                <canvas id="widgetChart4"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 p-2">
                    <h3 class="fw-bold text-primary">Hi {{Auth::user()->name}} ,</h3>
                    <h2>Welcome back!</h2>
                    <p>Our students' blog page is a platform for our team of admins to share insightful and informative posts on a variety of topics, including education, career guidance, and lifestyle. We aim to provide a platform where our students can showcase their creativity, share their thoughts, and engage with the community. Our admins will be posting regularly to keep our readers up-to-date and informed.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session('changePw'))

    @section('scriptSource')
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: '{{session('changePw')}}',
            showConfirmButton: true,
            // timer: 1500
            }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
            });
        </script>
    @endsection

@endif
@endsection
