@foreach($data as $row)
           <tr>
                  <td> {{ $row->id }} </td>
                  <td> {{ $row->title }} </td>               
                  <td> @foreach($row->options as $item)
                      <li class="list-group-item list-group-item-action list-group-item-light">{{ $item->option }}-{{ $item->is_correct }}</li>
                      
                        @endforeach
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