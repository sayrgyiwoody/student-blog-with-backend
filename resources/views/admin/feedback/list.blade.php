@extends('admin.layout.master')


@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <form action="{{route('admin#feedbackPage')}}" method="get">
                                <div class="input-group input-group-lg flex-nowrap shadow_2 rounded">
                                    <button type="submit" class="input-group-text btn" id="addon-wrapping"><i class="fa-regular fa-magnifying-glass fw-semibold text-primary"></i></button>
                                    <input name="searchKey" value="{{request('searchKey')}}" type="text" class="form-control shadow_2" placeholder="search name" aria-label="Username" aria-describedby="addon-wrapping">
                                </div>
                            </form>
                        </div>
                        <div class="table-data__tool-right">
                            <button type="button" class="btn btn-primary">
                                <i class="fa-solid fa-envelope me-2"></i><span class="badge text-primary text-bg-light">{{$message->total()}}</span>
                            </button>
                            <div class="btn btn-danger delete-message-all">Delete All <i class="fa-solid fa-trash"></i></div>
                        </div>
                    </div>
                    @if (count($message) != null)
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-hover table-striped mb-0 text-center">
                            <thead class="text-white " style="background-color: #262626;">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($message as $m)
                            <tr>
                                <td class="align-middle">{{$m->id}}</td>
                                <td class="align-middle">{{$m->name}}</td>
                                <td class="align-middle">{{$m->email}}</td>
                                <td class="align-middle">{{$m->subject}}</td>
                                <td class="align-middle">{{Str::words($m->message,5,"....")}}</td>
                                <td class="align-middle">
                                    <div class="table-data-feature">
                                        <a href="{{route('admin#feedbackView',$m->id)}}" class="btn btn-white me-2 shadow_2">
                                            <i class="zmdi zmdi-eye text-primary" style="color: #262626"></i>
                                        </a>
                                        <input type="hidden" class="message-id" value="{{$m->id}}">
                                        <button class="btn btn-white delete-message me-2 shadow_2">
                                            <i class="zmdi zmdi-delete text-danger" style="color: #262626"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <h3 class="text-secondary text-center">There's no message to show!<i class="fa-solid fa-face-frown-open ms-2"></i></h3>
                    @endif
                    <!-- END DATA TABLE -->
                    <div class="mt-2">
                    {{$message->appends(request()->query())->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

@endsection


@section('scriptSource')

<script>
    //delete message
    $('.delete-message').click(function() {
            $parentNode = $(this).parents('tr');
            $m_id = $parentNode.find('.message-id').val();
                Swal.fire({
                title: 'Are you sure?',
                text: "This message will be deleted !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type : 'get',
                        url : '/admin/feedback/delete',
                        data : {'message_id' : $m_id},
                        dataType : 'json',
                        success : function() {
                            Swal.fire(
                            'Deleted!',
                            'Your message has been deleted.',
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

        $('.delete-message-all').click(function() {
            Swal.fire({
            title: 'Are you sure?',
            text: "All messages will be deleted !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type : 'get',
                    url : '/admin/feedback/delete/all',
                    dataType : 'json',
                    success : function() {
                        Swal.fire(
                        'Deleted!',
                        'All messages have been deleted.',
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

