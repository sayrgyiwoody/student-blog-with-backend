@extends('admin.layout.master')

@section('title','Account Information')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2"><strong>Personal Information</strong></h3>
                            </div>
                            <hr>
                            <form action="" method="post" novalidate="novalidate" >
                                @csrf
                                <div class="form-group mt-3">
                                    <div class="row ">
                                        <div class="col-lg-6 ">
                                            <div style="width: 300px; height: 300px; overflow: hidden;">
                                                @if (Auth::user()->image)
                                                <img src="{{asset('storage/profileImages/'.Auth::user()->image)}}" style="object-fit:cover;object-position:center;" class="w-100 h-100 img-thumbnail card-img-top " alt="" />
                                                @else
                                                <img class="w-100 h-100 img-thumbnail" style="object-fit: cover; object-position:center;" src="https://ui-avatars.com/api/?name={{$post->admin_name}}"/>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <div class="col-lg-1 fs-4 me-3 d-flex px-2">
                                                    <label for="control-label" class="text-center my-auto"><i class="fa-solid fa-user me-2"></i></label>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input readonly disabled type="text" name="" class="form-control form-control-sm border-0 border-bottom border-dark   bg-white" value="{{Auth::user()->name}}" id="">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-1 fs-4 me-3 d-flex px-2">
                                                    <label for="role" class="text-center my-auto"><i class="fa-solid fa-shield-halved me-2"></i></label>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input  type="text" name="role" class="form-control form-control-sm border-0 border-bottom border-dark   bg-white" value="{{Auth::user()->role}}" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-1 fs-4 me-3 d-flex px-2">
                                                    <label for="role" class="text-center my-auto"><i class="fa-solid fa-venus-mars me-1"></i></label>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input  type="text" name="role" class="form-control form-control-sm border-0 border-bottom border-dark   bg-white" value="{{Auth::user()->gender}}" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-1 fs-4 me-3 d-flex px-2">
                                                    <label for="control-label" class="text-center my-auto"><i class="fa-solid fa-envelope me-2"></i></label>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input readonly disabled type="text" name="" class="form-control form-control-sm border-0 border-bottom border-dark   bg-white" value="{{Auth::user()->email}}" id="">
                                                </div>
                                            </div>
                                            <div class="row p-3 d-flex justify-content-evenly">
                                                <a href="{{route('admin#home')}}" style="width: 45%" class="btn btn-secondary"><i class="fa-solid fa-arrow-left  me-2"></i>Back</a>
                                                <a href="{{route('admin#updateAccountPage')}}" style="width: 45%" class="btn btn-primary"><i class="fa-solid fa-pen-to-square  me-2"></i>Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    @if (session('updateAlert'))

    @section('scriptSource')
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: '{{session('updateAlert')}}',
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
