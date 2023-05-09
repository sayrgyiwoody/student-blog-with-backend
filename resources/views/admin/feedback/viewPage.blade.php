@extends('admin.layout.master')

@section('content')

<div class="main-content">
    @section('header')
        <h4>Feedback Message Information</h4>
    @endsection

    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-lg-7 offset-2">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2 "><strong>Message Information</strong></h3>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-2 fw-bold ms-2">
                                <p>Name</p>
                                <p>Email</p>
                                <p>Sent Date</p>
                                <p>Subject</p>
                                <p>Message</p>
                            </div>
                            <div class="row col-10">
                                <p>{{$message->name}}</p>
                                <p>{{$message->email}}</p>
                                <p>{{$message->created_at->format('F-j-Y')}}</p>
                                <p>{{$message->subject}}</p>
                                <p style="white-space: pre-wrap">{{$message->message}}</p>
                            </div>
                        </div>
                        <hr>
                        <a href="{{route('admin#feedbackPage')}}" class="btn btn-secondary px-3 "><i class="fa-solid fa-arrow-left me-2"></i>Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
