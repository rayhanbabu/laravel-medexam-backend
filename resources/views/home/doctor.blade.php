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
        <h1 class="position-absolute top-50 start-50 translate-middle text-white z-10" data-aos="fade-up"> {{$page_detail->page_name}} </h1>
    </div>

  

    <!-- Team Start -->
    <div class="container-xxl ">
      <div class="container">
        <div
          class="text-center mx-auto mb-5 wow fadeInUp"
          data-wow-delay="0.1s"
          style="max-width: 500px"
        >
         
        </div>
        <div class="row g-0 team-items">

        @foreach($data as $row)
          <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="team-item position-relative text-center">
              <div class="position-relative mt-auto" style="height:300px ; width:auto">
              <img class="img-fluid" 
         src="{{ !empty($row->image) ? asset('uploads/admin/'.$row->image) : asset('images/default.png') }}" 
         alt="Image" 
         style="max-height: 100%; max-width: 100%; object-fit: cover;" />
                <div class="team-overlay">
                  <a class="btn btn-outline-primary border-2" href="{{url('committee_information_detail/'.$row->id)}}"
                    > View Detail </a
                  >
                </div>
              </div>
              <div class="bg-light text-center p-4">
                <h5 class="mt-2">{{$row->title}}</h5>
                <span>{{$row->link}}</span>
              </div>
            </div>
          </div>
          @endforeach

        
  
  
        </div>
      </div>
    </div>
    <!-- Team End -->


@endsection