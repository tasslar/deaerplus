<?php

namespace App\Http\Middleware;
use Closure;
use Session;
use App\model\schemaconnection;
use DB;

class documentManagement
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
                        ->join('master_plan_features','master_plan_features.plan_type_id','=','master_plans.plan_type_id')
                        ->where('dealer_id',Session::get('ses_id'))
                        ->where('current_subscription','1')
                        ->where('subscription_start_date','>=',$planExp[0]->subscription_start_date)
                        ->where('subscription_end_date','<=',$planExp[0]->subscription_end_date)
                        ->where('feature_id','6')
                        ->get();
                        //dd($myPlan);

        if($myPlan[0]->feature_allowed=="N")
        {
            return redirect('/managesubscription')->with('message-err','Your current package do not have access to this feature, please upgrade the package');
        }
        return $next($request);
    }
}
