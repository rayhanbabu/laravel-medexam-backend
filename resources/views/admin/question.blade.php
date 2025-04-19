@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('sub_sub_category','active')
@section('content')

    <div class="row mt-2 mb-0 mx-1 shadow p-1">
         <div class="col-sm-3 my-2">
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


      <div class="col-sm-3 my-2">
                <select name="category_id" id="category_id" class="js-example-disabled-results" style="width:300px;" aria-label="Default select example" required>       
                </select>   
                
       </div>


       <div class="col-sm-3 my-2">
                <select name="sub_category_id" id="sub_category_id" class="js-example-disabled-results" style="width:300px;" aria-label="Default select example" required>       
                </select>     
       </div>


     <div class="col-sm-2 my-2">
                <select name="sub_sub_category_id" id="sub_sub_category_id" class="js-example-disabled-results" style="width:200px;" aria-label="Default select example" required>       
                </select>     
       </div>

        <div class="col-sm-1 mt-2">
              <button type="submit" name="search" class="btn btn-primary btn-sm">Search</button>
         </div>
      </form>
    </div>


  @if($course_id!="" && $category_id!="" && $sub_category_id!="")    
  <div class="card">
  <div class="card-header">

  <div class="row">
          <div class="col-sm-11"> <h6 class="mt-0"> <b> Course  </b> : {{$course_id?$course_id->course_name:"" }} 
                  <b>   Category </b> : {{$category_id?$category_id->category_name:"" }} 
                  <b>   Sub Category </b> : {{$sub_category_id?$sub_category_id->sub_category_name:"" }}
                  <b>   Sub Sub Category </b> : {{$sub_sub_category_id?$sub_sub_category_id->sub_sub_category_name:"" }}
          </h6></div>
                   
                  <div class="col-sm-1">
                      <div class="d-grid gap-2 d-md-flex ">
                          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddModal">
                           Add
                         </button>         
                     </div>
                  </div> 

     
       <div class="col-sm-4">
           <form method="post" action="{{url('admin/question_import')}}"  class="myform"  enctype="multipart/form-data" >
               {!! csrf_field() !!}

                        <div class="d-grid gap-2 d-md-flex"> 
                             <input type="file" name="file" class="form-control" required>
                        </div>
                  </div> 


                     <input type="hidden" name="course_id" id="course_id" value="{{$course_id->id}}" >
                     <input type="hidden" name="category_id" id="category_id" value="{{$category_id->id}}" >
                     <input type="hidden" name="sub_category_id" id="sub_category_id" value="{{$sub_category_id->id}}" >
                     <input type="hidden" name="sub_sub_category_id" id="sub_sub_category_id" value="{{$sub_sub_category_id->id}}" >

                  <div class="col-sm-1">
                        <div class="d-grid gap-2 d-md-flex">
                              <button type="submit" name="import" class="btn btn-primary btn-sm">Import</button>
                     </div>
                  </div> 

                  <div class="col-sm-7">
                        <div class="d-grid gap-2 d-md-flex">
                           Sheet=title, option1, status1, option2, status2, option3, status3, option4, status4, option5, status5
                     </div>
                  </div> 
          
            </div>

            </form>

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
              <th  width="5%"> Id </th>
              <th width="50%" class="sorting" data-sorting_type="asc" data-column_name="title" style="cursor: pointer" > Title
              <span id="title_icon" ><i class="fas fa-sort-amount-up-alt"></i></span> </th>
           
              <th  width="20%"></th>
		          <th  width="5%"></th>
		          <th  width="5%"></th>
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
	          	<label> <b> Question Title </b> </label>
	           <input name="title" id="title" type="text"   class="form-control"  required/>
             <p class="text-danger err_question"></p>
        </div>

        <div class="row mb-2">


              <div class="col-sm-8 my-2">
                 <label for=""> <b> Option 1 </b> </label>
                  <input type="text" name="option[]"  value="" class="form-control form-control-sm" required/>
              </div>

              <div class="col-sm-4 my-2">
                  <label for=""> <b> Status </b> </label>
                   <select class="form-select form-select-sm" name="is_correct[]"  aria-label="Default select example">
                         <option value="0"> Incorrect  </option>
                         <option value="1"> Correct</option>
                   </select>
               </div>


               <div class="col-sm-8 my-2">
                 <label for=""> <b> Option 2 </b> </label>
                  <input type="text" name="option[]"  value="" class="form-control form-control-sm" required/>
              </div>

              <div class="col-sm-4 my-2">
                  <label for=""> <b> Status </b> </label>
                   <select class="form-select form-select-sm" name="is_correct[]"  aria-label="Default select example">
                        <option value="0"> Incorrect  </option>
                        <option value="1"> Correct</option>
                   </select>
               </div>


               <div class="col-sm-8 my-2">
                 <label for=""> <b> Option 3 </b> </label>
                  <input type="text" name="option[]"  value="" class="form-control form-control-sm" required/>
              </div>

              <div class="col-sm-4 my-2">
                  <label for=""> <b> Status </b> </label>
                   <select class="form-select form-select-sm" name="is_correct[]"  aria-label="Default select example">
                         <option value="0"> Incorrect  </option>
                         <option value="1"> Correct</option>
                     
                   </select>
               </div>


               <div class="col-sm-8 my-2">
                 <label for=""> <b> Option 4 </b> </label>
                  <input type="text" name="option[]"  value="" class="form-control form-control-sm" required/>
              </div>

              <div class="col-sm-4 my-2">
                  <label for=""> <b> Status </b> </label>
                   <select class="form-select form-select-sm" name="is_correct[]"  aria-label="Default select example">
                         <option value="0"> Incorrect  </option>
                         <option value="1"> Correct</option>
                     
                   </select>
               </div>


               <div class="col-sm-8 my-2">
                 <label for=""> <b> Option 5 </b> </label>
                  <input type="text" name="option[]"  value="" class="form-control form-control-sm" required/>
              </div>

              <div class="col-sm-4 my-2">
                  <label for=""> <b> Status </b> </label>
                   <select class="form-select form-select-sm" name="is_correct[]"  aria-label="Default select example">
                         <option value="0"> Incorrect  </option>
                         <option value="1"> Correct</option>
                     
                   </select>
               </div>



       </div>

          
          <input type="hidden" name="course_id" id="course_id" value="{{$course_id->id}}" >
          <input type="hidden" name="category_id" id="category_id" value="{{$category_id->id}}" >
          <input type="hidden" name="sub_category_id" id="sub_category_id" value="{{$sub_category_id->id}}" >
          <input type="hidden" name="sub_sub_category_id" id="sub_sub_category_id" value="{{$sub_sub_category_id->id}}" >
    
    
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
	          	<label> <b> Question Title </b> </label>
	           <input name="title" id="edit_title" type="text"   class="form-control"  required/>
             <p class="text-danger err_question"></p>
        </div>


        <div class="form-group  my-2">     
                <label for="roll"> Image (Max:500KB)</label>
                <input type="file" name="image" id="image" class="form-control" placeholder="" >
        </div>

        <div class="row mb-2">


              <div class="col-sm-8 my-2">
                  <input type="hidden" name="option_id[]"  id="option_id1" >
                  <label for=""> <b> Option 1 </b> </label>
                  <input type="text" name="option[]" id="option1"  class="form-control form-control-sm" required/>
              </div>

              <div class="col-sm-4 my-2">
                  <label for=""> <b> Status </b> </label>
                   <select class="form-select form-select-sm" name="is_correct[]" id="is_correct1" aria-label="Default select example">
                         <option value="0"> Incorrect  </option>
                         <option value="1"> Correct</option>
                   </select>
               </div>


               <div class="col-sm-8 my-2">
                  <input type="hidden" name="option_id[]"  id="option_id2" >
                 <label for=""> <b> Option 2 </b> </label>
                  <input type="text" name="option[]" id="option2" value="" class="form-control form-control-sm" required/>
              </div>

              <div class="col-sm-4 my-2">
                  <label for=""> <b> Status </b> </label>
                   <select class="form-select form-select-sm" name="is_correct[]" id="is_correct2" aria-label="Default select example">
                        <option value="0"> Incorrect  </option>
                        <option value="1"> Correct</option>
                   </select>
               </div>


               <div class="col-sm-8 my-2">
                  <input type="hidden" name="option_id[]"  id="option_id3" >
                 <label for=""> <b> Option 3 </b> </label>
                  <input type="text" name="option[]" id="option3" value="" class="form-control form-control-sm" required/>
              </div>

              <div class="col-sm-4 my-2">
                  <label for=""> <b> Status </b> </label>
                   <select class="form-select form-select-sm" name="is_correct[]" id="is_correct3" aria-label="Default select example">
                         <option value="0"> Incorrect  </option>
                         <option value="1"> Correct</option>
                     
                   </select>
               </div>


               <div class="col-sm-8 my-2">
                  <input type="hidden" name="option_id[]"  id="option_id4" >
                 <label for=""> <b> Option 4 </b> </label>
                  <input type="text" name="option[]" id="option4" value="" class="form-control form-control-sm" required/>
              </div>

              <div class="col-sm-4 my-2">
                  <label for=""> <b> Status </b> </label>
                   <select class="form-select form-select-sm" name="is_correct[]" id="is_correct4" aria-label="Default select example">
                         <option value="0"> Incorrect  </option>
                         <option value="1"> Correct</option>
                     
                   </select>
               </div>


               <div class="col-sm-8 my-2">
                  <input type="hidden" name="option_id[]"  id="option_id5" >
                 <label for=""> <b> Option 5 </b> </label>
                  <input type="text" name="option[]" id="option5" value="" class="form-control form-control-sm" required/>
              </div>

              <div class="col-sm-4 my-2">
                  <label for=""> <b> Status </b> </label>
                   <select class="form-select form-select-sm" name="is_correct[]" id="is_correct5" aria-label="Default select example">
                         <option value="0"> Incorrect  </option>
                         <option value="1"> Correct</option>
                     
                   </select>
               </div>

       </div>
   
	  
       <div class="mt-2" id="avatar_image"> </div>

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
    var sub_category_id = @json($sub_category_id->id);
    var sub_sub_category_id = @json($sub_sub_category_id->id);
   

