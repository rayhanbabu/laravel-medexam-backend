@foreach($data as $row)
           <tr>
                  <td>{{ $row->id}}</td>
                  <td>{{ $row->subscription_name}}</td>
                  <td>{{ $row->subscription_month}}</td>
                  <td>{{ $row->amount}}</td>
                  <td>
             @if($row->subscription_status == 1)
                 <a href="#"  class="btn btn-success btn-sm">Active<a>
             @else
                 <a href="#"  class="btn btn-danger btn-sm"> Inactive <a>
              @endif
         </td>

                  <td> <button type="button" value="{{ $row->id}}" class="edit_id btn btn-primary btn-sm">Edit</button> </td>
                  <td> <button type="button" value="{{ $row->id}}" class="delete_id btn btn-danger btn-sm">Delete</button> </td>
               
      </tr>
 @endforeach

      <tr class="pagin_link">
       <td colspan="9" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  