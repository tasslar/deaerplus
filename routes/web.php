<?php

Route::get('/index', function () {

    return view('index', ['title' => 'DealerPlus-index']);
});
Route::get('/about', function () {

    return view('about', ['title' => 'About Us']);
});
Route::get('/feature', function () {

    return view('feature', ['title' => 'Features']);
});
Route::get('/pricing', 'guest@pricingView');
/* Route::get('/pricing', function () {

  return view('pricing', ['title' => 'Pricing']);
  }); */
/* Route::get('/contactus', function () {

  return view('contactus', ['title' => 'Request For Demo']);
  }); */

//Route::get('create','login@create');
/* Route::get('mailsend/{id}',array('as'=>'mailsend','uses'=>'guest@mailsend'));
  Route::get('passwordactivation/{id}',array('as'=>'passwordactivation','uses'=>'guest@passwordconfirm'));
  Route::post('guestpasswordconfirm','guest@guestpasswordconfirm'); */


Route::get('login', 'guest@login');
Route::post('loginprocess', 'guest@loginprocess');
Route::get('logindirect', 'guest@logindirect');
//DASHBOARD CONTROLLER
Route::get('dashboard', 'dashboard@doDashboard');
//Route::get('dashboard','inventory@index');
//password creation
Route::get('mailsend/{id}', array('as' => 'mailsend', 'uses' => 'guest@mailsend'));
Route::get('usermail/{id}', 'guest@usersendmail');
Route::get('passwordactivation/{id}', array('as' => 'passwordactivation', 'uses' => 'guest@passwordconfirm'));
Route::post('passwordconfirm', 'guest@passwordconfirm');

//forget password
Route::get('forgetpassword', 'guest@forgetpassword');
Route::post('forgetpasswordprocess', 'guest@forgetpasswordprocess');
Route::get('changepassword/{id}', array('as' => 'changepassword', 'uses' => 'guest@changepasswordview'));
Route::post('changepasswordprocess', 'guest@changepasswordprocess');
Route::get('cancelform', 'dealer@cancelform');

//Dash board redirecting
Route::get('show/{id}', array('as' => 'show', 'uses' => 'guest@show'));
Route::get('logout', 'guest@logoutprocess');

//Contactus
Route::get('contactus', 'site@contactus');
Route::get('supportus', 'site@contactus');
Route::any('dealercontactus', 'site@dealerContactUs');
Route::any('contactushtml', 'site@contactushtml');

Route::get('about_main', 'site@aboutus');
Route::get('privacy', 'site@privacy');
Route::get('terms', 'site@terms');
Route::get('emailtemplate', 'site@email');
Route::get('smstemplate', 'site@sms');
Route::get('addsmstemplate', 'site@addsms');
Route::get('addemailtemplate', 'site@addemail');
Route::get('/contactus', 'site@contactus');

//Route::get('getmap', 'dealer@getmap');

//Guest route listing
Route::get('/', 'guest@indexview');
Route::get('/registration', 'guest@getmastercity');
Route::get('/dealerregistration', 'guest@getmastercity');
Route::post('user_register_store', 'guest@user_register_store');

Route::any('guestlistingpage/{id}', 'guest@guest_detailpage');

//plan deatils
Route::post('frequency_get', 'guest@frequency_get');
Route::post('plan_amount', 'guest@plan_amount');

Route::any('techprocess', 'payment\techprocess@paymentrequest');
Route::any('paymentresponse', 'payment\techprocess@paymentresponse');
Route::any('subscriptionPaymentResp', 'subscription@subscriptionPaymentResp');
Route::any('subscriptionPaymentRespRenew', 'subscription@subscriptionPaymentRespRenew');
Route::any('registerPaymentResp', 'guest@registerPaymentResp');
/* API ROUTING FOR ALL API CALLS START */

// API FOR BUY ROUTING

