@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('admin_select','active')
@section('content')

<div class="card mt-2">
  <div class="card-body">

<div class="row">


    <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card ">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="success"> 34  </h3>
                            </h3>
                            <span> Total Member </span>
                        </div>
                        <div class="align-self-center">
                            <i class="icon-cup success font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress mt-1 mb-0" style="height: 7px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


     
   


    <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card ">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="success"> 45TK</h3>
                            </h3>
                            <span> Current Month Transaction(Offline) </span>
                        </div>
                        <div class="align-self-center">
                            <i class="icon-cup success font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress mt-1 mb-0" style="height: 7px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    </div>
  </div>

  
   


@endsection