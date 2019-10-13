<table id="zctb" class="display table inventory-table" cellspacing="0" width="100%">

    <tbody>
        @if(!empty($inventorylistingdata))
            @foreach($inventorylistingdata as $cardms)        
                <tr>
                    <!-- <td class="invent-width hidden-xs"><input type="Checkbox" class="form-control" checked></td> -->
                    <td>
                        <img src="{{$cardms['image']}}" alt="" class="img-responsive table-img"/>            
                    </td>
                    <td>
                        <h4> 
                            {{ $cardms['title']}}
                        </h4>
                        <h5><i class="fa fa-inr"></i> {{$cardms['price']}}</h5>
                        <p class="list-detail">
                            <span class="text-muted">{{$cardms['kms_done']}} km</span> | 
                            <span class="text-muted">{{$cardms['mileage']}} KMPL</span> | 
                            <span class="text-muted">{{$cardms['fuel_type']}}</span>
                        </p>
                        @if($cardms['funding_applied']==1)
                        <p class="list-detail">
                            <span class="text-muted"><b>Funding: <a href="{{url('viewfunding')}}?i={{$cardms['funding_ticket_number']}}">{{$cardms['funding_ticket_number']}}</a></b></span>
                        </p>
                        @endif
                    </td>
                    <td class="uploads">
                        <div class="row">
                            <div class="col-xs-3">
                                <p>Image</p>
                                <p>Videos</p>
                                <p>Docs</p>
                            </div>
                            <div class="col-xs-1 count">
                                <p>
                                    {{$cardms['imagecount']}}
                                </p>
                                <p>
                                    {{$cardms['videocount']}}
                                </p>
                                <p>
                                    {{$cardms['documentcount']}}
                                </p>
                            </div>
                            <div class="col-xs-3">
                                <p>Views</p>
                                <p>Queries</p>
                            </div>
                            <div class="col-xs-1 count">
                                <p>
                                {{$cardms['viewscount']}}
                                </p>
                                <p>
                                {{$cardms['queriescount']}}
                                </p>

                            </div>
                        </div>
                    </td>
                    <td>
                        <div>
                            @if($cardms['test_drive']==1)
                            <p class="test-active">Testdrive</p>
                            @else
                            <p class="test-inactive">Testdrive</p>
                            @endif
                        </div>
                    </td>

                    <td>
                        <select  class="invent-select savefloppy save_{{$cardms['duplicate_id']}}" data-duplicateid="{{$cardms['duplicate_id']}}">
                            @if($cardms['listing_status']==0)
                                <option value="drafts">Drafts</option>
                                <option value="readyforsale">Ready For Sale</option>
                                <option value="delete">Delete</option>
                            @elseif($cardms['listing_status']==1)
                                <option value="readyforsale">Ready For Sale</option>
                                <option value="sold">Sold</option>
                                <option value="delete">Delete</option>
                            @elseif($cardms['listing_status']==2)
                                <option value="live">Live</option>
                                <option value="sold">Sold</option>
                                <option value="delete">Delete</option>
                            @elseif($cardms['listing_status']==3)
                                <option value="sold">Sold</option>
                            @elseif($cardms['listing_status']==4)
                                <option value="delete">Delete</option>
                            @endif                            
                        </select>
                    </td> 
                    <td class="">
                        @if($cardms['listing_status']!=3)
                            <ul class="customize"><li><a style="display:none;" id="statuschange{{$cardms['duplicate_id']}}" class="btn btn-sm btn-success statuschange" data-id="{{$cardms['duplicate_id']}}"><i class="fa fa-floppy-o" aria-hidden="true"></i></a></li>
                        @else
                            <ul class="customize"><li class="add-list col-xs-6 btn btn-primary btn-sm soldform"  data-id="{{$cardms['duplicate_id']}}">Sold</li>
                        @endif
                        </ul>
                    </td>
                    <td class="">
                        <ul class="customize">

                            @if($cardms['listing_status']==1||$cardms['listing_status']==2)
                                <li class="viewlisting" data-id="{{$cardms['duplicate_id']}}"><a class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a></li>
                                <li><a href="add_listing_tab/{{$cardms['duplicate_id']}}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a></li>
                            @endif
                            @if($cardms['listing_status']==0)
                                <li><a href="add_listing_tab/{{$cardms['duplicate_id']}}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a></li>
                            @endif
                            <li><a href="{{url('inventorylist_sticker/'.$cardms['duplicate_id'])}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-original-title="Window Sticker" data-placement="top" target="_blank"><i class="fa fa-print"></i></a></li>
                        </ul>
                    </td>
                        @if($cardms['listing_status']==1||$cardms['listing_status']==2)
                            <td class="view showmongo_post mongo_push_data{{$cardms['duplicate_id']}}" data-duplicateid="{{$cardms['duplicate_id']}}">
                                <ul class="customize">
                                    @if($cardms['listing_status']==2)
                                        <li><a href="#" class="btn btn-sm btn-pinterest marketbutton"  data-id="{{$cardms['duplicate_id']}}">Market</a></li>
                                    @endif
                                    <li><a href="add_inventory_tabs/{{$cardms['duplicate_id']}}?portal=mongo" data-id="{{$cardms['duplicate_id']}}" class="btn btn-sm btn-primary">Post</a></li>
                                </ul>
                            
                            </td>
                        @else
                            <td class="view showmongo_post mongo_push_data{{$cardms['duplicate_id']}}" data-duplicateid="{{$cardms['duplicate_id']}}" style="display: none;">
                          <ul class="customize">  
                              <li><a href="add_inventory_tabs/{{$cardms['duplicate_id']}}?portal=mongo" data-id="{{$cardms['duplicate_id']}}" class="btn btn-sm btn-primary">Post</a></li></ul>
                            
                            </td>
                        @endif
                    <!-- sendmongo -->
                </tr>
            @endforeach
        @else
            <td colspan="7">
                No Inventory Added           
            </td>
        @endif
    </tbody>
</table>
<div>{{$paginatelink}}</div>