Route::get('apibuy', 'api\buy@doSearchlisting');
Route::post('apibuyid', 'api\buy@doFetchModel');
Route::post('apisearchcarlisting', 'api\buy@doSearchCarlisting');
Route::post('apiview_savedcars', 'api\buy@doViewSavedcars');
Route::post('api_save_car', 'api\buy@doApiSaveCar');
Route::post('api_queries_car', 'api\buy@doApiQueriesCar');
Route::post('api_queries_chat', 'api\buy@doApiQueriesChat');
Route::post('api_queries_chatrefresh', 'api\buy@doApiQueriesChatrefresh');
Route::post('api_queries_chatinsert', 'api\buy@doApiQueriesChatinsert');
Route::post('api_bidding_list', 'api\buy@doApiBiddingList');
Route::post('api_apply_funding', 'api\buy@doApiApplyInventoryFund');
Route::post('api_add_funding', 'api\buy@doApiaddfunding');
Route::post('api_revoke_funding', 'api\buy@doApirevokefunding');
Route::post('api_bidding_viewmore', 'api\buy@doApibiddingviewmorelist');
Route::post('api_addbidding_viewmore', 'api\buy@doApiaddbiddingviewmorelist');
Route::post('api_alert_car', 'api\buy@doApialertcar');
Route::post('api_alert_car_list', 'api\buy@doApialerthistory');
Route::post('api_buy_filter', 'api\buy@doApibuyfilter');
Route::post('api_search_filter', 'api\buy@doApisearchfilter');
Route::post('api_buy_compare', 'api\buy@doApiComparecar');
Route::post('api_addfresh_service', 'api\buy@doApiaddfreshservice');
Route::post('api_updatefresh_service', 'api\buy@doApiupdatefreshservice');
Route::post('api_view_cardetails', 'api\buy@doApiviewcardetails');
Route::post('api_freshticket_create', 'api\buy@doApiFreshticketcreate');
Route::post('api_domessage_send', 'api\buy@doApiajaxcontactdealermessage');
Route::post('api_dotestdrive_send', 'api\buy@doApitestdriveupdate');
Route::post('api_dosearch_tagfilter', 'api\buy@doSearchCarlistingTagfilter');
Route::post('api_listunselected_filter', 'api\buy@doApilistunselectedfilter');
Route::post('api_searchcar_filter', 'api\buy@doSearchCarlistingFilter');
Route::post('api_alert_history', 'api\buy@doApiAlertShowHistory');
Route::post('api_alert_revoke', 'api\buy@doApiAlertRevoke');
Route::post('api_alert_statusrevoke', 'api\buy@doApiAlertStatusRevoke');
Route::post('api_alert_doshow', 'api\buy@doApiAlertShowTopPage');
Route::post('api_alert_notification_show', 'api\buy@doApiNotificationShowTopPage');
Route::post('doApiCardetailshare', 'api\buy@doApisharelisting');
Route::post('doApibuyfundingregister', 'api\buy@doApiregisterApplyfundingBuy');
Route::post('doApireportlisting', 'api\buy@doApireportlisting');


//API FOR REGISTER ROUTING
Route::post('registration_store', 'api\guest@doRegistrationStore');
Route::post('user_login', 'api\guest@doUserLogin');
Route::get('user_login_cometchat', 'api\guest@doUserLoginCometchat');
Route::post('forgot_password', 'api\guest@doForgotPassword');
Route::post('edit_account', 'api\guest@doEditAccount');
Route::post('change_password', 'api\guest@doChangePassword');
Route::post('doapiemailidexist', 'api\guest@doApiemailidexist');
Route::post('doapicontactexist', 'api\guest@doApicontactexist');
Route::post('doapicoupanexist', 'api\guest@doApicoupanexist');


//API FOR SELL ROUTING

