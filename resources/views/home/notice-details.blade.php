@extends('layouts/memberheader')
@section('page_title','Diagnostic Dashboard')
@section('notice_details','active')
@section('content')

   <!-- Banner Image with About Us Text -->
   <div class="breadcrub-banner position-relative text-center">
        <img
            src="{{asset('images/duimage1.jpg')}}"
            alt="Banner Image"
            class="img-fluid"
        />
        <h1 class="position-absolute top-50 start-50 translate-middle text-white z-10" data-aos="fade-up"> Notice Details </h1>
    </div>

<div class="container mt-5">
        <div class="card">
       
            <div class="card-body">
                <h5 class="card-title"> {{$data->title}} </h5>
                <p class="text-muted"> Published On : {{$data->date}} </p>
                @if(empty($data->image))

                @else
                <img src="{{ empty($data->image) ? asset('images/duimage.jpg') : asset('uploads/admin/'.$data->image) }}" class="card-img-top" alt="Notice Image" style="max-width: 700px;">
                @endif
                
                <p class="card-text">
                   {!!$data->desc!!}
                </p>
               
            </div>
        </div>
    </div>

@endsection