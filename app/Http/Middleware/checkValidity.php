<?php

namespace App\Http\Middleware;
use Closure;
use App\model\planmodel;
use Session;
use App\model\schemaconnection;
use DB;

class checkValidity
{
    public $myId;
    public function __construct()
    {
        $this->myId     = Session::get('ses_id');
    }

    public function handle($request, Closure $next)
    {
        $subDealer =  schemaconnection::masterconnection()
                        ->table('dms_dealers')
                        ->where('parent_id','!=','0')
                        ->where('d_id',Session::get('ses_id'))
                        ->get();

        if(isset($subDealer[0]))
        {
            //dd(Session::get('ses_id'));
        }
        else
        {
            $mainDealer =  schemaconnection::masterconnection()
                        ->table('dealer_billing_details')
                        ->where('dealer_id',Session::get('ses_id'))
                        ->where('current_subscription','1')
                        ->get();
                        //dd($mainDealer);
        //dd($planExp);
            if(isset($mainDealer[0]))
            { 
                //dd('1');
                $mainDealerPlan     = schemaconnection::masterconnection()
                                        ->table('dealer_billing_details')
                                        ->join('master_subscription_plans','master_subscription_plans.subscription_plan_id','=','dealer_billing_details.subscription_plan_id')
                                        ->join('master_plans','master_plans.plan_type_id','=','master_subscription_plans.plan_type_id')
                                        //->join('plan_module_mapping','plan_module_mapping.plan_type_id','=','master_plans.plan_type_id')
                                        ->where('dealer_id',Session::get('ses_id'))
                                        ->where('current_subscription','1')
                                        ->where('subscription_start_date','>=',$mainDealer[0]->subscription_start_date)
                                        ->where('subscription_end_date','<=',$mainDealer[0]->subscription_end_date)
                                        ->get();
                //dd($myPlan);

                if(isset($mainDealerPlan[0]))
                {
                    
                }
                else
                {
                    return redirect('/managesubscription')->with('message-err','Your current package has expired, please click "Renew" button to renew the package.');
                }
            }
            else
            {
                //dd('2');
                return redirect('/managesubscription')->with('message-err','You Don`t have Active Subscription, please click "Renew" button to renew the package.');
            }
            
        }
        return $next($request);
    }
}
