<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title> Dhaka University Teacher's Multi-Purpose Co-operative Society LTD</title>

    <link rel="stylesheet" href="{{asset('frontend/css/style2.css')}}" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon" />

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet"/>

   
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css"
      integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"
      integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
 
   
    <!-- Customized Bootstrap Stylesheet -->
     <script src="{{asset('dashboardfornt/js/jquery-3.5.1.js')}}"></script>
     <script src="{{asset('dashboardfornt/js/bootstrap.bundle.min.js')}}"></script>
     <script src="{{asset('dashboardfornt\js\jquery.dataTables.min.js')}}"></script>
     <script src="{{asset('dashboardfornt\js\dataTables.bootstrap5.min.js')}}"></script>
     <script src="{{asset('dashboardfornt/js/sweetalert.min.js')}}"></script>
     <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet"/>
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <script src="{{asset('frontend/js/main.js')}}"></script>
  </head>
  <body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg sticky-top px-0">
      <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo on the left side -->
        <div class="logo">
          <a href="{{url('/')}}">
            <img src="{{asset('frontend/img/header.png')}}" class="header_logo"  alt="logo" />
          </a>
        </div>

        <!-- Toggle button for mobile view -->
        <button
          type="button"
          class="navbar-toggler"
          style="color: black;"
          data-bs-toggle="collapse"
          data-bs-target="#navbarCollapse"
        >
        <i class="bi bi-list toggler_btn"></i>
          <!-- You can use Bootstrap's default toggler icon -->
        </button>

        <!-- Menu items on the right side -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav ms-auto">
            <!-- ms-auto will push items to the right -->

            <li class="nav-item dropdown">

            </li>
                <li class="nav-item">
               <a href="{{url('/')}}" class="nav-link"> Home </a>
            </li>


            <li class="nav-item dropdown">
              <a
                href="#"
                class="nav-link dropdown-toggle"
                data-bs-toggle="dropdown"> About   </a>
          <ul class="dropdown-menu">
             <li><a href="{{url('aboutdetail')}}" class="dropdown-item"> About Us </a></li>
             <li><a href="{{url('constritution')}}" class="dropdown-item"> Constritution  </a></li>
             <li><a href="{{url('committee_information/Former_President')}}" class="dropdown-item"> Former President  </a></li>
             <li><a href="{{url('committee_information/Former_Secretary')}}" class="dropdown-item"> Former Secretary  </a></li>
                    
          </ul>
          
            

         <li class="nav-item dropdown">
              <a
                href="#"
                class="nav-link dropdown-toggle"
                data-bs-toggle="dropdown"> People  </a>
          <ul class="dropdown-menu">
             <li><a href="{{url('committee_information/Committee')}}" class="dropdown-item"> Executive Committee </a></li>
             <li><a href="{{url('committee_information/Staff')}}" class="dropdown-item"> Office Staff  </a></li>
                    
          </ul>


    
          
          </li>
                <li class="nav-item">
               <a href="{{url('/contact')}}" class="nav-link"> Contact Us </a>
            </li>


            </li>
                <li class="nav-item">
               <a href="{{url('/gallery')}}" class="nav-link"> Gallery </a>
            </li>

         



            @if(member_info() && member_info()['email'])
              <li class="nav-item dropdown">
                <a
                  href="#"
                  class="nav-link dropdown-toggle"
                  data-bs-toggle="dropdown"> Profile </a>
                <ul class="dropdown-menu">
                         <li><a href="{{url('/member/dashboard')}}" class="dropdown-item"> {{ member_info()['member_name'] }}  </a></li>
                         <li><a href="{{url('/member/credit')}}" class="dropdown-item"> Credit </a></li>
                         <li><a href="{{url('/member/debit')}}" class="dropdown-item"> Debit </a></li>
                         <li><a href="{{url('/member/logout')}}" class="dropdown-item">Logout</a></li>
                 
                </ul>
              </li>
            <!-- Repeat similar structure for other dropdowns -->
           @else
                </li>
                      <li class="nav-item">
                     <a  href="{{url('/member/login')}}" class="nav-link"> Member Login  </a>
                </li>
           @endif

       

            <!-- Repeat similar structure for other dropdowns -->
          </ul>
        </div>
      </div>
    </nav>
    <!-- Navbar End -->

       <div>
                 @yield('content')
             
     </div>


     <!-- Footer Section -->
<footer class="bg-dark mt-5 text-white py-5">
  <div class="container">
    <div class="row">

      <!-- Column 1: Contact Info -->
      <div class="col-md-4 col-sm-12 mb-4">
        <h5 class="text-white" style="font-size: 35px;"> Contact Information </h5>
        <ul class="list-unstyled">
          <li> Mobile: 01930643794  </li>
          <li> Email: duths@du.ac.bd  </li>
          <li> Dhaka University Club, Nilkhet Road <br>
               University of Dhaka <br>
               Dkaka-1000, Bangladesh.  </li>
        </ul>
        <h5 class="text-white">Follow Us</h5>
        <div class="social-icons">
          <a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a>
          <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
          <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
          <a href="#" class="text-white"><i class="fab fa-linkedin"></i></a>
        </div>
      </div>

      <!-- Column 2: Links with Arrows -->
      <div class="col-md-4 col-sm-12 mb-4">
        <h5 class="text-white" style="font-size: 25px;">Useful Links</h5>
        <ul class="list-unstyled ">
             <li><a href="#" class="text-white"> Home</a></li>
             <li><a href="#" class="text-white"> About Us</a></li>
             <li><a href="#" class="text-white"> Services</a></li>
             <li><a href="#" class="text-white"> Blog</a></li>
        </ul>
      </div>

      <!-- Column 3: Find Us on Map -->
      <div class="col-md-4 col-sm-12 mb-4">
        <h5>Find Us on Map</h5>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d144.95592381590443!3d-37.81720997975133!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d0e6d0d3e5a9!2sFederation+Square!5e0!3m2!1sen!2sau!4v1617680263776!5m2!1sen!2sau"
          width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      </div>

    </div>

    <!-- Horizontal line -->
    <hr class="border-light mt-4">

    <!-- All rights reserved -->
    <div class="row pt-3">
      <p class="mb-0 col-md-8">&copy; 2024 Dhaka University Teacher's Multi-Purpose Co-operative Society LTD. All Rights Reserved.</p>
      <p class="col-md-4 ancova">Developed by, <a href="http://ancova.com.bd/"><img src="{{asset('images/ancova.png')}}" width="100" alt="website image"></a></p>
    </div>
  </div>
</footer>
   
 
<script
      src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"
      integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
  </body>
</html>
