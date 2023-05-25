@extends('user.layout.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 offset-lg-2 pt-4 bg-card pt-lg-5" style="height: 92vh; overflow-y: scroll;">
            <div class="card-box d-flex justify-content-center mb-4 mb-lg-5">
                <div class="card shadow rounded border-0" style="width: 40rem">
                    <h5 class="card-title mt-3 fw-bold ms-3 d-flex justify-content-between align-items-center">
                        <span class="me-2 text-primary border-start border-4 border-dark ps-1">{{$topic_name}}</span>
                        <div class="btn me-4 copy"><span class="me-2 text-muted"> copy text</span><i class="fa-solid fa-clipboard  fs-3 "></i></div>
                    </h5>
                    <div class="d-flex align-items-center ms-3 mt-1 ">
                        <div style="width: 55px; height: 55px; overflow: hidden;border-radius: 50%;">
                            @if ($post->profile_image)
                            <img src="{{asset('storage/'.$post->profile_image)}}" style="object-fit:cover;object-position:center;" class="w-100 h-100 rounded-circle card-img-top " alt="" />
                            @else
                            <img class="w-100 h-100 rounded-circle" style="object-fit: cover; object-position:center;" src="https://ui-avatars.com/api/?name={{$post->admin_name}}"/>
                            @endif
                        </div>
                        <div class="d-flex ">
                            <div class="ms-2">
                                <span style="font-size: 18px;" class="fw-semibold" >{{$post->admin_name}}</span><br>
                                <span style="font-size: 12px;" class="">{{$post->created_at->diffForHumans()}}</span>
                            </div>
                            @if ($post->role == 'admin')
                                <i class="bi bi-patch-check-fill mt-1 ms-1 " style="color: #1DA1F2"></i>
                            @endif
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
                        <p class="card-text" style="white-space: pre-wrap">{{$post->desc}}</p>
                        <hr />
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fs-5 ms-2" style="cursor: pointer;">
                                <i class="fa-regular fa-solid fa-bookmark"></i>
                                <span>{{$post->save_count}}</span>
                            </div>
                            <div class="">
                                <a href="{{asset('storage/'.$post->image)}}" target="_blank" download class="btn btn-outline-primary float-end me-3">Download<i class="ms-2 fa-solid fa-download"></i></a>
                                <a href="{{route('user#home')}}" class="btn btn-primary me-2">
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
@endsection

@section('scriptSource')
<script>
    $(document).ready(function() {
        //auto detect link
        const linkRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
        const $cardText = $(".card-text");
        const modifiedHTML = $cardText.html().replace(linkRegex, '<a target="_blank" href="$1">$1</a>');
        $cardText.html(modifiedHTML);

        //click to copy
        $('.copy').click(function() {
        navigator.clipboard.writeText($('.card-text').text());
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Copied to clipboard',
            showConfirmButton: true,
            // timer: 1500
            })
        })
    })

</script>


@endsection