Route::post('add_inventoryloan', 'api\sell@doApiapplyloan');
Route::post('viewapplyloan_list', 'api\sell@doApiviewapplyloanlist');
Route::post('view_inventory_list', 'api\sell@doApiviewinventorylist');
Route::post('view_mypost_list', 'api\sell@doApimypostlist');
Route::post('view_mypost_details', 'api\sell@doApimypostdetails');
Route::post('api_queries_received', 'api\sell@doApiQueriesReceived');
Route::post('api_revoke_loan', 'api\sell@doApiLoanrevoke');
Route::post('view_inventory_dashboard', 'api\sell@doApiviewinventorydashboard');
Route::post('api_inventory_delete', 'api\sell@doApiinventorydelete');
Route::post('api_postingtype_status', 'api\sell@doApipostingstatus');
Route::post('api_customername', 'api\sell@doApicustomername');
Route::post('api_doadd_inventory', 'api\sell@doApiAddInventory');
Route::post('api_doview_basicinfo', 'api\sell@doApiViewBasicinfodetails');
Route::post('api_doimage_upload', 'api\sell@doApiImageupload');
Route::post('api_doviewdocument', 'api\sell@doApiViewDocumentdetails');
Route::post('api_dodocument_upload', 'api\sell@doApiDocumentupload');
Route::post('api_doview_hypothacation', 'api\sell@doApiViewHypothacation');
Route::post('api_doadd_hypothacation', 'api\sell@doApiAddHypothacation');
Route::post('api_doview_certiwarranty', 'api\sell@doApiViewcertificatewarranty');
Route::post('api_doAdd_certiwarranty', 'api\sell@doApiAddcertificatewarranty');
Route::post('api_doview_enginefeatures', 'api\sell@doApiViewenginefeatures');
Route::post('api_doAdd_enginefeatures', 'api\sell@doApiAddenginefeatures');
Route::post('api_dolisting_submit', 'api\sell@doApilistingsubmit');
Route::post('api_dolisting_submit_checkprice', 'api\sell@doApilistingsubmitcheckprice');
Route::post('api_dolisting_mongopush', 'api\sell@doAPimongopush');
Route::post('api_doview_inventory', 'api\sell@doApiViewInventoryDetails');
Route::post('api_doupdate_inventory', 'api\sell@doApiUpdateInventory');
Route::post('api_doApiibbPrice', 'api\sell@doApiIbbprice');
Route::post('api_doApifastlanevininfo', 'api\sell@doApiViewvinInfo');
Route::post('apidoviewmarket', 'api\sell@doviewmarket');
Route::post('apidoviewsold', 'api\sell@doViewSold');
Route::post('apidoapplysold', 'api\sell@doApiApplySold');
Route::post('api_Marketingsmsandmail', 'api\sell@doApiMarketingsmsandmail');


//API FOR MANAGE ROUTING

Route::post('api_branch_list', 'api\manage@doApibranchlist');
Route::post('api_add_branch', 'api\manage@doApiaddbranch');
Route::post('api_edit_branch', 'api\manage@doApieditbranch');
Route::post('api_delete_branch', 'api\manage@doApideletebranch');
Route::post('api_business_profile', 'api\manage@doApiviewbusinessprofile');
Route::post('api_view_profile', 'api\manage@doApiviewprofile');
Route::post('api_update_business_profile', 'api\manage@doApiupdatebusinessprofile');
Route::post('api_view_employee', 'api\manage@doApiviewemployee');
Route::post('api_delete_employee', 'api\manage@doApideleteemployee');
Route::post('api_add_employee', 'api\manage@doApiaddemployee');
Route::post('api_edit_employee', 'api\manage@doApiupdateEmployee');
Route::post('api_doview_transaction', 'api\manage@doApiViewTransaction');
Route::post('api_dosearchemployee', 'api\manage@doApisearchemployee');


//API FOR USER ROUTING
Route::post('api_add_user', 'api\manage@doApiaddnewuser');
Route::post('api_view_user', 'api\manage@doApiviewuserdetails');
Route::post('api_add_user', 'api\manage@doApiaddnewuser');
Route::post('api_update_user', 'api\manage@doApiupdateuser');
Route::post('api_detele_user', 'api\manage@doApideleteuser');
Route::post('api_invokestatus_user', 'api\manage@doApiInvokestatususer');
Route::post('api_search_user', 'api\manage@doApisearchuserdetails');

//API FOR CONTACT ROUTING
Route::post('api_add_contact', 'api\manage@doApiaddcontact');
Route::post('api_document_contact', 'api\manage@doApicontactDocument');
Route::post('api_leadsdetails_contact', 'api\manage@doApiLeaddetails');
Route::post('api_view_allcontact', 'api\manage@doApiviewcontact');
Route::post('api_delete_contact', 'api\manage@doApideletecontact');
Route::post('api_update_contact', 'api\manage@doApiupdatecontact');
Route::post('api_search_contact', 'api\manage@doApisearchviewcontact');
Route::post('viewleadbasicinfo', 'api\manage@viewleadbasicinfo');

