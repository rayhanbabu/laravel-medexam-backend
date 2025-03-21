@extends('layouts/memberheader')
@section('page_title','Diagnostic Dashboard')
@section('diagnostic_test','active')
@section('content')


  <!-- banner -->
  <div class="banner  ">
      <div class="slider my-0">

         @foreach($slider as $row)
          <div class="slider_item">
            <img
              src="{{asset('uploads/admin/'.$row->image)}}"
              alt="banner_image"       
              class="banner_image"
            />
          </div>
        @endforeach
       
      </div>
    </div>




      <!-- about section start -->
      <div class="container about-us">
      <div class="row align-items-center">
        <div class="col-md-5" data-aos="fade-right" data-aos-offset="-200" data-aos-duration="500" data-aos-once="true">
          <img
            src="{{ asset('uploads/admin/'.$about->image) }}"
            alt="About Us"
            style="height: 300px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.339)"
          />
        </div>
        <div class="col-md-7 content" data-aos="fade-left" data-aos-offset="-200" data-aos-duration="500" data-aos-once="true" >
          
             {!! $about->short_desc !!}
          <br><br>
          <a href="{{url('aboutdetail')}}" class="btn btn-primary readbtn ">Read More</a>
        </div>
      </div>
    </div>
    <!-- About Us Section End -->



      <!-- counter section start -->
 
<section class="section-counter">
    <div class="container counter">
      <div class="row">
        <div class="col-md-3 col-sm-6 counter-item">
        <i class="bi bi-house-door"></i>
          <h3>1989</h3>
          <p>Founded </p>
        </div>
        <div class="col-md-3 col-sm-6 counter-item">
        <i class="bi bi-building"></i>
          <h3> 628 </h3>
          <p> Plot</p>
        </div>
        <div class="col-md-3 col-sm-6 counter-item">
        <i class="bi bi-people-fill"></i>
          <h3> 700 </h3>
          <p> Member  </p>
        </div>
        <div class="col-md-3 col-sm-6 counter-item">
        <i class="bi bi-person"></i>
          <h3>9</h3>
          <p> Eecutive memebr </p>
        </div>
      </div>
    </div></section>
    <!-- counter section end -->



  
@foreach($welcome as $row)
  <!-- banner -->
  <div class="message my-3"  data-aos="fade-up" data-aos-offset="-200" data-aos-duration="500" data-aos-once="true">
  <div class="container p-3 shadow bg-white">
    <div class="row ">
      <!-- Image column -->
      <div class="col-md-3 col-sm-12 text-center mb-3" >
      <img src="{{ asset('uploads/admin/'.$row->image) }}" alt="doctor" style="height:200px;" class="img-fluid">
        <div class="mt-2">
             <strong> {!!$row->title!!}  </strong>
               
        </div>
      </div>
      <!-- Text column -->
      <div class="col-md-9 col-sm-12">
        <h3 style="color:#695cd4;"> {!! $row->link!!} </h3>
        <p style="font-size: 18px;"> {!! $row->short_desc !!} </p>
        <a href="{{url('welcometdeatil/'.$row->id)}}" class="btn btn-primary readbtn ">Read More</a>
        <!-- <button class="main-btn">Read More...</button> -->
      </div>
    </div>
  </div>
</div>
@endforeach


<div class="news">
  <div class="container border pb-5">
    <h2 class="text-center my-3"> Notice  </h2>
    <hr>
    <div class="news-slider my-2 ">


     @foreach($news as $row)
      <div class="slider_box shadow p-3">

       <a href="{{url('notice-details/'.$row->id)}}">
        <div class="">
          <img src="{{ empty($row->image) ? asset('images/images.jpg') : asset('uploads/admin/'.$row->image) }}" 
           alt="image" 
            style="height: 230px; object-fit: cover; width: 100%;">
        </div>
        <div>
          <p class="mt-3"> {{$row->date}} </p>
          <h5> {{$row->title}} </h5>
         
         </div>
      </a>

    </div>
   @endforeach

  
  
    </div>
  </div>
 </div>



 
    <!-- recent activities -->
    <div class="recent_activities">
      <h2 class="text-center my-5">Recent Activities</h2>
      <div class="container mx-auto row g-4 justify-content-center p-2">
          <!-- Owl Carousel Wrapper -->
          <div class="carousel-activities">

          @foreach($activities as $data)
            <!-- Course Item 1 -->
            <div
              class="courses-item d-flex flex-column bg-white overflow-hidden shadow ">
              <div class="position-relative mt-auto p-2">
                <img
                  class="img-fluid"
                  src="{{ empty($data->image) ? asset('images/images.jpg') : asset('uploads/admin/'.$data->image) }}"
                   style="height: 230px; object-fit: cover; width: 100%;"
                />
                <div class="courses-overlay">
                  <a class="btn btn-outline-primary border-2" href="{{url('notice-details/'.$data->id)}}"
                    >Read More</a
                  >
                </div>
              </div>
              <div class="text-center py-4 pt-3">
                <p> {{$data->title}} </p>
              </div>
            </div>

            @endforeach

            
             

            <!-- Repeat for more items as needed -->
          </div>
        </div>
     </div>
    <!-- recent activities -->


@endsection