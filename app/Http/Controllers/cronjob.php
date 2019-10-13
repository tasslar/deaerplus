<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Response;
use Config;
use Queue;
use Cookie;
class cronjob extends Controller
{
	
	public function s3cron_job(Request $request)
	{
		//s3images upload function
    	$rootpath = public_path().'/profileimages/';
    	//echo $rootpath;

        $fileContents = public_path("/profileimages/618.jpg");
        $result = Storage::put("/profileimages/618.jpg", file_get_contents($fileContents),'public');
        $myfile = file_put_contents(public_path("/profileimages/logs.txt"), date("h:i:sa") , FILE_APPEND | LOCK_EX);
        sleep(10);
        $fileContents = public_path("/profileimages/619.jpg");
        $result = Storage::put("/profileimages/619.jpg", file_get_contents($fileContents),'public');
        $myfile = file_put_contents(public_path("/profileimages/logs.txt"), date("h:i:sa") , FILE_APPEND | LOCK_EX);
        sleep(10);
        $fileContents = public_path("/profileimages/620.jpg");
        $result = Storage::put("/profileimages/620.jpg", file_get_contents($fileContents),'public');
        $myfile = file_put_contents(public_path("/profileimages/logs.txt"), date("h:i:sa") , FILE_APPEND | LOCK_EX);
        sleep(10);
        $fileContents = public_path("/profileimages/621.jpg");
        $result = Storage::put("/profileimages/621.jpg", file_get_contents($fileContents),'public');
        $myfile = file_put_contents(public_path("/profileimages/logs.txt"), date("h:i:sa") , FILE_APPEND | LOCK_EX);
        sleep(10);
        $fileContents = public_path("/profileimages/663.jpg");
        $result = Storage::put("/profileimages/663.jpg", file_get_contents($fileContents),'public');
        $myfile = file_put_contents(public_path("/profileimages/logs.txt"), date("h:i:sa") , FILE_APPEND | LOCK_EX);
        sleep(10);
        $fileContents = public_path("/profileimages/751.jpg");
        $result = Storage::put("/profileimages/751.jpg", file_get_contents($fileContents),'public');
        $myfile = file_put_contents(public_path("/profileimages/logs.txt"), date("h:i:sa") , FILE_APPEND | LOCK_EX);
        sleep(10);

        $fileContents = public_path("/profileimages/784.jpg");
        $result = Storage::put("/profileimages/784.jpg", file_get_contents($fileContents),'public');
        $myfile = file_put_contents(public_path("/profileimages/logs.txt"), date("h:i:sa") , FILE_APPEND | LOCK_EX);
        sleep(10);

        $fileContents = public_path("/profileimages/890.jpg");
        $result = Storage::put("/profileimages/890.jpg", file_get_contents($fileContents),'public');
        $myfile = file_put_contents(public_path("/profileimages/logs.txt"), date("h:i:sa") , FILE_APPEND | LOCK_EX);
        sleep(10);        

        $fileContents = public_path("/profileimages/894.jpg");
        $result = Storage::put("/profileimages/894.jpg", file_get_contents($fileContents),'public');
        $myfile = file_put_contents(public_path("/profileimages/logs.txt"), date("h:i:sa") , FILE_APPEND | LOCK_EX);
        sleep(10);

        $fileContents = public_path("/profileimages/902.jpg");
        $result = Storage::put("/profileimages/902.jpg", file_get_contents($fileContents),'public');
        $myfile = file_put_contents(public_path("/profileimages/logs.txt"), date("h:i:sa") , FILE_APPEND | LOCK_EX);
        sleep(10);

        $fileContents = public_path("/profileimages/logs.txt");
        $result = Storage::put("/profileimages/logs.txt", file_get_contents($fileContents),'public');
        echo "https://s3-ap-southeast-1.amazonaws.com/dealerplus/profileimages/logs.txt";


        //$s3files = [];
        //$fileinfos = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($ rootpath));
        
        /*foreach($fileinfos as $pathname => $fileinfo) {
            if (!$fileinfo->isFile()){ continue; }
            //$fileget = file_get_contents($fileinfo);
            $s3folder = str_replace(public_path(), "", $pathname);
            $s3move = str_replace('\\', '/', $s3folder);
            $s3files[$pathname] = $s3move;
            //echo $pathname;
            echo "<br/>";
        }*/

        //foreach($s3files as $key => $value){
        	//ini_set('max_execution_time',0);
        	//Queue::push(function() use($key,$value){
        		//$result = Storage::disk('s3')->put($value, file_get_contents($key),'public');
        	//});	
        	//sleep(50);
            //unlink($key);
        //}

        //$dir = public_path().'/uploadimages';
        //$di = new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS);
        //$ri = new \RecursiveIteratorIterator($di, \RecursiveIteratorIterator::CHILD_FIRST);
        //foreach ($ri as $file) {
          //  echo $file;
            //echo "<br/>";
           // echo $file->isDir();
            //$file->isDir() ?  rmdir($file) : unlink($file);
        //}
        
        //s3images video upload function
        /*$rootpath = public_path().'/uploadvideo';
    	$s3files = [];
        $fileinfos = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($rootpath));
        foreach($fileinfos as $pathname => $fileinfo) {
            if (!$fileinfo->isFile()){ continue; }
            //$fileget = file_get_contents($fileinfo);
            $s3folder = str_replace(public_path(), "", $pathname);
            $s3move = str_replace('\\', '/', $s3folder);
            $s3files[$pathname] = $s3move;
            echo $pathname;
            echo "<br/>";
        }

        foreach($s3files as $key => $value){
        	ini_set('max_execution_time',0);
        	//Queue::push(function() use($key,$value){
        		$result = Storage::disk('s3')->put($value, file_get_contents($key),'public');
        	//});	
        	sleep(50);
            unlink($key);
        }*/
	}
}