Route::any('doApitestDocument', 'api\manage@doApitestDocument');
Route::any('dotestemail', 'api\manage@dotestemail');
//API FOR DASHBOARD ROUTING
Route::post('api_user_dashboard', 'api\dashboard@doApidashboard');
Route::post('api_dealer_search', 'api\dashboard@doApidealerserach');
//API FOR FUNDING ROUTING
Route::post('api_get_dealerbranch', 'api\funding@doApigetbranch');
Route::post('api_view_fundingcar', 'api\funding@doApiViewfundingCarCetails');
Route::post('api_apply_fundingcar', 'api\funding@doregisterApplyfunding');
Route::post('doApi_viewfundingpage', 'api\funding@doApiViewfundingPage');
Route::post('doApi_revokefunding', 'api\funding@doApifundingrevoke');

//API FOR FUNDING ROUTING
Route::post('api_view_loancar', 'api\loan@doApiViewloanCarCetails');
Route::post('api_revoke_loanlist', 'api\loan@doApiloanrevoke');
Route::post('doApi_viewloanpage', 'api\loan@doApiViewloanPage');
Route::post('api_apply_loancar', 'api\loan@doApiregisterApplyloan');


//API FOR MASTER CONTROLLER ROUTING
Route::post('master_city', 'api\master@doMasterCity');
Route::get('master_city_get', 'api\master@dogetMasterCity');
Route::get('master_make', 'api\master@doMasterMake');
Route::get('master_model', 'api\master@doMasterModel');
Route::post('doApi_master_model', 'api\master@doMasterModelApi');
Route::post('doApi_master_variant', 'api\master@doMasterVariantsApi');
Route::get('master_variants', 'api\master@doMasterVariants');
Route::get('master_category', 'api\master@doMasterCategory');
Route::get('master_car_features', 'api\master@doMasterCarFeatures');
Route::get('master_colors', 'api\master@doMasterColors');
Route::get('master_country', 'api\master@doMasterCountry');
Route::get('master_email_templates', 'api\master@doMasterEmailTemplates');
Route::get('master_email_types', 'api\master@doMasterEmailTypes');
Route::get('master_plans', 'api\master@doMasterPlans');
Route::get('master_plan_frequency', 'api\master@doMasterPlanFrequency');
Route::get('master_schema_users', 'api\master@doMasterSchemaUsers');
Route::get('master_state', 'api\master@doMasterState');
Route::get('master_subscription_plans', 'api\master@doMasterSubscriptionPlans');
Route::post('master_plans_details', 'api\master@doMasterPlandatails');
Route::get('api_master_plandetails', 'api\master@doApimasterplandetails');
//Route::get('api_master_year', 'api\master@doRegisterYear');
Route::post('apidoaddinventory', 'api\master@doRegisterYear');
Route::get('api_master_ownertype', 'api\master@doMasterOwnerType');
Route::get('api_master_cartype', 'api\master@doMasterCarType');
Route::get('api_master_customertype', 'api\master@doMasterCustomerType');
Route::post('api_master_transmissiontype', 'api\master@doMasterCarTransmission');
Route::post('api_master_branchtype', 'api\master@doMasterBranch');
/* API ROUTING FOR ALL API CALLS END */

//state and city ajax call
Route::post('fetch_city', 'branch@fetch_city');
Route::any('changecity', 'contact@dofetch_city');

// Manage Subscription
Route::get('managesubscription', 'subscription@managesubscription');
Route::post('subscriptiondetail', 'subscription@subscriptiondetail_show');
Route::post('subscription_data', 'subscription@subscription_data');
Route::post('change_subscription', 'subscription@change_subscription');
Route::post('renewplan', 'subscription@renewplan');
Route::get('test', 'subscription@testTime');
// Manage Transaction
Route::get('managetransaction', 'transaction@managetransaction');
Route::get('pdf/{id}', 'pdfcontroller@pdfContent');
Route::get('invoicePdfDownload/{id}', 'pdfcontroller@invoicePdfDownload');

//Subscription coupon
Route::post('coupon_data', 'coupon@couponMatch');

