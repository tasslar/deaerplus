

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Invoice</title>
        <link rel='shortcut icon' href="{{URL::asset('img/dealerplus_fav.ico')}}" type='image/x-icon'/ >
       


        
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    </head>

<body>
<style type="text/css">
        
table td, table th{
            border:1px solid black;
            border-collapse: collapse;
}
@font-face {
    font-family: 'robotoregular';
    src: url('../fonts/roboto-regular-webfont.woff2') format('woff2'),
        url('../fonts/roboto-regular-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}

html, body { height: 100%;background: #f7f7f7;font-family: robotoregular;}
body{font-family: robotoregular;}
h4
{
    margin:10px 0px;
}
.container {width: 100%;padding: 0;float:left;}
.content
{
    width:90%;
    margin:0 5%;
    float:left;
        
}
.content .logo
{
    float:left;
        width: 207px;
}
.top-head .head-1{text-transform: uppercase;text-align: center; font-size: 25px;    margin: 0px;}
.table-invoice
{
    
    width:100%;
    border-collapse: collapse;
}
.table-invoice tr{
    border-bottom: none;
    
}
.table-invoice td, .table-invoice th{
   padding: 5px 10px;
    vertical-align: baseline;
        border: none;
    text-align: left;
    font-size: 14px;
}
thead tr{
        background-color: #183055;
        padding:10px;
        color:#fff;
        text-align: center;
}
.span-data
{
    float: right;
}
.td-data
{
    text-align: left;
}
p
{
    font-size: 13px;
    margin:0px;
    line-height: 20px;
}
.table-invoice
{
    margin-top: 10px;
}
.body-invoice1
{
    text-align: right;
}
.detail-link
{
    margin-top:10px;
}
.border-none
{
    border:0px;
}
.td-data 
{
    margin:0px;
    font-size: 14px;
    line-height: 20px;
}
.td-data h4{
    color:#ff2222;
    font-size: 14px;
    margin: 0px;
}
.rupee-word
{
    font-weight: bold;
}
.content-text{
    text-align:left;
    margin-top:10px;
}
.bold-word{
    font-weight: bold;
    margin-top:10px;
}
.text-right
{
    float:right;
}

 .dollars
 { 
    content:'र'; 
 }
</style>
        <section class="body-invoice top-head">
            <img class="logo" src="img/logo.png" alt=""/>
            <h1 class="head-1">Sales Invoice</h1>
        </section>
        <section class="body-invoice">
            
                <table class="table-invoice" border>
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Invoice</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><div class="td-data">

                                    <h4>Bill to Customer</h4>
                                    <p>{{$dealership}}</p>
                                    <p>{{$address}}</p>
                                    <p>{{$pincode}}</p>
                                </div>
                                <div class="td-data">
                                    <h4>Sell to Customer</h4>
                                    <p>{{$dealership}}</p>
                                    <p>{{$address}}</p>
                                    <p>{{$pincode}}</p>
                                </div></td>
                            <td>
                                <p>Invoice Number</p>
                                <p>{{$history_id}}</p>
                                <p>Invoice Date</p>
                                <p>{{$payment_date}}</p>
                            </td>
                            
                        </tr>
                    </tbody>
                    
                </table>

            

        </section>
        <section class="body-invoice1">
                 
                <table class="table-invoice" border>
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Plan</th>
                            <th>No of Unit</th>
                            <th>Unit Price</th>
                            <th>Subscription Start date</th>
                            <th>Subscription End date</th>
                            <th>Total cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td>1</td>
                            <td>
                            <div class="td-data">
                                    <p>{{$plan}}</p>
                            </div>
                            </td>
                            <td>
                                    <p>{{$maxuser}}</p>
                                
                            </td>
                            <td>
                                    <p class="fa fa-inr">Rs. {{$unitcost}}</p>
                                
                            </td>
                            <td>

                                <p>{{Carbon\Carbon::parse($startdate)->format('d-m-Y')}}</p>
                            </td>
                            <td>
                                <p>{{Carbon\Carbon::parse($enddate)->format('d-m-Y')}}</p>
                            </td>
                            <td><p>Rs. {{$payable_amount}}</p></td>
                        </tr>
                      
                    
                        
                        <tr>
                            <td colspan="5" class="border-none"></td>
                            <td>
                                <p>Amount Ex Tax</p>
                            </td>
                            <td>
                                <p>Rs. 0.00</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="border-none"></td>
                            <td>
                                <p>Service Tax</p>
                            </td>
                            <td>
                                <p>Rs. 0.00</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="border-none"></td>
                            <td>
                                <p>Coupon Amount</p>
                            </td>
                            <td>
                                <p>Rs. {{$coupon_amount}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="border-none"></td>
                            <td>
                                <p>Carry forward Amount</p>
                            </td>
                            <td>
                                <p>Rs. {{$carry_amount}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="border-none"></td>
                            <td>
                                <p>Amount to be paid</p>
                            </td>
                            <td>
                                <p>Rs.{{$payable_amount}}</p>
                            </td>
                        </tr>
                    </tbody>





                    </tbody>
                </table>
                <p class="content-text">Total In Words *** <span class="rupee-word">{{$payable_amount_words}}</span> ***</p>
                <p class="bold-word">Dealer Plus</p>
                <p class="bold-word">Authorised Signature</p>

           

        </section>
        <section>
              
                <table class="table-invoice" border>
                   
                    <tbody>
                        <tr>
                            <td><div class="td-data">
                                    <h4>Billing and Regd office </h4>
                                    <p>Address1</p>
                                    <p>Address2</p>
                                    <p>City</p><p> 600006</p>
                                </div></td>
                            <td><div class="td-data">
                                    <h4>Corporate Office</h4>
                                    <p>Address1</p>
                                    <p>Address2</p>
                                    <p>City</p><p> 600006</p>
                                </div>
                            </td>
                            <td>
                                <div class="td-data">
                                    <h4>Support</h4>
                                    <p>Email:text@test.com</p>
                                    <p>044-243567, 044-564283</p>
                                    
                                </div>
                            </td>
                            
                        </tr>
                        
                    </tbody>





                    </tbody>
                </table>
                
                 <p class="detail-link">CIN No: L7r64535/57843573487</p>
                 <p>Service Tax No: L7r64535/57843573487</p>
                 <p>Service Tax Registration and Classification: L7r64535/57843573487</p>
                 <p>PAN No:DFDFS5834R</p>
                 <p><sup>*</sup>Condition1</p>
                 <p><sup>*</sup>Condition2</p>
                 <p><sup>*</sup>Condition3</p>
                 
           
        </section>



    </body>

</html>




