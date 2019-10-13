<?php

namespace App\Http\Middleware;
use Closure;
use App\model\planmodel;
use Session;
use App\model\schemaconnection;
use DB;

class basicPlan
{
    public $myId;
    public function __construct()
    {
        $this->myId     = Session::get('ses_id');
    }

    public function handle($request, Closure $next)
    {
        $planExp =  schemaconnection::masterconnection()
                        ->table('dealer_billing_details')
                        ->where('dealer_id',Session::get('ses_id'))
                        ->where('current_subscription','1')
                        ->get();

        $myPlan     = schemaconnection::masterconnection()
                        ->table('dealer_billing_details')
                        ->join('master_subscription_plans','master_subscription_plans.subscription_plan_id','=','dealer_billing_details.subscription_plan_id')
                        ->join('master_plans','master_plans.plan_type_id','=','master_subscription_plans.plan_type_id')
                        //->join('plan_module_mapping','plan_module_mapping.plan_type_id','=','master_plans.plan_type_id')
                        ->where('dealer_id',Session::get('ses_id'))
                        ->where('current_subscription','1')
                        ->where('subscription_start_date','>=',$planExp[0]->subscription_start_date)
                        ->where('subscription_end_date','<=',$planExp[0]->subscription_end_date)
                        ->get();
        //  dd($myPlan);
        if(isset($myPlan[0]))
        {
            if(($myPlan[0]->plan_type_id !="2")&&($myPlan[0]->plan_type_id !="3"))
            {
                return redirect('/managesubscription')->with('message-err','You need to Upgrade the package to access this');
            }
            return $next($request);
        }
        else
        {
            return redirect('/managesubscription')->with('message-err','You Plan is Expired');
        }
    }
}