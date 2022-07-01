<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UploadFile {

    private static $pathUrl = "app".DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR;

    public static function returnFileContext($request, $isFolder = false,$fieldName = false)
    {
        $folder = 'images';
        if($isFolder)   $folder = $isFolder;

        return self::moveUploadedFileStatic($request,$folder,$fieldName);
    }

    public static function returnFileContextArray($request,$model)
    {
        foreach($request->file('files') as $key => $file)
        {
      
            $nome = sprintf('%s-%s.%s', Str::slug($model->modelo.'-'.$model->id ?? 'file-car'), Str::slug(Str::random(10)), $file->extension() );
            $image =  $model->images()->create([ 'slug' => $nome ]);
            if($image){
               if(env('APP_ENV') == 'producao'){
                   $file->move('/home/m1motorscrm/www/img/files/', $nome);
               }else{
                    $file->move(public_path('img/files'), $nome);
               }
            }
        }
    }

    public static function returnFileContextArrayFile($request, $isFolder = false,$fieldName = false)
    {
        $folder = 'images';
        if($isFolder)   $folder = $isFolder;

        return self::moveUploadedFileStatic($request,$folder,$fieldName);
    }

    private static function moveUploadedFileStatic($request,$folder,$fieldName){
       
    
        $fileName = $fieldName ? $request->$fieldName->getClientOriginalName() : $request->image->getClientOriginalName();


        if($request->name)  $fileName = $request->name;
    
        if($fieldName)
        {
            $filePath = sprintf(  '%s-%s.%s', Str::slug($fileName), Str::slug(Str::random(10)), $request->$fieldName->extension() );
            $request->$fieldName->storeAS('public/'.$folder,$filePath);
        }else{
            $filePath = sprintf(  '%s-%s.%s', Str::slug($fileName), Str::slug(Str::random(10)), $request->image->extension());
            $request->image->storeAS('public/'.$folder,$filePath);
        }

        return $folder.'/'.$filePath;
    }

    public static function removeFileStoragePublicPath($fileName)
    {
        $status = false;
        
        if(env('APP_ENV') == 'producao'){
            $file = "/home/m1motorscrm/www/".$fileName;
            if(file_exists($file)){
                $status = unlink($file);
            }
        }else{
             if(file_exists($fileName)){
                $status = unlink($fileName);
            }
        }
      
        return $status;
       
    }

    public static function removeFileStorage($fileName)
    {
        $status = false;
        if(Storage::disk('public')->has($fileName)){
            $status = unlink(storage_path(self::$pathUrl.$fileName));
        }
        return $status;
       
    }

    public function findUnLinkNewFile($request, $fileName, $fieldName, $folder)
    {

        if ( !empty($fileName) ) 
        {
            if( 
                file_exists ( $this->returnUrlNameStorage($folder, $fileName) ) && !is_dir( $this->returnUrlNameStorage($folder, $fileName) )
            )
            {
                Storage::delete($folder.'/'.$fileName);
            }
        }

        return $this->moveUploadedFile($request, $fieldName, $folder);
    }

    public function findUnLinkNewFilePatient($request, $fileName, $fieldName, $folder)
    {

        if ( !empty($fileName) )
         {
            if( 
                file_exists ( $this->returnUrlNameStorage($folder, $fileName) ) && !is_dir( $this->returnUrlNameStorage($folder, $fileName) )
            )
            {
                Storage::delete($folder.'/'.$fileName);
            }
        }

        return $this->moveUploadedFile($request, $fieldName, $folder);
    }

    public function removeFile($file, $folder)
    {
        Storage::delete($folder.'/'.$file);
    }

   

    private function moveUploadedFile($request, $requestName, $folder = null){
        $filePath = null;
        $isFolder = 'images';
        if($folder){
            $isFolder = $folder;
        }
        $filePath = sprintf(
            '%s-%s.%s',
            Str::slug($request->name ?? auth()->user()->name),
            Str::slug(Str::random(10)),
            $request->$requestName->extension()
        );
        $request->$requestName->storeAS($isFolder,$filePath);
        return $filePath;
    }

    public function imageBase64Upload($request,$folder)
    {
        $base64_str = substr($request->file, strpos($request->file, ",")+1);
        $image =  base64_decode($base64_str);
        $safeName = Str::slug($request->name).Str::slug(Str::random(10)).'.'.'jpg';
        Storage::disk('public')->put($folder.'/'.$safeName, $image);
        return $safeName;
    }

    private function returnUrlNameStorage($folder,$fileName)
    {
        return Storage::url($folder.'/'.$fileName);
    }

    public function uploadFileDocuments($request, $folder, $id)
    {
        $filenameWithExt = $request->file->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file->getClientOriginalExtension();
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        $request->file->storeAs($folder.'/'.$id, $fileNameToStore);
        return  $fileNameToStore;
    }

}
