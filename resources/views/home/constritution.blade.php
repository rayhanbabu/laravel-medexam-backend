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
        <h1 class="position-absolute top-50 start-50 translate-middle text-white z-10" data-aos="fade-up"> Constritution </h1>
    </div>

    <!-- About Us Text in Container with Shadow -->
    <div class="container mt-5 p-4 shadow">
        <p data-aos="fade-up" data-aos-delay="100">
              {!! $data->desc !!}
        </p>
       
    </div>

@endsection