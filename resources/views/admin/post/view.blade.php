@extends('admin.layout.master')

@section('title','Post Detail')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-8 offset-lg-2">
                    <div class="card-box d-flex justify-content-center mb-4">
                        <div class="card shadow rounded border-0" style="width: 35rem">
                            <h5 class="card-title mt-3 fw-bold ms-3">
                                <span class="me-2 text-primary border-start border-4 border-dark ps-1">{{$topic_name}}</span>
                            </h5>
                            <div class="d-flex align-items-center ms-3 mt-1 ">
                                <div style="width: 55px; height: 55px; overflow: hidden;border-radius: 50%;">
                                    @if ($post->profile_image)
                                    <img src="{{asset('storage/profileImages/'.$post->profile_image)}}" style="object-fit:cover;object-position:center;" class="w-100 h-100 rounded-circle card-img-top " alt="" />
                                    @else
                                    <img class="w-100 h-100 rounded-circle" style="object-fit: cover; object-position:center;" src="https://ui-avatars.com/api/?name={{$post->admin_name}}"/>
                                    @endif
                                </div>
                                <div class="ms-2">
                                    <span style="font-size: 18px;" class="fw-semibold" >{{$post->admin_name}}</span><br>
                                    <span style="font-size: 12px;" class="">{{$post->created_at->diffForHumans()}}</span>
                                </div>
                            </div>
                            <div class="img-container pt-3 px-4 ">
                                @if ($post->image)
                                <img src="{{asset('storage/'.$post->image)}}" class="card-img-top img-thumbnail border border-dark" alt="" />
                                @else
                                <img src="{{asset('images/alert gif/postimg.jpg')}}" class="card-img-top img-thumbnail border border-dark" alt="" />
                                @endif
                            </div>
                            <div class="card-body">
                                <p class="card-text" style="white-space: pre-wrap">{{$post->desc,20}}</p>
                                <hr />
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="fs-5 ms-2" style="cursor: pointer;">
                                        <i class="fa-solid fa-regular fa-bookmark"></i>
                                        <span>{{$post->save_count}}</span>
                                    </div>
                                    <a href="{{route('post#listPage')}}" class="btn btn-primary">
                                        <i class="fa-solid fa-arrow-left me-2"></i>Back
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->



@endsection
