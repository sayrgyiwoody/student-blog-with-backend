@extends('admin.layout.master')

@section('title','Topic List')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool justify-content-evenly">
                        <div class="table-data__tool-left mb-3 mb-lg-0">
                            <form action="{{route('topic#listPage')}}" method="get">
                                <div class="input-group input-group-lg flex-nowrap shadow_2 rounded">
                                    <button type="submit" class="input-group-text btn" id="addon-wrapping"><i class="fa-regular fa-magnifying-glass fw-semibold text-primary"></i></button>
                                    <input name="searchKey" value="{{request('searchKey')}}" type="text" class="form-control shadow_2" placeholder="search for topic name" aria-label="Username" aria-describedby="addon-wrapping">
                                </div>
                            </form>

                        </div>
                        <button type="button" class="btn btn-lg bg-white shadow_2  mb-3 mb-lg-0">
                            <i class="fa-solid fa-table-list me-2 text-primary fw-bold"></i> <span class="badge p-2 text-bg-primary">{{ $topic->total() }}</span>
                        </button>
                        <div class="dropdown">
                            <button class="shadow_2 btn btn-lg bg-white text-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-arrow-up-z-a me-2 text-primary"></i>Filter
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="{{route('topic#listPage')}}">Newest first</a></li>
                              <li><a class="dropdown-item" href="{{route('topic#filterAsc')}}">Oldest first</a></li>
                            </ul>
                        </div>
                        <div class="table-data__tool-right  ">
                            <a href="{{route('topic#createPage')}}" class="shadow_2 btn btn-lg bg-white text-primary">
                                <i class="fa-solid fa-plus me-2"></i> Create
                            </a>
                        </div>
                    </div>
                    @if (count($topic)!=0)
                    <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th class="text-primary fw-bold text-center" style="font-size: 16px">Id</th>
                              <th class="text-primary fw-bold text-center" style="font-size: 16px">Name</th>
                              <th class="text-primary fw-bold text-center" style="font-size: 16px">Date</th>
                              <th></th> <!-- empty header column for the delete/edit buttons on mobile -->
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($topic as $t)
                            <tr class="tr-shadow">
                              <td class="fw-semibold text-center">{{$t->id}}</td>
                              <td class="fw-semibold text-center" >{{$t->name}}</td>
                              <td class="fw-semibold text-center" >{{$t->created_at->format('F-j-Y')}}</td>
                              <td class="fw-semibold text-center" >
                                <div class="d-flex flex-row justify-content-center justify-content-md-end align-items-center">
                                  <a href="{{route('topic#editPage',$t->id)}}" class="btn shadow_2 bg-white text-primary me-2"><i class="fa-sharp fa-regular fa-pen-to-square"></i></a>
                                  <button class="btn shadow_2 btn-danger btn-delete"><i class=" fa-solid fa-trash"></i></button>
                                </div>
                              </td>
                              <input type="hidden" value="{{$t->id}}" class="topic-id">
                            </tr>
                            <tr class="spacer"></tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>

                    @else
                    <h3 class="text-primary text-center">There's no topic to show!<i class="fa-solid fa-face-frown-open ms-2"></i></h3>
                    @endif
                    <!-- END DATA TABLE -->
                    <div class="mt-2">
                        {{$topic->appends(request()->query())->links()}}
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
                $topic_id = $parentNode.find('.topic-id').val();
                Swal.fire({
                title: 'Are you sure?',
                text: "This topic will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result)=> {
                    if (result.isConfirmed) {
                    $.ajax({
                        type : 'get',
                        url : '/admin/topic/delete',
                        data : {'topic_id' : $topic_id},
                        dataType : 'json',
                        success : function() {
                            Swal.fire(
                            'Deleted!',
                            'Topic has been deleted.',
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


