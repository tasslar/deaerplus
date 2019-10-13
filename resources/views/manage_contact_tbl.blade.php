<div class="tab-pane fade active in" id="all">
 
<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
    <thead class="hidden-xs">
        <tr>
            <th>Customer Name</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Contact Type</th>
            <th>Delete</th>
            <th>Edit</th>
            <th>View</th>
        </tr>
    </thead>
    <tfoot class="hidden-xs">
        <tr>
            <th>Customer Name</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Contact Type</th>
            <th>Delete</th>
            <th>Edit</th>
            <th>View</th>
        </tr>
    </tfoot>
    <tbody> 
        @foreach($contact_list as $fetch)                                           
        <tr>
            <td data-title="Employee Name">{{$fetch->contact_first_name}}</td>
            <td data-title="Contact">{{$fetch->contact_phone_1}}</td>
            <td data-title="Address">{{$fetch->contact_mailing_address}}</td>
            
            <td data-title="Employee Type">
            @if($fetch->contact_type_id)
            @foreach($compact_array['contact_type'] as $fetch_contact_type)
            @if($fetch->contact_type_id == $fetch_contact_type->contact_type_id)
            @if($fetch_contact_type->contact_type == "")    
            @else
            {{$fetch_contact_type->contact_type}}
            @endif
            @endif
            @endforeach
            @else
            <p><b>Null</b></p>
            @endif
            </td>

            <td data-title="Delete"><a href="#"> <i class="label label-danger glyphicon glyphicon-trash btn delete_employee" data-id="{{$fetch->contact_management_id}}"> </i></a></td>
            <!-- <td><a href="mycontact.html"><p class="label-danger contact_status">Deactive</p></a></td> -->
            <td data-title="Edit"><a href="{{url('addcontact/'.$fetch->encryptid)}}"><i class="fa fa-pencil btn btn-sm btn-success edit_employee" data-id="{{$fetch->contact_management_id}}" ></i></a></td>
            <td data-title="View"><a href="#"><i class="fa fa-eye btn btn-sm btn-primary view_employee" data-id="{{$fetch->contact_management_id}}"></i></a></td>
        </tr>                                                        
        @endforeach
    </tbody>
</table>      

</div>

<form method="post" id="delete" action="{{url('deletecontact')}}">
    <input type="hidden" name="delete_customer" id="remove_employee">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
</form>
<!-- <form method="post" id="edit_employe" action="{{url('editcontact')}}">
    <input type="hidden" name="edit_contact" id="update_employee">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
</form> -->
<form method="post" id="view_employe" action="{{url('view_contact')}}">
    <input type="hidden" name="view_customer" id="views_employee">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
</form> 
