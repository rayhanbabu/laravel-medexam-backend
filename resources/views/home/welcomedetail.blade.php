@extends('layouts/memberheader')
@section('page_title','Welcome Dashboard')
@section('welcome_details','active')
@section('content')

   <!-- Banner Image with About Us Text -->
   <div class="breadcrub-banner position-relative text-center">
        <img
            src="{{asset('images/duimage1.jpg')}}"
            alt="Banner Image"
            class="img-fluid"
        />
        <h1 class="position-absolute top-50 start-50 translate-middle text-white z-10" data-aos="fade-up"> Welcome Message</h1>
    </div>

    <div class="message my-3"  data-aos="fade-up"data-aos-offset="-200" data-aos-duration="500" data-aos-once="true">
  <div class="container p-3 shadow bg-white">
    <div class="row ">
      <!-- Image column -->
      <div class="col-md-3 col-sm-12 text-center mb-3" >
      <img src="{{ asset('uploads/admin/'.$data->image) }}" alt="doctor" style="height:200px;" class="img-fluid">
        <div class="mt-2">
             <strong> {!!$data->title!!}  </strong>
               
        </div>
      </div>
      <!-- Text column -->
      <div class="col-md-9 col-sm-12">
        <h3 style="color:#695cd4;"> {!!$data->link!!} </h3>
        <p style="font-size: 18px;"> {!! $data->desc !!} </p>
       
        <!-- <button class="main-btn">Read More...</button> -->
      </div>
    </div>
  </div>
</div>


@endsection