@extends('layouts/memberheader')
@section('page_title','Dashboard Page')
@section('Dashboard ','active')
@section('content')



     @php
              $value = $balance?$balance->balance:0; 
       @endphp




<div class="container2">
        <div class="profile-card">
            <!-- Profile Header -->
            <div class="profile-header">
                <img src="{{asset('uploads/admin/'.$member->image)}}" alt="Profile" class="profile-image">
            </div>

               

            <!-- Profile Content -->
            <div class="profile-content">
            <div class="d-inline-flex align-items-left  justify-content-between  p-2">
    <h3 class="text-danger mb-0">  @if($value < 0) Total Due : {{ $value }}TK @else
                                              Balance : {{ $value }}TK
                                   @endif  </h3> 
     </div>

     <div class="d-inline-flex align-items-left  justify-content-between  p-2">
     <a href="{{url('aboutdetail')}}" class="btn btn-primary readbtn "> Pay Now </a>
</div>

 

                <div class="profile-grid">
            
                    <!-- Left Column -->
                    <div>
                   
                      
                        <div>
                            <span class="label">Member Name </span>
                            <p class="value"> {{$member->member_name}} </p>
                        </div>
                        <div>
                            <span class="label">Member No</span>
                            <p class="value">j{{$member->member_no }}</p>
                        </div>
                        <div>
                            <span class="label">Phone</span>
                            <p class="value">{{$member->phone}} </p>
                        </div>
                        <div>
                            <span class="label">E-mail</span>
                            <p class="value"> {{$member->email }} </p>
                        </div>
                        <div>
                            <span class="label">Department/ Organization </span>
                            <p class="value"> {{$member->dept}}  </p>
                        </div>
                        <div>
                            <span class="label">Member Category</span>
                            <p class="value"> {{$member->member_category}}  </p>
                        </div>

                        <div>
                            <span class="label">Member Sub Category</span>
                            <p class="value"> {{$member->member_type}} </p>
                        </div>

                        <div>
                            <span class="label"> Current Address  </span>
                            <p class="value"> {{$member->current_address}}  </p>
                        </div>

                        <div>
                            <span class="label"> Permanent Address </span>
                            <p class="value"> {{$member->permanet_address}}  </p>
                        </div>

                    </div>

                    <!-- Right Column -->
                    <div>
                     
                        <div>
                            <span class="label">Plot No</span>
                            <p class="value"> {{$member->plot_no}}  </p>
                        </div>
                        <div>
                            <span class="label">Deed No</span>
                            <p class="value"> {{$member->deed_no}}  </p>
                        </div>
                        <div>
                            <span class="label">Date of Deed</span>
                            <p class="value">{{$member->date_of_deed}} </p>
                        </div>
                        <div>
                            <span class="label"> Land Price </span>
                            <p class="value">{{$member->land_price}} </p>
                        </div>
                        
                        <div>
                            <span class="label">Jot No</span>
                            <p class="value">{{$member->farm_no}} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>







@endsection