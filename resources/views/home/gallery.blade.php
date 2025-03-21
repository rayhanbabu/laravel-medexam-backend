@extends('layouts/memberheader')
@section('page_title','Diagnostic Dashboard')
@section('notice_details','active')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/lightgallery@2.3.0/css/lightgallery-bundle.min.css" rel="stylesheet">

   <!-- Banner Image with About Us Text -->
   <div class="breadcrub-banner position-relative text-center">
        <img
            src="{{asset('images/duimage1.jpg')}}"
            alt="Banner Image"
            class="img-fluid"
        />
        <h1 class="position-absolute top-50 start-50 translate-middle text-white z-10" data-aos="fade-up"> Gallery </h1>
    </div>


    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .gallery-heading {
            text-align: center;
            margin: 20px 0;
            font-size: 2em;
        }
        #lightgallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }
        #lightgallery a {
            width: 200px;
            height: 150px;
            overflow: hidden;
        }
        #lightgallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

    <!-- About Us Text in Container with Shadow -->
    <section>

       <br>
        <div id="lightgallery">
            @foreach($data as $row)
               <a href="{{asset('uploads/admin/'.$row->image)}}" data-lg-size="1600x2400">
                    <img alt="Image 1" src="{{asset('uploads/admin/'.$row->image)}}" />
               </a>
            @endforeach
            
        </div>
    </section>
     

     <!-- LightGallery JS -->
     <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.3.0/lightgallery.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.3.0/plugins/thumbnail/lg-thumbnail.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.3.0/plugins/zoom/lg-zoom.umd.min.js"></script>

    <script>
        // Initialize LightGallery
        lightGallery(document.getElementById('lightgallery'), {
            plugins: [lgThumbnail, lgZoom],
            speed: 500,
        });
    </script>
   

@endsection