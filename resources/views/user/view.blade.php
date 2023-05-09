@extends('user.layout.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 offset-lg-2 pt-2  pt-lg-5" style="height: 92vh; overflow-y: scroll;background-color: #e5e5e5;">
            <div class="card-box d-flex justify-content-center mb-4 mb-lg-5">
                <div class="card shadow rounded border-0" style="width: 40rem">
                    <h5 class="card-title mt-3 fw-bold ms-3">
                        <span class="me-2 text-primary border-start border-4 border-dark ps-1">{{$topic_name}}</span>
                    </h5>
                    <div class="d-flex align-items-center ms-3 mt-1 ">
                        <div style="width: 55px; height: 55px; overflow: hidden;border-radius: 50%;">
                            <img class="w-100 h-100" style="object-fit: cover; object-position:center;" src="https://ui-avatars.com/api/?name={{$post->admin_name}}"/>
                        </div>
                        <div class="ms-2">
                            <span style="font-size: 18px;" class="fw-semibold" >{{$post->admin_name}}</span><br>
                            <span style="font-size: 12px;" class="">{{$post->created_at->diffForHumans()}}</span>
                        </div>
                    </div>
                    <div class="img-container pt-3 px-4 ">
                    <img src="{{asset('storage/'.$post->image)}}" class="card-img-top img-thumbnail border border-dark" alt="" />
                    </div>
                    <div class="card-body">
                        <p class="card-text" style="white-space: pre-wrap">{{$post->desc}}</p>
                        <hr />
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fs-5 ms-2" style="cursor: pointer;">
                                <i class="fa-regular fa-solid fa-bookmark"></i>
                                <span>{{$post->save_count}}</span>
                            </div>
                            <a href="{{route('user#home')}}" class="btn btn-primary">
                                <i class="fa-solid fa-arrow-left me-2"></i>Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

