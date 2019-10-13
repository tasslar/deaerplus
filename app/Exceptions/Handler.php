<?php

namespace App\Exceptions;
use DB;
use Exception;
use Session;
use File;
use Config;
use Carbon\Carbon;
use App\model\commonmodel;
use Illuminate\Database\Eloquent\Model;
use App\model\notificationsmodel;
use App\model\buyymodel;
use App\model\alertmodel;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
       
        if($exception instanceof CustomException)
        {
            $error          =   $exception->getMessage();
            //$header_data    =   commonmodel::commonheaderdata();
            $createdate     =   'error_exceptionlog_'.date("y-m-d");
            if(file_exists(public_path('/custom_logs/')))
            {
                $original   =   public_path('/custom_logs/');
                $filename   =   File::append($original.'/'.$createdate.'.txt',$error."\r\n");
                $realpath   =   url('/custom_logs/'.$createdate.'.txt');
                $nameoffile =   $createdate.'.txt';
                $result     =   Storage::put("/custom_logs/".$nameoffile, file_get_contents($realpath),'public');
            }
            else
            {
                File::makeDirectory(public_path('/custom_logs/'), 0777, true, true);
                $original   =   public_path('/custom_logs/');
                $filename   =   File::append($original.'/'.$createdate.'.txt',$error."\r\n");
                $realpath   =   url('/custom_logs/'.$createdate.'.txt');
                $nameoffile =   $createdate.'.txt';
                $result     =   Storage::put("/custom_logs/".$nameoffile, file_get_contents($realpath),'public');
            }
            //return view('errors/503',compact('error','header_data'));
            return \Response::view('custom_exp');
        }
        elseif($exception instanceof \Symfony\Component\Debug\Exception\FatalErrorException) {
                        return \Response::view('custom_exp');
        }
        elseif($this->isHttpException($exception)){
            switch ($exception->getStatusCode()) {
                case '404':
                            \Log::error($exception);
                        return \Response::view('custom_exp');
                break;

                case '500':
                    \Log::error($exception);
                        return \Response::view('custom_exp');   
                break;

                case '405':
                    \Log::error($exception);
                        return \Response::view('logout');   
                break;

                default:
                    return $this->renderHttpException($exception);
                break;
            }
        }
        else
        {
            $error          =   $exception->getMessage();
            if(!empty($error)&&($error!='The given data failed to pass validation.'))
            {

                //$header_data    =   commonmodel::commonheaderdata();
                $createdate     =   'error_exceptionlog_'.date("y-m-d");
                if(file_exists(public_path('/custom_logs/')))
                {
                    $original   =   public_path('/custom_logs/');
                    $filename   =   File::append($original.'/'.$createdate.'.txt',$error."\r\n");
                    $realpath   =   url('/custom_logs/'.$createdate.'.txt');
                    $nameoffile =   $createdate.'.txt';
                    $result     =   Storage::put("/custom_logs/".$nameoffile, file_get_contents($realpath),'public');
                }
                else
                {
                    File::makeDirectory(public_path('/custom_logs/'), 0777, true, true);
                    $original   =   public_path('/custom_logs/');
                    $filename   =   File::append($original.'/'.$createdate.'.txt',$error."\r\n");
                    $realpath   =   url('/custom_logs/'.$createdate.'.txt');
                    $nameoffile =   $createdate.'.txt';
                    $result     =   Storage::put("/custom_logs/".$nameoffile, file_get_contents($realpath),'public');
                }
                //return view('errors/503',compact('error','header_data'));        
                return \Response::view('custom_exp');
            }
            else
            {
                //To Show Middleware Exception
                return parent::render($request, $exception);
            }
        }
        //return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        return redirect()->guest('login');
    }
}
