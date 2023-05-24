@extends('admin.layout.master')

@section('title','User Account List')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <form action="{{route('admin#userAccountList')}}" method="get">
                                <div class="input-group input-group-lg flex-nowrap shadow_2 rounded">
                                    <button type="submit" class="input-group-text btn" id="addon-wrapping"><i class="fa-regular fa-magnifying-glass fw-semibold text-primary"></i></button>
                                    <input name="searchKey" value="{{request('searchKey')}}" type="text" class="form-control shadow_2" placeholder="search user" aria-label="Username" aria-describedby="addon-wrapping">
                                </div>
                            </form>
                        </div>
                        <div class="table-data__tool-right">
                            <button type="button" class="btn btn-primary">
                                <i class="fa-solid fa-users me-2"></i> <span class="badge text-primary text-bg-light">{{count($accounts)}}</span>
                            </button>
                        </div>
                    </div>
                    @if (session('adminRoleChangeAlert'))

                        @section('scriptSource')
                            <script>
                                Swal.fire({
                                position: 'center',
                                icon: 'success',
                                text: '{{session('adminRoleChangeAlert')}}',
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
                    @if (count($accounts) != null)
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-hover table-striped mb-0 text-center">
                            <thead class="text-white " style="background-color: #262626;">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Approve Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($accounts as $account)
                            <tr>
                                <td class="">
                                    <div class="mx-auto" style="width: 75px; height: 75px; overflow: hidden;">
                                    <img class="w-100 h-100 rounded" style="object-fit: cover; object-position:center;" src="https://ui-avatars.com/api/?name={{$account->name}}"/>
                                    </div>
                                </td>
                                <td class="align-middle">{{$account->name}}</td>
                                <td class="align-middle">{{$account->email}}</td>
                                <td class="align-middle">{{$account->gender}}</td>
                                <td class="align-middle">@if ($approveStatus[$account->id] == null)
                                    null
                                @elseif ($approveStatus[$account->id] != null)
                                    @if ($approveStatus[$account->id]->status == '0')
                                    pending
                                    @elseif($approveStatus[$account->id]->status == '1')
                                    approved
                                    @endif
                                @endif</td>
                                <td class="align-middle">
                                    <div class="table-data-feature">
                                        <a href="{{route('admin#approve',$account->id)}}">
                                            <button class="btn btn-white  rounded-0 me-2 shadow_2 " >
                                                <i class="fa-solid fa-check" style="color: #262626"></i>
                                            </button>
                                        </a>
                                        <a href="{{route('admin#changeAdminRole',$account->id)}}">
                                            <button class="btn btn-white  rounded-0 me-2 shadow_2 " >
                                                <i class="fa-solid fa-shield-halved" style="color: #262626"></i>
                                            </button>
                                        </a>
                                        <input type="hidden" class="account-id" value="{{$account->id}}">
                                        <button class="btn btn-white rounded-0 me-3 delete-account shadow_2">
                                            <i class="zmdi zmdi-delete" style="color: #262626"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <h3 class="text-secondary text-center">There's no account to show!<i class="fa-solid fa-face-frown-open ms-2"></i></h3>
                    @endif
                    <!-- END DATA TABLE -->
                    <div class="mt-2">
                    {{$accounts->appends(request()->query())->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

@endsection


@section('scriptSource')


<script>
    $('.delete-account').click(function() {
            $parentNode = $(this).parents('tr');
            $account_id = $parentNode.find('.account-id').val();
            Swal.fire({
            title: 'Are you sure?',
            text: "This account and his saved informations will be deleted forever!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type : 'get',
                    url : '/admin/account/delete',
                    data : {'account_id' : $account_id},
                    dataType : 'json',
                    success : function() {
                        Swal.fire(
                        'Deleted!',
                        'Account has been deleted.',
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
