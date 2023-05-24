@extends('user.layout.master')


@section('content')
<div class="container-fluid pt-4">
    <div class="col-md-6 offset-lg-3 mt-4 border border-primary">
        <form action="{{route('user#postEdit')}}" method="POST" class="px-4 py-3" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <label for="name" class="form-label fw-semibold">Name</label>
            <input name="" type="text" class="form-control" readonly disabled value="{{Auth::user()->name}}">
            <input type="hidden" name="adminId" value="{{$post->admin_id}}">
            <input type="hidden" name="postId" value="{{$post->id}}">
            <label for="topicId" class="form-label fw-semibold mt-3">Topic</label>
            <select name="topicId"  class="form-select @error('topicId') is-invalid @enderror">
                <option value="">Choose topic</option>
                @foreach ($topics as $t )
                    <option value="{{$t->id}}" @if(old('topicId') == $t->id || $t->id == $post->topic_id) selected @endif  >{{$t->name}}</option>
                @endforeach
            </select>
            @error('topicId')
            <span class="text-danger d-block">{{$message}}</span>
            @enderror
            <label for="postImage" class="form-label fw-semibold mt-3">Image</label>
            <input type="file" name="postImage" id="" class="form-control @error('postImage') is-invalid @enderror">
            @error('postImage')
                <span class="text-danger d-block">{{$message}}</span>
                @enderror
            <label for="desc" class="form-label fw-semibold mt-3">Content</label>
            <textarea name="desc" rows="6" class="form-control @error('desc') is-invalid @enderror" placeholder="Enter content messages here...">{{old('desc',$post->desc)}}</textarea>
            @error('desc')
            <span class="text-danger">{{$message}}</span>
            @enderror
            <div class="d-flex mt-4 mb-1 justify-content-center">
                <a href="{{route('user#postHome')}}" class="btn btn-outline-primary" style="width:25%"><i class="fa-solid fa-arrow-left me-2"></i>Back</a>
                <button type="submit" class="btn btn-primary ms-2  "  style="width:75%"><i class="fa-solid fa-upload me-2"></i>Update</button>
            </div>
        </form>
    </div>
</div>

@if (session('error'))

    @section('scriptSource')
        <script>
            Swal.fire({
                icon : 'error',
                text: '{{ session('error') }}',
                showConfirmButton: true,
            }).then((result) => {
                if(result.isConfirmed) {
                location.reload();
                }
            })
        </script>
    @endsection

@endif

@endsection