</script>

<script src="{{ asset('js/question.js') }}"></script>



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



    $(document).ready(function (){
        $('#category_id').on('change', function () {
           var nameId = this.value;
             $('#sub_category_id').html('');
           $.ajax({
               url:'/subcategory-fetch?category_id='+nameId,
               type:'get',
               success: function (res) {
                  console.log(res);
                   $('#sub_category_id').html('<option value="" selected disabled> Select Sub  Category</option>');
                    $.each(res, function (key, value) {
                        $('#sub_category_id').append('<option data-custom_category_name="1" value="' + value
                           .id + '">' + value.sub_category_name + '</option>');
                  });
              }
          });
      });
    });



    $(document).ready(function (){
        $('#sub_category_id').on('change', function () {
           var nameId = this.value;
             $('#sub_sub_category_id').html('');
           $.ajax({
               url:'/subsubcategory-fetch?sub_category_id='+nameId,
               type:'get',
               success: function (res) {
                  console.log(res);
                   $('#sub_sub_category_id').html('<option value="" selected disabled> Select Sub  Category</option>');
                    $.each(res, function (key, value) {
                        $('#sub_sub_category_id').append('<option data-custom_category_name="1" value="' + value
                           .id + '">' + value.sub_sub_category_name + '</option>');
                  });
              }
          });
      });
    });


      

        $('.js-example-basic-multiple').select2();
        $(".js-example-disabled-results").select2();
</script>


   


@endsection