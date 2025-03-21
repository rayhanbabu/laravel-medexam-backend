@extends('layouts/memberheader')
@section('page_title','Diagnostic Dashboard')
@section('diagnostic_test','active')
@section('content')

   <!-- Banner Image with About Us Text -->
   <div class="breadcrub-banner position-relative text-center">
        <img
            src="{{asset('images/duimage1.jpg')}}"
            alt="Banner Image"
            class="img-fluid"
        />
        <h1 class="position-absolute top-50 start-50 translate-middle text-white z-10" data-aos="fade-up"> Profile Details </h1>
    </div>

<div class="container my-5 ">
    <div class="d-flex align-items-center justify-content-center flex-col">

    <div class="doctor-profile row  mt-3">
      <!-- Doctor Image -->
      <div class="col-lg-4 col-md-5 col-sm-12 d-flex justify-content-center mb-4 mb-lg-0">
        <img src="{{ !empty($data->image) ? asset('uploads/admin/'.$data->image) : asset('images/default2.png') }}" alt="Doctor Image">
      </div>
         <!-- Doctor Profile Details -->
         <div class="col-lg-8 col-md-7 col-sm-12 profile-details">
                {!! $data->title !!}  <br>

                {!! $data->link !!}  <br>

                {!! $data->desc !!}
          </div>
    </div>
    </div>
  </div>


@endsection