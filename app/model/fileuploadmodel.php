<?php
namespace App\model;
use DB;
use Config;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\File;
use Image;

class fileuploadmodel extends Model
{
	public function __construct()
    {
    	Config::set('database.connections.dmsmysql.database', session::get('dealer_schema_name'));
    }
	public static function image_upload($file,$path)
    {   
        $extension = $file->getClientOriginalExtension();
        /*if($extension !== Config::get('common.file'.$extension)){
            return Config::get('common.fileresult');
        }else{*/
            $fileName = rand(11111,99999).'.'.$extension;
            $result = $file->move($path,$fileName);
            $filename = $fileName;
            $percent = 0.5;
            header('Content-Type: image/'.$extension);
            list($width, $height) = getimagesize($path.'/'.$filename);
            $newwidth = $width * $percent;
            $newheight = $height * $percent;
            $thumb = imagecreatetruecolor($newwidth, $newheight);
            if(Config::get('common.filejpg') == $extension||Config::get('common.filejpeg') == $extension){
                $source = imagecreatefromjpeg($path.'/'.$filename);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                imagejpeg($thumb,$path.'/'.$filename);
            }
            else if(Config::get('common.filegif') == $extension){
                $source = imagecreatefromgif($path.'/'.$filename);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                imagegif($thumb,$path.'/'.$filename);
            }
            else if(Config::get('common.filepng') == $extension){
                $source = imagecreatefrompng($path.'/'.$filename);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                imagepng($thumb,$path.'/'.$filename);
            }
            return $filename;
        /*}*/
    }

    public static function any_upload($file,$path)
    {   
        $extension  = $file->getClientOriginalExtension();
        $fileName   = rand(11111,99999).'.'.$extension;
        $result     = $file->move($path,$fileName);
        $filename   = $fileName;
        return $filename;
    }

    public static function videos_upload($file,$path)
    {   
    	$extension = $file->getClientOriginalExtension();
        if($extension !== Config::get('common.videofile')){
            return Config::get('common.jsonfalse');
        }else{
            $fileName = rand(11111,99999).'.'.$extension;
        	$result = $file->move($path.'/',$fileName);
            return $fileName;
        }
    }
    public static function file_resizer($image,$watermark_path)
    {
        ini_set('max_execution_time', 0);
        $input['imagename'] = time().'.'.'png';        
        $destinationPath = $watermark_path.'/';                 
        $path = $destinationPath.$input['imagename'];          
        $img = Image::make($image->getRealPath())->encode('png', 75);        
        $img->opacity(40);
        $img->resize(180, 180, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.$input['imagename']);        
        return $input['imagename'];
    }
    public static function watermark($image,$position,$watermark_image,$number)
    {               
          $img = Image::make($image); //your image I assume you have in public directory
          if($position == 1)
          {
            $img->insert($watermark_image, 'top-left', 10, 10); //insert watermark in (also from public_directory)
            $img->text($number, 100, 190,function($font)
                {
                    $font->file('textfile/OpenSans-Bold.ttf');
                    $font->size(30);
                    $font->color('#8B0000');
                    $font->align('center');
                    $font->valign('top');
                    //$font->angle(45);
                });
            $img->save($image); //save created image (will override old image)
          }
          elseif($position == 2)
          {
            $img->insert($watermark_image, 'top-right', 10, 10); //insert watermark in (also from public_directory)
            $img->text($number, 925, 190,function($font)
                {
                    $font->file('textfile/OpenSans-Bold.ttf');
                    $font->size(30);
                    $font->color('#8B0000');
                    $font->align('center');
                    $font->valign('top');
                    //$font->angle(45);
                });
            $img->save($image); //save created image (will override old image)
          }
          elseif($position == 3)
          {
            $img->insert($watermark_image, 'bottom-left', 10, 10); //insert watermark in (also from public_directory)
            $img->text($number, 100, 580,function($font)
                {
                    $font->file('textfile/OpenSans-Bold.ttf');
                    $font->size(30);
                    $font->color('#8B0000');
                    $font->align('center');
                    $font->valign('top');
                    //$font->angle(45);
                });
            $img->save($image); //save created image (will override old image)
          }
          elseif($position == 4)
          {
            $img->insert($watermark_image, 'bottom-right', 10, 10); //insert watermark in (also from public_directory)
            $img->text($number, 925, 580,function($font)
                {
                    $font->file('textfile/OpenSans-Bold.ttf');
                    $font->size(30);
                    $font->color('#8B0000');
                    $font->align('center');
                    $font->valign('top');
                    //$font->angle(45);
                });
            $img->save($image); //save created image (will override old image)
          }
          return $image;


    }
    public static function imageresize($image)
    {
        //dd($image);
            $img = Image::make($image); // use this if you want facade style code
            $img->resize(1024, 768);
            $img->save($image);
            return $image;
    }
    public static function documents_upload($files,$path)
    {  
            $document_uploaded = array();
            //$multipleextension = array();
            foreach($files as $file){
                //$multipleextension[] = $file->getClientOriginalExtension();
                /*if($extension == Config::get('common.file'.$extension)){

                }*/
                $extension = $file->getClientOriginalExtension();
                $fileName = rand(11111,99999).'.'.$extension;
                $file->move($path.'/', $fileName);
                $document_uploaded[] = $fileName; 
            }
            /*$duplicateimage_format = array();
            foreach($multipleextension as $extvalue){
               if($extvalue == Config::get('common.documentjpg') || $extvalue != Config::get('common.documentpdf') && $extvalue != Config::get('common.documentdoc')){
                echo 'i am running';
               }
            }
            exit;*/
            return $document_uploaded;
    }

    public static function profile_upload($file,$path)
    {   
        $extension = $file->getClientOriginalExtension();                
        $filetype  = Config::get('fileuploadrestrictions.userprofile_fileformat');               
        if(in_array($extension,$filetype)){
            $fileName = rand(11111,99999).'.'.$extension;
            $result = $file->move($path,$fileName);
            $filename = $fileName;
            $percent = 0.5;
            header('Content-Type: image/'.$extension);
            list($width, $height) = getimagesize($path.'/'.$filename);
            $newwidth = $width * $percent;
            $newheight = $height * $percent;
            $thumb = imagecreatetruecolor($newwidth, $newheight);
            if(Config::get('common.filejpg') == $extension){
                $source = imagecreatefromjpeg($path.'/'.$filename);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                imagejpeg($thumb,$path.'/'.$filename);
            }
            else if(Config::get('common.filegif') == $extension){
                $source = imagecreatefromgif($path.'/'.$filename);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                imagegif($thumb,$path.'/'.$filename);
            }
            /*else if(Config::get('common.filepng') == $extension){
                
                $source = imagecreatefromjpeg($path.'/'.$filename);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                imagepng($thumb,$path.'/'.$filename);
            }*/
            
            return $filename;
           
        }
        else
        {            
            return Config::get('common.fileresult');
        }
    }

}