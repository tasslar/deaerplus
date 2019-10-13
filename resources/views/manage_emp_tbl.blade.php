<div class="tab-pane fade active in" id="all">
<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
    <thead class="hidden-xs">
        <tr>
            <th>Employee Name</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Employee Type</th>
            <th>Delete</th>
            <th>Edit</th>
            <th>View</th>
        </tr>
    </thead>
    <tfoot class="hidden-xs">
        <tr>
            <th>Employee Name</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Employee Type</th>
            <th>Delete</th>
            <th>Edit</th>
            <th>View</th>
        </tr>
    </tfoot>
    <tbody> 
        @foreach($employee_list as $fetch)                                           
        <tr>
            <td data-title="Employee Name">{{$fetch->employee_first_name}}</td>
            <td data-title="Contact">{{$fetch->employee_moblie_no}}</td>
            <td data-title="Address">{{$fetch->employee_mailing_address}}</td>
            @foreach($compact_array['employee_type'] as $fetch_employee_type)
            @if($fetch->employee_type == $fetch_employee_type->employee_type_id)
            <td data-title="Employee Type">{{$fetch_employee_type->employee_type}}</td>
            @endif
            @endforeach
            <td data-title="Delete"><a href="#"> <i class="label label-danger glyphicon glyphicon-trash btn delete_employee" data-id="{{$fetch->employee_management_id}}"> </i></a></td>
            <!-- <td><a href="mycontact.html"><p class="label-danger contact_status">Deactive</p></a></td> -->
            <td data-title="Edit"><a href="#"><i class="fa fa-pencil btn btn-sm btn-success edit_employee" data-id="{{$fetch->employee_management_id}}" ></i></a></td>
            <td data-title="View"><a href="#"><i class="fa fa-eye btn btn-sm btn-primary view_employee" data-id="{{$fetch->employee_management_id}}"></i></a></td>
        </tr>                                                                                   
        @endforeach
    </tbody>
</table>    

<form method="post" id="delete" action="{{url('deleteEmployee')}}">
    <input type="hidden" name="delete_employee_id" id="remove_employee">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
</form>
<form method="post" id="edit_employe" action="{{url('editEmployee')}}">
    <input type="hidden" name="update_employee" id="update_employee">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
</form>
<form method="post" id="view_employe" action="{{url('viewEmployee')}}">
    <input type="hidden" name="view_employee" id="views_employee">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
</form>  
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script> 
