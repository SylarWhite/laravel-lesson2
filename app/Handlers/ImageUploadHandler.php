<?php
/**
 * Created by PhpStorm.
 * User: abel
 * Date: 2019/1/21
 * Time: 16:20
 */
namespace App\Handlers;

use Intervention\Image\Facades\Image;

class ImageUploadHandler
{
    protected $allowed_ext = ['png','jpg','jpeg','gif'];

    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        // 自定义上传文件夹
        $folder_name = "uploads/images/$folder/".date('Ym/d',time());
        // 加入到系统绝对路径当中
        $upload_path = public_path().'/'.$folder_name;
        // 获取到上传文件后缀
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        // 重命名上传文件
        $filename = $file_prefix.'_'.time().'_'.str_random(10).'.'.$extension;
        // 判断是否允许上传该类型文件
        if(! in_array($extension, $this->allowed_ext)){
            return false;
        }
        // 移动上传的文件到自定义目录内
        $file->move($upload_path,$filename);

        if($max_width && $extension != 'gif'){
            $this->reduceSize($upload_path.'/'.$filename, $max_width);
        }

        return ['path'=>config('app.url')."/$folder_name/$filename"];
    }

    public function reduceSize($file_path, $max_width)
    {
        $image = Image::make($file_path);

        $image->resize($max_width,null,function ($constraint){
            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();
            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        $image->save();
    }
}
