<?php

namespace app\Manage\controller;

use think\Controller;

class UploadController extends Controller
{
    public function file_upload()
    {
        header("content-type:text/html;charset=utf-8");
        // dump($_FILES);exit;

        if (empty($_FILES)) {
            echo json_encode(['code' => 0, 'msg' => '请先上传文件']);
            exit();
        }
        //设置时区
        date_default_timezone_set('PRC');
        //获取文件名
        $filename = $_FILES['file']['name'];
        //获取文件临时路径
        $temp_name = $_FILES['file']['tmp_name'];
        //获取大小
        $size = $_FILES['file']['size'];
        //获取文件上传码，0代表文件上传成功
        $error = $_FILES['file']['error'];
        if ($error) {
            echo json_encode(['code' => 0, 'msg' => '文件上传失败']);
            exit();
        }
        //判断文件大小是否超过设置的最大上传限制
        if ($size > 10 * 1024 * 1024){
            echo json_encode(['code' => 0, 'msg' => '文件大小超过10M']);
            exit();
        }
        //phpinfo函数会以数组的形式返回关于文件路径的信息
        //[dirname]:目录路径[basename]:文件名[extension]:文件后缀名[filename]:不包含后缀的文件名
        $arr = pathinfo($filename);
        //获取文件的后缀名
        $ext_suffix = $arr['extension'];
        //设置允许上传文件的后缀
        $suffix = config('FILES_EXT');
        //判断上传的文件是否在允许的范围内（后缀）==>白名单判断
        if (!in_array($ext_suffix, $suffix)) {
            //window.history.go(-1)表示返回上一页并刷新页面
            echo json_encode(['code' => 0, 'msg' => '上传了不支持的文件类型']);
            exit();
        }
        //检测存放上传文件的路径是否存在，如果不存在则新建目录
        if (!file_exists('upload/excel')){
            mkdir('upload/excel');
        }
        //为上传的文件新起一个名字，保证更加安全
        $default_title = date('YmdHis',time()).rand(100,1000);
        $new_filename = $default_title.'.'.$ext_suffix;
        //将文件从临时路径移动到磁盘
        if (move_uploaded_file($temp_name, 'upload/excel/' . $new_filename)){
            echo json_encode(['code' => 1, 'msg' => '文件上传成功', 'data' => $new_filename, 'origin' => $arr['filename']]);
            exit;
        }else{
            echo json_encode(['code' => 0, 'msg' => '文件上传失败']);
            exit;
        }
    }

    public function image_upload()
    {
        header("content-type:text/html;charset=utf-8");

        if (empty($_FILES)) {
            echo json_encode(['code' => 0, 'msg' => '请先上传图片']);
            exit();
        }
        //设置时区
        date_default_timezone_set('PRC');
        //获取文件名
        $filename = $_FILES['file']['name'];
        //获取文件临时路径
        $temp_name = $_FILES['file']['tmp_name'];
        //获取大小
        $size = $_FILES['file']['size'];
        //获取文件上传码，0代表文件上传成功
        $error = $_FILES['file']['error'];
        if ($error) {
            echo json_encode(['code' => 0, 'msg' => '图片上传失败']);
            exit();
        }
        //判断图片大小是否超过设置的最大上传限制
        if ($size > 10 * 1024 * 1024){
            echo json_encode(['code' => 0, 'msg' => '图片大小超过10M']);
            exit();
        }
        //phpinfo函数会以数组的形式返回关于图片路径的信息
        //[dirname]:目录路径[basename]:图片名[extension]:图片后缀名[filename]:不包含后缀的图片名
        $arr = pathinfo($filename);
        //获取图片的后缀名
        $ext_suffix = $arr['extension'];
        //设置允许上传图片的后缀
        $suffix = config('FILES_EXT');
        //判断上传的图片是否在允许的范围内（后缀）==>白名单判断
        if (!in_array($ext_suffix, $suffix)) {
            //window.history.go(-1)表示返回上一页并刷新页面
            echo json_encode(['code' => 0, 'msg' => '上传了不支持的图片类型']);
            exit();
        }
        //检测存放上传图片的路径是否存在，如果不存在则新建目录
        if (!file_exists('upload/images')){
            mkdir('upload/images');
        }
        //为上传的图片新起一个名字，保证更加安全
        $default_title = date('YmdHis',time()).rand(100,1000);
        $new_filename = $default_title.'.'.$ext_suffix;
        //将图片从临时路径移动到磁盘
        if (move_uploaded_file($temp_name, 'upload/images/' . $new_filename)) {
            echo json_encode(['code' => 1, 'msg' => '图片上传成功', 'data' => $new_filename]);
        } else {
            echo json_encode(['code' => 0, 'msg' => '图片上传失败']);
        }
        exit;
    }
}
