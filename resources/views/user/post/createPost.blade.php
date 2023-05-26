@extends('user.layout.master')


@section('content')

<style>
    #create-post {
    position: fixed;
    bottom: 30px;
    right: 20px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999;
  }

  #create-post i {
    font-size: 30px;
    color: #333;
  }



    @media only screen and (max-width: 600px) {
        #post-form {
            position: fixed;
            top: 80px;
            right: -100%;
        }


    }


</style>
<div class="container">
    <div class="row justify-content-center pt-3">
        <div id="create-post" class="bg-primary d-md-none">
            <i class="bi bi-pencil-square text-white"></i>
          </div>

        <div id="post-form" class="col-md-4 d-none d-md-block  border-0 pt-3 ">
            <form class="card mb-3 shadow rounded p-4 " action="{{route('user#postCreate')}}" method="POST" class="px-4 py-3" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <label for="name" class="form-label fw-semibold">Name</label>
                <input name="name" type="text" class="form-control" readonly disabled value="{{Auth::user()->name}}">
                <input type="hidden" name="" value="{{Auth::user()->name}}">
                <input type="hidden" name="adminId" value="{{Auth::user()->id}}">
                <label for="topicId" class="form-label fw-semibold mt-3">Topic</label>
                <select name="topicId" class="form-select @error('topicId') is-invalid @enderror" style="transition: none;min-width:0;">
                    <option value="">Choose topic</option>
                    @foreach ($topics as $t )
                        <option value="{{$t->id}}" @if(old('topicId') == $t->id) selected @endif >{{$t->name}}</option>
                    @endforeach
                </select>
                @error('topicId')
                <span class="text-danger d-block">{{$message}}</span>
                @enderror
                <label for="postImage" class="form-label fw-semibold mt-3">Image</label>
                <input type="file" name="postImage" id="" class="form-control @error('postImage') is-invalid @enderror">
                @error('postImage')
                <span class="text-danger">{{$message}}</span>
                @enderror
                <label for="desc" class="form-label fw-semibold mt-3">Content</label>
                <textarea name="desc" rows="6" class="form-control @error('desc') is-invalid @enderror" placeholder="Enter content messages here...">{{old('desc')}}</textarea>
                @error('desc')
                <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="d-flex mt-4 mb-1 justify-content-center">
                    <a href="{{route('post#listPage')}}" class="btn btn-outline-primary" style="width:25%"><i class="fa-solid fa-arrow-left me-2"></i>Back</a>
                    <button type="submit" class="btn btn-primary ms-2  "  style="width:75%"><i class="fa-solid fa-plus me-2"></i>Create</button>
                </div>
            </form>
        </div>
        <div id="user-posts" class="col-md-6 py-3 overflow-auto flex-column bg-card" style="height:92vh;">
            @if (count($posts) != 0)
           @foreach ($posts as $post )
           <div class="card-box d-flex justify-content-center mb-4">
               <div class="card shadow rounded border-0" style="width: 35rem">
                   <h5 class="card-title d-flex justify-content-between align-items-center mt-3 fw-bold ms-3">
                       <span class="me-2 text-primary border-start border-4 border-dark ps-1">
                           {{$post->topic_name}}
                           <input class="post-id" type="hidden" value="{{$post->id}}">
                       </span>
                       <div class="dropdown me-4">
                        <button class="btn bg-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu" style="min-width: 0">
                          <li>
                            <a href="{{route('user#postEditPage',$post->id)}}" class="dropdown-item"><i class="bi bi-pen me-2"></i>Edit</a>
                          </li>
                          <li><button class="dropdown-item btn-delete" ><i class="bi bi-trash me-2"></i>Delete</button></li>
                        </ul>
                      </div>
                   </h5>
                   <div class="d-flex align-items-center ms-3 mt-1 ">
                       <div style="width: 55px; height: 55px; overflow: hidden;border-radius: 50%;">
                        @if ($post->profile_image)
                            <img src="{{asset('storage/'.$post->profile_image)}}" style="object-fit:cover;object-position:center;" class="w-100 h-100 rounded-circle card-img-top " alt="" />
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
                       <p class="card-text" style="white-space: pre-wrap">{{Str::words($post->desc,20,"....")}}</p>
                       <hr />
                       <div class="d-flex justify-content-between align-items-center">
                            <a href="{{asset('storage/'.$post->image)}}" target="_blank" download="{{$post->image}}" class="ms-2 btn btn-outline-primary">Download<i class="ms-2 fa-solid fa-download"></i></a>
                           <a href="{{route('user#view',$post->id)}}" class="btn btn-primary">
                               <i class="fa-solid fa-eye me-2"></i>see more
                           </a>
                       </div>
                   </div>
               </div>
           </div>
           @endforeach
           @else
           <h4 class="text-primary text-center mt-4">No post to show.</h4>
           @endif
        </div>
    </div>
</div>

@if (session('message'))

    @section('scriptSource')
        <script>
            Swal.fire({
                imageUrl: '{{asset('images/alert gif/happy.gif')}}',
                imageWidth: 300,
                imageHeight: 300,
                imageAlt: 'Custom image',
                title: '{{ session('message') }}',
                showConfirmButton: true,
                // timer: 1500
            }).then((result) => {
                if(result.isConfirmed) {
                location.reload();
                }
            })
        </script>
    @endsection

@endif

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


@section('scriptSource')

<script>

    //auto detect link
    $(".card-text").each(function() {
            const linkRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
            const modifiedHTML = $(this).html().replace(linkRegex, '<a target="_blank" href="$1">$1</a>');
            $(this).html(modifiedHTML);
        });

    $('.btn-delete').click(function() {
            $parentNode = $(this).parents('.card-box');
            $post_id = $parentNode.find('.post-id').val();
            Swal.fire({
            title: 'Are you sure?',
            text: "This post will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result)=> {
                if (result.isConfirmed) {
                $.ajax({
                    type : 'get',
                    url : '/user/post/delete',
                    data : {'post_id' : $post_id},
                    dataType : 'json',
                    success : function() {
                        Swal.fire(
                        'Deleted!',
                        'Post has been deleted.',
                        'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                    });
                }

            });postImage

        }
            })

        })

        //Show form
        $(document).ready(function() {
            $('#create-post').click(function() {
                $(this).hide();
                $('#post-form').removeClass('d-none').animate({ right: '0' }, 300);
                $('#user-posts').hide();
            });
        });


        @if($errors->has('topicId') || $errors->has('postImage') || $errors->has('desc'))
            $(document).ready(function() {
                $('#create-post').hide();
                $('#post-form').removeClass('d-none').animate({ right: '0' }, 300);
                $('#user-posts').hide();
            });
        @endif


</script>

@endsection

