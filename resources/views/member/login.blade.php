@extends('layouts/memberheader')
@section('page_title','Login Page')
@section('Login','active')
@section('content')


   <style>
        .verifyform{
            display:none;
         }	
   </style>

  <div class="loginform"> 

     <div class="login-container">
       <h3 class="text-center login-header">Login</h3>
        <form method="post"  action="{{ url('member/login-insert') }}"   class="myform"  enctype="multipart/form-data" >
           @csrf
        <div class="mb-3">
          <label for="email" class="form-label">  Phone Number </label>
          <input type="text"
            class="form-control"
            id="phone"
			      name="phone"
            placeholder="Enter your Phone Number" required />
         </div>
		

     <div class="mb-3">
          <label for="email" class="form-label">  Password </label>
          <input type="password"
            class="form-control"
            id="password"
			      name="password"
            placeholder="Enter your Password" required />
         </div>

      

         @if ($errors->any())
          <div class="alert alert-danger">
             <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
           </div>
       @endif


                @if(Session::has('fail'))
                    <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
                @endif
                           
                @if(Session::has('success'))
                   <div  class="alert alert-success"> {{Session::get('success')}}</div>
                @endif
       
             <button type="submit" id="add_employee_btn" class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>

  </div>





@endsection