@extends('admin.layout.master')

@section('title','Post List')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool justify-content-evenly">
                        <div class="table-data__tool-left mb-3 mb-lg-0">
                            <form action="{{route('post#listPage')}}" method="get">
                                <div class="input-group input-group-lg flex-nowrap shadow_2 rounded">
                                    <button type="submit" class="input-group-text btn" id="addon-wrapping"><i class="fa-regular fa-magnifying-glass fw-semibold text-primary"></i></button>
                                    <input name="searchKey" value="{{request('searchKey')}}" type="text" class="form-control shadow_2" placeholder="search for post name" aria-label="Username" aria-describedby="addon-wrapping">
                                </div>
                            </form>

                        </div>
                        <button type="button" class="btn btn-lg bg-white shadow_2 mb-3 mb-lg-0">
                            <i class="fa-solid fa-newspaper me-2 text-primary fw-bold"></i> <span class="badge p-2 text-bg-primary">{{$post->total()}}</span>
                        </button>
                        <div class="dropdown">
                            <button class="shadow_2 btn btn-lg bg-white text-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-arrow-up-z-a me-2 text-primary"></i>Filter
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="{{route('post#listPage')}}">Newest first</a></li>
                              <li><a class="dropdown-item" href="{{route('post#filterAsc')}}">Oldest first</a></li>
                              <li><a class="dropdown-item" href="{{route('post#mostSaved')}}">Most saved</a></li>

                            </ul>
                          </div>
                        <div class="table-data__tool-right">
                            <a href="{{route('post#createPage')}}" class="shadow_2 btn btn-lg bg-white text-primary">
                                <i class="fa-solid fa-plus me-2"></i> Create
                            </a>
                        </div>
                    </div>
                    @if (count($post) != 0)
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th class="fw-boldc text-primary " style="font-size: 16px">Id</th>
                                <th class="fw-bold text-primary" style="font-size: 16px">Name</th>
                                <th class="fw-bold text-primary" style="font-size: 16px">Topic</th>
                                <th class="fw-bold text-primary" style="font-size: 16px">Date</th>
                                <th class="fw-bold text-primary" style="font-size: 16px">Saved</th>
                                <th class="fw-bold text-primary" style="font-size: 16px">Content</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($post as $p)
                                <tr class="tr-shadow">
                                    <td class="post-id  align-middle fw-semibold">{{$p->id}}</td>
                                    <td class=" fw-semibold ">{{$p->admin_name}}</td>
                                    <td class=" fw-semibold ">{{$p->topic_name}}</td>
                                    <td class=" fw-semibold ">{{$p->created_at->format('F-j-Y')}}</td>
                                    <td class=" fw-semibold "><i class="fa-solid fa-bookmark me-2"></i>{{$p->save_count}}</td>
                                    <td class=" fw-semibold ">{{Str::words($p->desc,5,"....")}}</td>
                                    <td class=" fw-semibold align-middle d-flex">
                                        <a href="{{route('post#view',$p->id)}}" class="btn btn-light shadow_2 me-2 bg-white"><i class="text-primary fa-solid fa-eye"></i></a>
                                        <a href="{{route('post#editPage',$p->id)}}" class="btn btn-light shadow_2 me-2 bg-white"><i class="text-primary fa-solid fa-pen-to-square"></i></a>
                                        <button class="btn btn-light shadow_2 bg-white btn-delete"><i class="text-primary fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                                @endforeach
                        </tbody>
                    </table>
                    @else
                    <h3 class="text-primary text-center">There's no post to show!<i class="fa-solid fa-face-frown-open ms-2"></i></h3>
                    @endif
                    <!-- END DATA TABLE -->
                    <div class="mt-2">
                        {{$post->appends(request()->query())->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->


@if (session('createMessage'))

    @section('scriptSource')
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: '{{session('createMessage')}}',
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

@if (session('editMessage'))

    @section('scriptSource')
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: '{{session('editMessage')}}',
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

    @section('scriptSource')

    <script>

        $('.btn-delete').click(function() {
                $parentNode = $(this).parents('tr');
                $post_id = $parentNode.find('.post-id').html();
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
                        url : '/admin/post/delete',
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

                });

            }
                })

            })
    </script>

    @endsection


@endsection

