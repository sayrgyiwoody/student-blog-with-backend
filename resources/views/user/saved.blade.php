@extends('user.layout.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 offset-lg-3  pt-4" style="height: 91vh; overflow-y: scroll;background-color: #e5e5e5;">
           @if (count($posts)!=0)
           @foreach ($posts as $post )
           <div class="card-box d-flex justify-content-center mb-4">
               <div class="card shadow rounded border-0" style="width: 35rem">
                   <h5 class="card-title mt-3 fw-bold ms-3">
                    <span class="me-2 text-primary border-start border-4 border-dark ps-1">
                        {{$post->topic_name}}
                        <input class="post_id" type="hidden" value="{{$post->id}}">
                    </span>
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
                               <div class="d-flex align-items-center">
                                <div class="btn bg-white btn-unsave">
                                    <i class="fa-regular fa-solid text-primary fa-bookmark fs-3"></i>
                                </div>
                                <span class="text-primary">saved</span>
                               </div>
                           <a href="{{route('user#view',$post->id)}}" class="btn btn-primary">
                               <i class="fa-solid fa-eye me-2"></i>see more
                           </a>
                       </div>
                   </div>
               </div>
           </div>
           @endforeach
           @else
           <h4 class="text-center text-primary">No post saved yet.</h4>
           @endif
        </div>
    </div>
</div>
@endsection

@section('scriptSource')
<script>
    $(document).ready(function() {
        $('.btn-unsave').click(function(){
            $parentNode = $(this).parents('.card-box');
            $parentNode.find('.fa-bookmark').addClass('fa-solid');
            $post_id = $parentNode.find('.post_id').val();
            Swal.fire({
                title: 'Are you sure bro?',
                text: "Tagl unsave tot ma loh lh",
                showCancelButton: true,
                imageUrl: '{{asset('images/alert gif/mad.gif')}}',
                imageWidth: 300,
                imageHeight: 300,
                imageAlt: 'Custom image',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Inn unsave ml!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type : 'get',
                        url : '/user/saved/unsave',
                        data : {'post_id' : $post_id},
                        dataType : 'json',
                        success : function() {
                            Swal.fire(
                            'Unsaved!',
                            'Unsave lte p honnnt',
                            'success'
                            ).then(function(){
                                location.reload();
                            })
                        }
                    });
                }
                })
        });
    });
</script>
@endsection
