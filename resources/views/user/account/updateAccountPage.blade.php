@extends('user.layout.master')


@section('content')
<div class="container-fluid">
    <div class="col-lg-6 offset-lg-3 mt-4">
        <div class="card ">
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2 "><strong>Update Information</strong></h3>
                </div>
                <hr>
                <form action="{{route('user#updateAccount')}}" method="post" novalidate="novalidate" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{Auth::user()->id}}">
                    <div class="form-group mt-3">
                        <div class="row ">
                            <div class="col-lg-6">
                                <div style="width: auto; height: 300px; overflow: hidden;">
                                    @if (Auth::user()->image)
                                    <img src="{{asset('storage/'.Auth::user()->image)}}" style="object-fit:cover;object-position:center;" class="w-100 h-100 img-thumbnail card-img-top " alt="" />
                                    @else
                                    <img class="w-100 h-100 img-thumbnail" style="object-fit: cover; object-position:center;" src="https://ui-avatars.com/api/?name={{Auth::user()->name}}"/>
                                    @endif
                                </div>
                                <input type="file" name="image" class="form-control mt-3  @error('image') is-invalid @enderror" >
                                @error('image')
                                        <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="row my-2">
                                    <div class="col-lg-1 fs-4 me-3 d-flex px-2">
                                        <label for="name" class="text-center my-auto"><i class="fa-solid  fa-user d-none d-lg-block"></i></label>
                                    </div>
                                    <div class="col-lg-10">
                                        <input  type="text" name="name" class="form-control form-control-sm  bg-white @error('name') is-invalid @enderror" value="{{old('name',Auth::user()->name)}}" placeholder="Enter Name">
                                        @error('name')
                                        <span class="invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-1 fs-4 me-3 d-flex px-2">
                                        <label for="role" class="text-center my-auto"><i class="fa-solid  fa-shield-halved d-none d-lg-block"></i></label>
                                    </div>
                                    <div class="col-lg-10">
                                        <input  type="text" name="role" class="form-control form-control-sm " value="{{old('role',Auth::user()->role)}}" readonly >
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-1 fs-4 me-3 d-flex px-2">
                                        <label for="gender" class="text-center my-auto"><i class="fa-solid  fa-venus-mars d-none d-lg-block"></i></label>
                                    </div>
                                    <div class="col-lg-10">
                                        <select name="gender" class="form-select form-control-sm  @error('gender') is-invalid @enderror">
                                            <option value="">Choose Gender</option>
                                            <option value="male" @if(Auth::user()->gender=='male') selected @endif>male</option>
                                            <option value="female" @if(Auth::user()->gender=='female') selected @endif>female</option>
                                        </select>
                                        @error('gender')
                                        <span class="invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-1 fs-4 me-3 d-flex px-2">
                                        <label for="email" class="text-center my-auto"><i class="fa-solid  fa-envelope d-none d-lg-block"></i></label>
                                    </div>
                                    <div class="col-lg-10">
                                        <input  type="text" name="email" class="form-control form-control-sm  bg-white @error('email') is-invalid @enderror" value="{{old('email',Auth::user()->email)}}" placeholder="Enter Email">
                                        @error('email')
                                        <span class="invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row py-3 px-2 d-flex justify-content-evenly">
                                    <a href="{{route('user#informationPage')}}" class="btn btn-secondary" style="width: 28%"><i class="fa-solid  fa-arrow-left me-2" ></i>Back</a>
                                    <button type="submit" class="btn btn-primary" style="width: 68%"><i class="fa-solid fa-arrow-up-from-bracket me-2"></i>Update</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
