@extends('admin.layout.master')

@section('title','Topic Create Page')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-6 offset-3 bg-white">
                    <h4 class="h4 text-center pt-3">Create Topic</h4>
                    <hr>
                    <form action="{{route('topic#create')}}" method="POST" class="px-4 py-2">
                        @csrf
                        <label for="name" class="form-label fw-semibold">Topic</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror form-control-lg " placeholder="Enter topic...">
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <div class="d-flex my-4 justify-content-center">
                            <a href="{{route('topic#listPage')}}" class="btn btn-outline-primary" style="width:25%"><i class="fa-solid fa-arrow-left me-2"></i>Back</a>
                            <button type="submit" class="btn btn-primary ms-2  "  style="width:75%"><i class="fa-solid fa-plus me-2"></i>Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

@endsection
