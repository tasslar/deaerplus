@include('header')
@include('sidebar')
            <div class="content-wrapper myprofile">
                <div class="container-fluid footer-fixed">
                    <div class="content-header col-sm-12">
                        
                        <ol class="breadcrumb">
                            <li><a href="myprofile.html"><i class="fa fa-dashboard"></i> Communication</a></li>
                            <li class="active">SMS Template</li>
                        </ol>
                    </div>

                    <div class="col-xs-12">
                        <h2 class="page-title col-sm-8">SMS Template</h2>
                       
                            <a href="{{url('addsmstemplate')}}" class="pull-right  col-sm-3 col-xs-12 btn btn-primary add-list">New SMS Template</a>
                            <div class="hr-dashed"></div>
                       
                        <div class="row">
                            <div class="col-xs-12" id="no-more-tables">
                                <table id="zctb" class="display table table-striped table-bordered table-hover postingdetailtabel" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Create Date</th>
                                            <th>Template Name</th>
                                            <th>SMS Description</th>
                                            <th>SMS Content</th>
                                            <th>Edit</th>
                                            <th>Remove</th>
                                            <th>Copy</th>
                                        </tr>
                                    </thead>
                                    <tbody class="vert-align text-center">
                                        <tr>
                                            <td data-title="Create Date">20-12-16</td>
                                            <td data-title="Template Name">
                                                Xyz
                                            </td>                                             
                                            <td  data-title="Email Subject">
                                                xxxx
                                            </td>
                                            <td  data-title="Email Content">
                                                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.
                                            </td>
                                            <td data-title="Edit">
                                                <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
                                            </td>
                                            <td data-title="Remove">
                                                <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                            <td data-title="Copy">
                                                <a href="#" class="btn btn-sm btn-success">Copy</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-title="Create Date">20-12-16</td>
                                            <td data-title="Template Name">
                                                Xyz
                                            </td>                                             
                                            <td  data-title="Email Subject">
                                                xxxx
                                            </td>
                                            <td  data-title="Email Content">
                                                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.
                                            </td>
                                            <td data-title="Edit">
                                                <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
                                            </td>
                                            <td data-title="Remove">
                                                <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                            <td data-title="Copy">
                                                <a href="#" class="btn btn-sm btn-success">Copy</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-title="Create Date">20-12-16</td>
                                            <td data-title="Template Name">
                                                Xyz
                                            </td>                                             
                                            <td  data-title="Email Subject">
                                                xxxx
                                            </td>
                                            <td  data-title="Email Content">
                                                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.
                                            </td>
                                            <td data-title="Edit">
                                                <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
                                            </td>
                                            <td data-title="Remove">
                                                <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                            <td data-title="Copy">
                                                <a href="#" class="btn btn-sm btn-success">Copy</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div></div>
                </div>
                 @include('footer')
            </div>

        </div>
    </div>
    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/dealerplus.js"></script>
    

</body> 

</html>