@extends('layouts/memberheader')
@section('page_title','Dashboard Page')
@section('Dashboard ','active')
@section('content')


  <div class="container ">
     
        <!-- Left Side: Form -->



        <div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header bg-primary">
  <div class="row ">
               <div class="col-8"> <h5 class="mt-0 text-white"> List of Debited </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                                      
                         </div>
                     </div>

                    
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                          
                         </div>
                     </div> 
         </div>
           
         @if(Session::has('fail'))
             <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
         @endif
                        
        @if(Session::has('success'))
              <div  class="alert alert-success"> {{Session::get('success')}}</div>
            @endif

            @if ($errors->any())
          <div class="alert alert-danger">
             <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
           </div>
       @endif

      </div>
  <div class="card-body">   

   <div class="row">
         <div class="col-md-12">
           <div class="table-responsive">
                <table class="table  table-bordered data-table">
                   <thead> 

                     <tr>       
                         <td> Id </td>
                         <td> Date </td>
                         <td> Description </td>
                         <td> Amount </td>
                      </tr>
                      
                   </thead>
                   <tbody>

                   </tbody>

                </table>
          </div>
       </div>
    </div>


  </div>
</div>





<script>
       $(function() {
   var table = $('.data-table').DataTable({
       processing: true,
       serverSide: true,
       ajax: {
           url: "{{ url('/member/debit') }}",
           error: function(xhr, error, code) {
               console.log(xhr.responseText);
           }
       },
       order: [[0, 'desc']],
       columns: [
            {data: 'id', name: 'id'},
            {data: 'date', name: 'date'},
            {data: 'debit_desc', name: 'debit_desc'},
            {data: 'amount', name: 'amount'},      
       ]
   });
});

   </script>


      

      



   
    
    </div>
  



@endsection