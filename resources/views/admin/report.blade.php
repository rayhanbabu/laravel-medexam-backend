@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('report','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
    <div class="row ">
      <div class="col-8">
        <h5 class="mt-0"> Reports </h5>
      </div>
      <div class="col-2">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">

        </div>
      </div>


      <div class="col-2">
        <div class="d-grid gap-2 d-md-flex ">

        </div>
      </div>
    </div>
  </div>

  <div class="card-body">
    <div class="row">


    
      

      <div class="col-md-4 p-2">
        <div class="card shadow-sm">
          <div class="mx-3 my-2">
            <b class="text-center">Table: 1  Account Statement </b>
            <hr>
          </div>
          <form action="{{ url('reportdompdf/account_statement') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <div class="d-grid gap-3 d-flex justify-content-start p-3">
                    <select name="member_id"   class="form-control js-example-disabled-results" style="max-width:300px;" required>
                           <option value=""> Select Member Name Or Number  </option>
                            @foreach($member as $row)
                              <option value="{{ $row->id }}">
                               {{ $row->member_no }} {{ $row->member_name }}
                              </option>
                           @endforeach
                   </select>
             </div>

            <div class="d-grid gap-3 d-flex justify-content-end p-3">
              <input type="date" name="date1" class="form-control form-control-sm" required>
              To
              <input type="date" name="date2" class="form-control form-control-sm" required>
            </div>

            <div class="form-group  mx-3 my-3">
              <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
            </div>
          </form>
        </div>
      </div>



      <div class="col-md-4 p-2">
        <div class="card shadow-sm">
          <div class="mx-3 my-2">
            <b class="text-center">Table: 2  Account Debited </b>
            <hr>
          </div>
          <form action="{{ url('reportdompdf/account_debit') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <div class="d-grid gap-3 d-flex justify-content-start p-3">
                    <select name="member_id"   class="form-control js-example-disabled-results_table2" style="max-width:300px;" required>
                           <option value=""> Select Member Name Or Number  </option>
                            @foreach($member as $row)
                              <option value="{{ $row->id }}">
                               {{ $row->member_no }} {{ $row->member_name }}
                              </option>
                           @endforeach
                   </select>
             </div>

            <div class="d-grid gap-3 d-flex justify-content-end p-3">
              <input type="date" name="date1" class="form-control form-control-sm" required>
              To
              <input type="date" name="date2" class="form-control form-control-sm" required>
            </div>

            <div class="form-group  mx-3 my-3">
              <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
            </div>
          </form>
        </div>
      </div>



      <div class="col-md-4 p-2">
        <div class="card shadow-sm">
          <div class="mx-3 my-2">
            <b class="text-center">Table: 3  Account Credited </b>
            <hr>
          </div>
          <form action="{{ url('reportdompdf/account_credit') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <div class="d-grid gap-3 d-flex justify-content-start p-3">
                    <select name="member_id"  class="form-control js-example-disabled-results_table3" style="max-width:300px;" required>
                           <option value=""> Select Member Name Or Number  </option>
                            @foreach($member as $row)
                              <option value="{{ $row->id }}">
                               {{ $row->member_no }} {{ $row->member_name }}
                              </option>
                           @endforeach
                   </select>
             </div>

            <div class="d-grid gap-3 d-flex justify-content-end p-3">
              <input type="date" name="date1" class="form-control form-control-sm" required>
              To
              <input type="date" name="date2" class="form-control form-control-sm" required>
            </div>

            <div class="form-group  mx-3 my-3">
              <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
            </div>
          </form>
        </div>
      </div>



    

      <div class="col-md-4 p-2">
        <div class="card shadow-sm">
          <div class="mx-3 my-2">
            <b class="text-center">Table: 4 Range wise  Credited  Report</b>
            <hr>
          </div>
          <form action="{{ url('reportdompdf/range_credit') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <div class="d-grid gap-3 d-flex justify-content-start p-3">
                    <select name="bank_id"  class="form-control js-example-disabled-results_table4" style="max-width:300px;" required>
                           <option value=""> Select Bank Name  </option>
                           
                   </select>
             </div>

            <div class="d-grid gap-3 d-flex justify-content-end p-3">
              <input type="date" name="date1" class="form-control form-control-sm" required>
              To
              <input type="date" name="date2" class="form-control form-control-sm" required>
            </div>

            <div class="form-group  mx-3 my-3">
              <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
            </div>
          </form>
        </div>
      </div>






      <div class="col-md-4 p-2">
        <div class="card shadow-sm">
          <div class="mx-3 my-2">
            <b class="text-center">Table: 5 Range wise  Spend  Report</b>
            <hr>
          </div>
          <form action="{{ url('reportdompdf/range_spend') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <div class="d-grid gap-3 d-flex justify-content-start p-3">
                    <select name="spendcategory_id"  class="form-control js-example-disabled-results_table5" style="max-width:300px;" required>
                           <option value=""> Select Spend category </option>
                           
                   </select>
             </div>

            <div class="d-grid gap-3 d-flex justify-content-end p-3">
              <input type="date" name="date1" class="form-control form-control-sm" required>
              To
              <input type="date" name="date2" class="form-control form-control-sm" required>
            </div>

            <div class="form-group  mx-3 my-3">
              <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
            </div>
          </form>
        </div>
      </div>



      <div class="col-md-4 p-2">
        <div class="card shadow-sm">
          <div class="mx-3 my-2">
            <b class="text-center">Table: 6 Current Member  Report</b>
            <hr>
          </div>
          <form action="{{ url('reportdompdf/all_member_report') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <input type="hidden" name="date1" class="form-control form-control-sm">

            <div class="form-group  mx-3 my-3">
              <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
            </div>
          </form>
        </div>
      </div>


       
      <div class="col-md-4 p-2">
        <div class="card shadow-sm">
          <div class="mx-3 my-2">
            <b class="text-center">Table: 7 Range wise Transaction Report </b>
            <hr>
          </div>
          <form action="{{ url('reportdompdf/range_transaction') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}


            <div class="d-grid gap-3 d-flex justify-content-end p-3">
              <input type="date" name="date1" class="form-control form-control-sm" required>
              To
              <input type="date" name="date2" class="form-control form-control-sm" required>
            </div>

            <div class="form-group  mx-3 my-3">
              <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
            </div>
          </form>
        </div>
      </div>



    </div>
  </div>

</div>


<script> 

jQuery('.js-example-disabled-results').select2();
jQuery('.js-example-disabled-results_table2').select2();
jQuery('.js-example-disabled-results_table3').select2();
jQuery('.js-example-disabled-results_table4').select2();
jQuery('.js-example-disabled-results_table5').select2();


</script>s













@endsection