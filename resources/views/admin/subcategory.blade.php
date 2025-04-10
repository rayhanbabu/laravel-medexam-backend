@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('sub_category','active')
@section('content')

<div class="row mt-2 mb-0 mx-1 shadow p-1">
    
       <div class="col-sm-4 my-2">
           <form  method="get" enctype="multipart/form-data">   
       
              <select name="course_id" id="course_id" class="js-example-disabled-results" style="width:300px;" aria-label="Default select example" required>
                     <option value=""> Select Course </option>
                      @foreach($course as $row)  
                          @if($row->id==($course_id?$course_id->id:0))
                                <option  value="{{$row->id}}" selected> 
                               {{$row->course_name}}</option>
                           @else
                             <option value="{{$row->id}}">{{$row->course_name}}</option>
                           @endif
                      @endforeach
              </select>
      </div>


      <div class="col-sm-4 my-2">
                <select name="category_id" id="category_id" class="js-example-disabled-results" style="width:300px;" aria-label="Default select example" required>       
                </select>       
       </div>
       
    

        <div class="col-sm-2 mt-2">
              <button type="submit" name="search" class="btn btn-primary btn-sm">Search</button>
         </div>
      </form>
    </div>


    @if($course_id!="" && $category_id!="")    
  <div class="card">
  <div class="card-header">

  <div class="row">
          <div class="col-6"> <h5 class="mt-0"> <b> Course  </b> : {{$course_id?$course_id->course_name:"" }} 
                  <b>   Category </b> : {{$category_id?$category_id->category_name:"" }} 
          </h5></div>
                     <div class="col-3">
                          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            
                          </div>
                      </div>
                      <div class="col-3">
                         <div class="d-grid gap-2 d-md-flex ">
                          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddModal">
                           Add
                         </button>         
                </div>
          </div> 
    </div> 

    </div>
    <div class="card-body">

<div id="success_message"></div>
 <div class="row mb-2">
    <div class="col-md-9">

    </div>
    <div class="col-md-3">
     <div class="form-group">
      <input type="text" name="search" id="search" placeholder="Enter Search " class="form-control form-control-sm"  autocomplete="off"  />
     </div>
    </div>
   </div>


   <div class="card-block table-border-style">                     
 <div class="table-responsive">
 <div class="x_content">
 <table class="table table-bordered" id="employee_data">
 <thead>
       <tr>
              <th  width="10%"> Id </th>
              <th width="15%" class="sorting" data-sorting_type="asc" data-column_name="category_name" style="cursor: pointer" > Category Name
              <span id="category_name_icon" ><i class="fas fa-sort-amount-up-alt"></i></span> </th>
              <th  width="10%"> Status </th>
		          <th  width="10%"></th>
		          <th  width="10%"></th>
      </tr>
    </thead>
    <tbody>
       
    </tbody>
  </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
 
   </div>
  </div>
</div>


</div>
</div>


   <!-- Modal Add -->
   <div class="modal fade" id="AddModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="staticBackdropLabel"> Add</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

   <form method="post" id="add_form" enctype="multipart/form-data" >
         <div class="modal-body">
            <ul class="alert alert-warning d-none"  id="add_form_errlist"></ul>

         <div class="form-group  my-2">     
	          	<label> <b> Sub Category Name </b> </label>
	           <input name="sub_category_name" id="sub_category_name" type="text"   class="form-control"  required/>
             <p class="text-danger err_sub_category_name"></p>
        </div>


          <div class="form-group  my-2">
              <label for="lname"> <b>Sub category Status </b> </label>
                   <select class="form-select" name="sub_category_status" id="sub_category_status" aria-label="Default select example">
                         <option value="1"> Active</option>
                         <option value="0">Inactive  </option>
                  </select>
          </div>     
     

          <input type="hidden" name="course_id" id="course_id" value="{{$course_id->id}}" >
          <input type="hidden" name="category_id" id="category_id" value="{{$category_id->id}}" >
    
    
      <div class="loader">
                  <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
			 </div><br>
	 
    
     <button type="submit"  id="add_btn"   class=" btn btn-success">Submit</button>

   </div>
   </form> 


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>   

 <!-- Modal Add  End-->



  <!-- Modal Edit -->
  <div class="modal fade" id="EditModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

<form method="post" id="edit_form" enctype="multipart/form-data" >
   <div class="modal-body">
 

      <input type="hidden" name="edit_id"  id="edit_id" >

                                
      <div class="form-group  my-2">
	      	<label><b> Sub Category  Name</b></label>
	        <input name="sub_category_name" id="edit_sub_category_name" type="text"   class="form-control"  required/>
          <p class="text-danger err_sub_category_name"></p>
     </div>


       <div class="form-group  my-2">
         <label for="lname">Sub  Category Status </label>
                <select class="form-select" name="sub_category_status" id="edit_sub_category_status" aria-label="Default select example"  >
                      <option value="1"> Active</option>
                      <option value="0"> Inactive </option>
                </select>
       </div>     
     
   
	  


    <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
        </div><br>
 
<input type="submit" id="edit_btn"  value="Update" class="btn btn-success" />


   </div>
   </form> 


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>   

<!-- Modal Edit End-->


<script>
  
    var course_id = @json($course_id->id);
    var category_id = @json($category_id->id);
   

</script>

<script src="{{ asset('js/subcategory.js') }}"></script>



@endif


      
<script type="text/javascript">


$(document).ready(function (){
        $('#course_id').on('change', function () {
           var nameId = this.value;
             $('#category_id').html('');
           $.ajax({
               url:'/category-fetch?course_id='+nameId,
               type:'get',
               success: function (res) {
                  console.log(res);
                   $('#category_id').html('<option value="" selected disabled>Select Category</option>');
                    $.each(res, function (key, value) {
                        $('#category_id').append('<option data-custom_category_name="1" value="' + value
                           .id + '">' + value.category_name + '</option>');
                  });
              }
          });
      });
    });




      
        $('.js-example-basic-multiple').select2();
        $(".js-example-disabled-results").select2();
</script>


   


@endsection