//Routing Begins
Route::group(['middleware' => ['isValid']], function() {
    //my_account and edit_account
    Route::get('myeditaccount', 'dealer@myeditaccount');
    Route::post('editaccount_state', 'dealer@editaccount_state');
    Route::post('accounteditprocess', 'dealer@accounteditprocess');
    //Dealer change password link from dashboard
    Route::get('dealerchangepassword', 'dealer@dealer_change_password');
    Route::post('dealer_change_password_process', 'dealer@dealer_change_password_process');
    //FUNDING WEB ROUTING START
    $status = "NO";
    if($status == "Yes")
    {
        Route::group(['middleware' => ['isFunding']], function() 
        {
        });
    }
    else
    {
        Route::get('addfund', 'funding@addfunding');
        Route::post('dofetch_citybranch', 'funding@dofetchcitybranch');
        Route::post('dofetch_cardetails', 'funding@dofetchcarmodeldetails');
        Route::post('doAddfundingcar', 'funding@doAddfundingCarCetails');
        Route::match(['get', 'post'], 'viewfunding', 'funding@doViewfundingPage');
        Route::post('doSearchfundingcar', 'funding@dosearchcarmodeldetails');
        Route::match(['get', 'post'], 'applyfundingregister', 'funding@doregisterApplyfunding');
        Route::match(['get', 'post'], 'dofundingrevoke', 'funding@dofundingrevoke');
        Route::any('/funding_excel', 'funding@dofunding_excel');
    }
//FUNDING WEB ROUTING END
    Route::get('doApplyLoan', 'loan@doapplyloan');
    Route::get('loanforcustomer', 'loan@doloanforcustomer');
    Route::get('loanforcustomername', 'loan@doloanforcustomername');
    Route::match(['get', 'post'], 'viewloan', 'loan@doViewloanPage');
    Route::match(['get', 'post'], 'applyloanregister', 'loan@doregisterApplyloan');
    Route::post('doSearchloancar', 'loan@dosearchcarmodeldetails');
    Route::post('doloanrevoke', 'loan@doloanrevokepage');
    Route::any('/export_excel_loan', 'loan@doexport_excel_loan');

//Manage Alert in Buy 
    Route::get('alert', 'alert@alertshow');
    Route::post('manage_alertstatus', 'alert@changeAlertStatus');
    Route::post('manage_alertdelete', 'alert@deleteAlert');

//Export to excel for alert
    Route::any('/exportalert', 'exportcontroller@exportalert');

//Header notifications
    Route::get('system_notification', 'notifications@sysNotificationshow');
//Route::get('show_systemplate/{id}','notifications@showSysTemplate');

    Route::get('listingschema', 'inventory@schemacheck');
    Route::get('managelisting', 'inventory@managelisting');

    Route::get('myposting', 'inventory@myposting');

    Route::get('doQueriesReceived', 'inventory@doQueriesReceived');
    Route::any('ReceiveQueries', 'inventory@doReceiveQueries');
    Route::post('myposting_delete', 'inventory@myposting_delete');
    Route::post('myposting_repost', 'inventory@myposting_repost');

    Route::get('get_mongopush_record', 'inventory@get_mongopush_record');

    Route::post('fetch_citybranch', 'inventory@fetch_citybranch');

    Route::post('inventoryexit', 'inventory@inventoryexit');

    Route::post('fetch_make', 'inventory@fetch_make');
    Route::post('fetch_model', 'inventory@fetch_model');
    Route::post('fetch_model_car', 'inventory@fetch_model_car');
    Route::post('fetch_variant', 'inventory@fetch_variant');
    Route::post('fetch_category', 'inventory@fetch_category');
    Route::post('add_car_listing_store', 'inventory@add_car_listing_store');
    Route::post('delete', 'inventory@delete_car_listing');
    Route::post('view', 'inventory@view_car_listing');
    Route::post('mypostingdetails', 'inventory@mypostingdetails');
    Route::post('my_inventory_mongo', 'inventory@my_inventory_mongo');
    Route::post('update', 'inventory@update_car_listing');
    Route::post('edit_car_listing', 'inventory@edit_car_listing');
    Route::post('basic_info', 'inventory@basic_info');
    Route::post('purchase_info', 'inventory@purchase_info');
    Route::post('dealer_car_expenses', 'inventory@dealer_car_expenses');
    Route::post('remove_all_details', 'inventory@remove_all_details');

    /* inventory sticker */
    Route::get('inventorylist_sticker/{id}', 'inventory@listStickerShow');
    Route::post('inventorylist_stickerpdf', 'inventory@listStickerShowPdf');
    /* inventory_image */

    //Route::group(['middleware' => ['iswaterMarkImages']], function() {
        Route::post('inventory_image', 'inventory@inventory_image');
    //});

    Route::post('update_car_list', 'inventory@update_car_list');
    Route::post('purchase_info_own', 'inventory@purchase_info_own');
    Route::post('image_upload', 'inventory@image_upload');
    Route::post('video_upload', 'inventory@video_upload');
    Route::post('dealer_docs', 'inventory@dealer_documents');
    Route::post('online_portal', 'inventory@online_portal');
    Route::post('auction_portal', 'inventory@auction_portal');
    Route::post('image_insert', 'inventory@image_insert');
    Route::post('certificationwarrantysave', 'inventory@certificationwarrantysave');

    Route::get('add_listing_tab/{dplid}', 'inventory@add_inventory');
    Route::get('add_listing_tab', 'inventory@add_inventory');
    Route::post('add_inventory_save', 'inventory@add_inventory_save');

    Route::get('add_inventory_tabs/{inventoryid}', 'inventory@add_inventory_tabs');

    Route::post('variant_selection', 'inventory@variant_selection');
    Route::post('fastlaneapicall', 'inventory@fastlaneapicall');
    Route::post('apply_loan', 'inventory@apply_loan');
    Route::post('dosoldview', 'inventory@dosoldview');
    Route::post('dosaleinventory', 'inventory@dosaleinventory');

    if($status == "Yes")
    {
        Route::group(['middleware' => 'isMarketingCommun'], function() {
        
        });
    }
    else
    {
        Route::post('marketing', 'inventory@domarketing');
        Route::post('marketingsmsandmail', 'inventory@marketingsmsandmail');
    }

    /* Ajax Inventory */
    Route::post('managelistingtab', 'ajaxinventory@managelistingtab');
    Route::post('managelisting_status', 'ajaxinventory@managelisting_status');
    Route::post('ajaxcontactdealermessage', 'ajaxinventory@ajaxcontactdealermessage');

    Route::get('view_savedcars', 'buy@view_savedcars');
    Route::post('save_car', 'buy@save_car');
    Route::get('queries_car', 'buy@queries_car');
    Route::post('apply_fund', 'buy@apply_fund');
    Route::post('popup_msg', 'buy@popup_msg');
    Route::get('apply_inventory_fund', 'buy@apply_inventory_fund');
    Route::post('bidding_car', 'buy@bidding_car');
    Route::get('bidding_list', 'buy@bidding_list');
    Route::post('biddingGridView', 'buy@biddingGridView');

    Route::any('sentQueries', 'buy@message_grid_view');
    Route::post('test_drive_update', 'buy@test_drive_update');
    Route::post('compare', 'buy@docompare');
    Route::post('alertsearch', 'buy@doalertlisting');
    Route::post('comparelisting', 'buy@docomparelisting');
    Route::get('recentviewed', 'buy@doview_recentcars');
    Route::post('narrowsearchcount', 'buy@narrowsearchcount');
    Route::post('reporting_listing', 'buy@report_listing');
    Route::match(['get', 'post'], 'dobuyfundingregister', 'buy@doregisterApplyfundingBuy');
    /* Ajax Buy Controller */
    Route::post('view_searchcarlisting', 'ajaxbuy@view_searchcarlisting');
    Route::post('popup_msg', 'ajaxbuy@sentQueries');
    /* SMS Gate Way */
    Route::get('sms_gateway', 'sms_gateway\smsgateway_integrate@smsgatewayintegrate');

//Cron Jobs
    Route::get('spcron_job', 'Cron_jobs\register_sp@register_schema');
    Route::get('s3cron_job', 'cronjob@s3cron_job');
    /* Mongo Bulk Data */
    Route::get('mongochangedata', 'inventory@mongochangedata');
//Cron Routing
    Route::get('s3cronjobs', 'cronjob@s3cron_job');
//car_listing direct mongo push
    Route::post('mongo_push', 'inventory@mongo_push');
    Route::get('mongo_push', 'inventory@mongo_push');
//manage controller

    Route::post('add_manage', 'manage_controller\manage_controller@add_manage');
    Route::post('edit_manage', 'manage_controller\manage_controller@edit_manage');
    Route::post('delete_manage_user', 'manage_controller\manage_controller@delete_manage_user');

//manage user 
    Route::get('adduser', 'user@adduser');
    Route::post('insertuser', 'user@insertuser');
    Route::post('edituser', 'user@edituser');
    Route::post('updateuser', 'user@updateuser');
    Route::post('deleteuser', 'user@deleteuser');
    Route::any('userresetpassword', 'user@douserresetpassword');
    Route::post('user_type', 'ajaxbuy@user_type');
//dynamic
    Route::get('manageuser', 'user@manage_list');
    Route::any('/export-users/{userid?}', 'exportcontroller@export_users');
//user curl
    Route::post('user_curl', 'user@user_curl');
//manage branch

    Route::get('managebranches', 'branch@manageBranches');
    Route::get('addbranches', 'branch@addBranches');
    Route::post('storebranches', 'branch@storeBranches');
    Route::any('editbranches/{branchid?}', 'branch@editBranches');
    Route::any('updatebranches', 'branch@updateBranches');
    Route::post('delete_branch', 'branch@delete_branch');

//Export to Excel branches
    Route::any('/export-branch', 'exportcontroller@export_branch');

//Manage employee
    Route::get('myemployee', 'employee@domyemployee');
    Route::get('manageEmployee', 'employee@domanageEmployee');
    Route::post('insertemployee', 'employee@doinsertEmployee');
    Route::post('deleteEmployee', 'employee@dodeleteEmployee');
    Route::post('editEmployee', 'employee@doeditEmployee');
    Route::post('updateEmployee', 'employee@doupdateEmployee');
    Route::post('viewEmployee', 'employee@doviewEmployee');
    Route::post('employee_type', 'ajaxbuy@employee_type');
    Route::post('insert_document', 'employee@doinsert_document');
    Route::any('update_document', 'employee@documentupdate');
//Export to Excel employee
    Route::any('/export-employee/{emptypeid?}', 'exportcontroller@export_employee');

//manage contact
    Route::get('managecontact', 'contact@managecontact');
    Route::any('addcontact/{id}', 'contact@addcontact');
    Route::get('imagess', 'contact@imagess');
    Route::post('image_resize', 'contact@image_resize');
    Route::post('deletecontact', 'contact@deletecontact');
    Route::post('insertcontact', 'contact@insertcontact');
    Route::post('editcontact', 'contact@editcontact');
    Route::post('updatecontact', 'contact@updatecontact');
    Route::post('updatecontact_doc', 'contact@updatecontact_doc');
    Route::post('view_contact', 'contact@view_contact');
    Route::post('contact_type', 'ajaxbuy@contact_type');
    Route::post('document_save', 'contact@document_save');
    Route::get('imagess', 'contact@imagess');
    Route::post('image_resize', 'contact@image_resize');
    Route::post('leadstatus', 'contact@leadstatus');
    Route::post('sharelisting', 'buy@sharelisting');
//contact export to excel
    Route::any('/contact-export/{contacttypeid?}', 'exportcontroller@contact_export');

//Networks Module
    Route::get('group', 'network@cometchat_group');
    Route::post('deletegroup_chat', 'network@deletegroup_chat');
    Route::post('addgroupform', 'network@add_cometchatgroup');
    /* Route::get('mycontact','manage_controller@mycontact'); */

    Route::get("autocompletecity", array('as' => 'autocompletecity', 'uses' => 'buy@autocompletecity'));
    Route::get("autocompletecity", array('as' => 'autocompletecity', 'uses' => 'funding@autocompletecity'));

    //BusinessProfile
    Route::get('business_profile', 'BusinessProfile@doBusinessProfile');
    if($status == "Yes")
    {
        Route::group(['middleware' => ['isBusinessProfile']], function() {
        
        });
    }
    else
    {
        Route::post('business_insert', 'BusinessProfile@doinsertBusinessProfile');
        Route::post('check_name', 'BusinessProfile@check_name');
        Route::post('company_logo', 'BusinessProfile@company_logo');
        Route::post('cover_image', 'BusinessProfile@cover_image');
        Route::post('business_document', 'BusinessProfile@business_document');
        Route::any('dealer_profile', 'BusinessProfile@dodealer_Profile');
        Route::get('remove_logo', 'BusinessProfile@remove_logo');
        Route::get('remove_cover', 'BusinessProfile@remove_cover');
        Route::get('autocomplete', 'BusinessProfile@autocomplete');
    }

    /* Buy and Search Car Listing */
    Route::get('buy', 'buy@searchlisting');
    if($status == "Yes")
    {
        Route::group(['middleware' => ['isSearch']], function() {
        
        });
    }
    else
    {
        Route::post('searchcarlisting', 'buy@searchcarlisting');
        Route::post('detail_car_listing', 'buy@detail_car_listing');
        Route::get('detail_car_listing/{car_id}', 'buy@detail_car_listing');
        Route::any('dealer_search', 'BusinessProfile@dodealer_search');
        Route::any('status_search', 'BusinessProfile@dostatus_search');
        Route::any('city_search', 'BusinessProfile@city_search');
    }

//Invoice
    Route::get('invoice', 'invoice@invoice');


//Routeing  test sreenivasan
    /* Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function()
      {
      Route::get('/admin', function()
      {
      });

      }); */
//Route::get('routetest','invoice@routetest');
    //Route::get('invoice','invoice@create_ninja_table');
    //Route::group(['middleware' => 'isInventoryIBB'], function() {
        Route::post('IBBpricing', 'inventory@IBBpricing');
        Route::get('urlshorter', 'buy@shorturl');
    //});


//Reports Menu
    if($status == "Yes")
    {
        Route::group(['middleware' => ['isReport']], function() {
        });
    }
    else
    {
        Route::any('/reports', 'reportcontroller@reports');
        Route::any('/inventory-age-report', 'reportcontroller@inventory_age_report');
        Route::any('/alert-reports', 'reportcontroller@alert_reports');
        Route::any('/contact_reports', 'reportcontroller@contact_reports');
        Route::any('/sales_reports', 'reportcontroller@sales_reports');
    }

//Invoice Menu
    if($status == "Yes")
    {
        Route::group(['middleware' => ['isInvoice']], function() {
            
        });;
    }
    else
    {
        Route::any('/manage_invoice', 'invoicecontroller@doinvoice_list');
        Route::post('/getdateinvoice', 'invoicecontroller@doget_date_invoice');
        Route::post('/getInvoicePayments', 'invoicecontroller@do_getInvoicePayments');
        Route::post('/getInvoiceStatus', 'invoicecontroller@dogetInvoiceStatus');
        Route::any('/update_invoice_date', 'invoicecontroller@update_invoice_date');
        Route::any('/invoice_status_change', 'invoicecontroller@invoice_status_change');
        Route::any('/edit_invoice', 'invoicecontroller@edit_invoice');
        Route::any('/addinvoicelist', 'invoicecontroller@do_add_invoice_list');
        Route::any('/export_invoice', 'invoicecontroller@doexport_invoice');
        Route::any('/invoiceEmailSend', 'invoicecontroller@doinvoiceEmailSend');
        Route::any('/emailMsgInvoice', 'invoicecontroller@doemailMsgInvoice');
        Route::any('/export_invoice_excel', 'invoicecontroller@doexcel_export');
        Route::any('/delete_invoice_item', 'invoicecontroller@delete_invoice_item');
        Route::any('/delete_invoice', 'invoicecontroller@delete_invoice');

        //quotes
        Route::get('addquotes', 'quotes@doaddquotes');
        Route::any('insertquotes', 'quotes@doinsertquotes');
        Route::any('car_price', 'quotes@docar_price');
        Route::any('quote_price', 'quotes@doquote_price');
        Route::any('managequotes', 'quotes@domanagequotes');
        Route::any('editquotes', 'quotes@doeditquotes');
        Route::any('deletequotes', 'quotes@deletequotes');
        Route::any('exportquotes/{id}', 'quotes@doexport_quotes');
        Route::any('updatequotes', 'quotes@doupdatequotes');
        Route::any('sendquotesemail', 'quotes@doquotesemail');
        Route::any('emailmsg', 'quotes@doemailmsg');
        Route::any('/export_quotes_excel', 'quotes@export_quotes_excel');
    }

    Route::get('testqueues', function() {
        $job = new \App\Jobs\TestQueue('Fiat', 'Fiat Linea', 'Active 1.3L MULTIJET', 'dplasdsdwerwesd123', 205);
        dispatch($job);
    });
});
