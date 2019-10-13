@include('header')
@include('sidebar')
            <div class="content-wrapper myprofile">
                <div class="container-fluid">

                    <div class="row">
                        <div class="content-header col-xs-12">
                            
                            <ol class="breadcrumb">
                                <li><a href="myprofile.html"><i class="fa fa-dashboard"></i> Communication</a></li>
                                <li class="active">Email Template</li>
                            </ol>
                        </div>
                        <div class="col-xs-12">

                            <h2 class="page-title">Edit Email Template</h2>
                            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">Email Template</h4>
                                                    </div>

                                                    <div class="panel-body" id="contactAddress1">

                                                                <div class="col-xs-12 col-sm-12">	
                                                                    <div class="form-group field-wrapper1">
                                                                        <label>Template Name</label>
                                                                        <input type="text" class="form-control" placeholder="Template Name">
                                                                    </div>     
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12">	
                                                                    <div class="form-group field-wrapper1">
                                                                        <label>Description</label>
                                                                        <input type="text" class="form-control" placeholder="Description">
                                                                    </div>     
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12">	
                                                                    <div class="form-group field-wrapper1">
                                                                        <label>Subject</label>
                                                                        <input type="text" class="form-control" placeholder="Subject">
                                                                    </div>     
                                                                </div>
                                                                <div class="col-sm-12 col-xs-12">	
                                                                    <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
                                                                        <div class="btn-group">
                                                                            <a class="btn btn-dark dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                                                            <ul class="dropdown-menu">
                                                                            </ul>
                                                                        </div>
                                                                        <div class="btn-group">
                                                                            <a class="btn-dark btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                                                                            <ul class="dropdown-menu">
                                                                                <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
                                                                                <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                                                                                <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="btn-group">
                                                                            <a class="btn btn-dark" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                                                            <a class="btn btn-dark" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                                                            <a class="btn btn-dark" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                                                            <a class="btn btn-dark" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                                                                        </div>
                                                                        <div class="btn-group">
                                                                            <a class="btn btn-dark" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                                                            <a class="btn btn-dark" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                                                                            <a class="btn btn-dark" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-indent"></i></a>
                                                                        </div>
                                                                        <div class="btn-group">
                                                                            <a class="btn btn-dark" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                                                            <a class="btn btn-dark" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                                                            <a class="btn btn-dark" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                                                                            <a class="btn btn-dark" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                                                                        </div>
                                                                        <div class="btn-group">
                                                                            <a class="btn btn-dark dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                                                                            <div class="dropdown-menu input-append">
                                                                                <input class="col-xs-8" placeholder="URL" type="text" data-edit="createLink"/>
                                                                                <button class="btn" type="button">Add</button>
                                                                            </div>
                                                                            <a class="btn btn-dark" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>

                                                                        </div>

                                                                        <div class="btn-group">
                                                                            <a class="btn btn-dark" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
                                                                            <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                                                                        </div>
                                                                        <div class="btn-group">
                                                                            <a class="btn btn-dark" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                                                                            <a class="btn btn-dark" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                                                                        </div>
                                                                        <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
                                                                    </div>

                                                                    <div id="editor"></div>

                                                                    <textarea rows="2" name="desc" cols="20" style="display:none; " > Enter your text here.. </textarea>

                                                                </div>
                                                                <div class="hr-dashed"></div>
                                                                <div class="col-sm-6 col-xs-12">
                                                                    <button type="submit" class="btn btn-primary col-sm-3 col-lg-12 pull-right">Preview</button>
                                                                </div>
                                                                <div class="col-sm-3 col-xs-12">
                                                                    <button type="submit" class="btn btn-primary col-sm-3 col-lg-12 pull-right">Save</button>
                                                                </div>											
                                                                <div class="col-sm-3 col-xs-12">
                                                                    <button type="submit" class="btn btn-primary col-sm-3 col-lg-12 pull-right">Cancel</button>
                                                                </div>
                                                            
                                                        
                                                    </div>

                                                </div>

                                            </div>

                                       


                                    

                                
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
         @include('footer')
        <!-- Loading Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
       <script src="js/label-slide.js" type="text/javascript"></script>
        <script src="js/fileinput.js"></script>
        <script src="js/jquery.hotkeys.js"></script>
        <script src="js/rte.js"></script>
        <script src="js/bootstrap-wysiwyg.js"></script>
        <script src="js/dealerplus.js" type="text/javascript"></script>


        <script language="javascript">
            function loadVal() {
                desc = $("#editor").html();
                document.form1.desc.value = desc;
            }
        </script>
    </body>

</html>