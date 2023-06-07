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
                                <span style="font-size: 18px;" class="fw-semibold" >{{$post->admin_name}}
                                    @if ($post->role == 'admin')
                                    <i class="bi bi-patch-check-fill " style="color: #1DA1F2;font-size:14px;"></i>
                                @endif
                                </span>
                                <br>
                                <span style="font-size: 12px;" class="">{{$post->created_at->diffForHumans()}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="img-container my-3 mx-4 border rounded border-dark border-3">
                        @if ($post->image)
                            <img src="{{asset('storage/'.$post->image)}}" class="image card-img-top " />
                            <div class="buttons">
                                <button class="btn btn-primary btn-view"><i class="fa-solid fa-mountain-sun me-2"></i>View</button>
                                <a href="{{asset('storage/'.$post->image)}}" download class="btn btn-primary btn-download"><i class="fa-solid fa-download"></i></a>
                            </div>
                        @else
                        <img src="{{asset('images/alert gif/postimg.jpg')}}" class="card-img-top img-thumbnail" alt="" />
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
                                <a href="{{route('user#home')}}" class="btn btn-primary float-end me-2">
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
