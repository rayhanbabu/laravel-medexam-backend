@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('maintain','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
     <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Maintain Data List </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                               
                         </div>
                     </div>

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex">
                           
                         </div>
                     </div> 
         </div>
           
         @if(Session::has('fail'))
             <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
         @endif
                        
        @if(Session::has('success'))
              <div  class="alert alert-success"> {{Session::get('success')}}</div>
         @endif


      </div>
  <div class="card-body">   

   <div class="row">
         <div class="col-md-12">
           <div class="table-responsive">
                <table class="table  table-bordered data-table">
                   <thead>
                     <tr>

                         <td> Current Service Charge </td>
                         <td>  Date  </td>
                         <td>  Edit </td>
                    
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
           url: "{{ url('/admin/maintain') }}",
           error: function(xhr, error, code) {
               console.log(xhr.responseText);
           }
       },
       order: [[0, 'desc']],
       columns: [
            {data: 'service_charge', name: 'service_charge'},
            {data: 'spend_date', name: 'spend_date'},
            {data: 'edit', name: 'edit'},
         
       ]
   });
});



           $(document).ready(function(){
                $(document).on('click','.edit',function(){
                  
                   var id = $(this).data("id");
                   var spend_date = $(this).data("spend_date");
                   var service_charge = $(this).data("service_charge");
                  
                   
                     $('#edit_id').val(id);
                     $('#edit_spend_date').val(spend_date);
                     $('#edit_service_charge').val(service_charge);
                  
                      console.log(service_charge);
                     $('#updatemodal').modal('show');
                });

           });


</script>



<!-- Modal Edit -->
<div class="modal fade" id="updatemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">  Maintain Data Edit  </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
      <form method="post" action="{{url('admin/maintain_update')}}"  class="myform"  enctype="multipart/form-data" >
         {!! csrf_field() !!}

         <input type="hidden" id="edit_id" name="id" class="form-control">

         <div class="row px-3">


           <div class="form-group  col-sm-6  my-2">
               <label class=""><b> Current  Service Charge </b></label>
               <input type="number" id="edit_service_charge"  name="service_charge" class="form-control" required>
          </div> 
         
           <div class="form-group  col-sm-6  my-2">
               <label class=""><b> Date </b></label>
               <input type="date" id="edit_spend_date"  name="spend_date" class="form-control" required>
          </div> 


    </div>

     <br>
      <input type="submit"   id="insert" value="Update" class="btn btn-success" />
	  
              
   </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



      



   


@endsection