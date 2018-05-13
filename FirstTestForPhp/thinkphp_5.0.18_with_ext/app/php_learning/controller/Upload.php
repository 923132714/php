<?php
namespace app\php_learning\controller;
use app\php_learning\controller\Sheet;
/**
 * User: chenyu_wang
 * Date: 2018/5/6
 * Time: 10:04
 */
//文件上传
class Upload
{
    public function index()
    {
        ?>
        <!doctype html>
        <html lang="zh_cn">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>PhpLearning/Upload</title>
        </head>
        <body>
        <form action="Upload\upload" method="post" enctype="multipart/form-data">
            请选择excel文件：
            <input type="file" name="myfile">
            <br>
            <input type="submit" value="上传文件">
            <br>


        </form>
        </body>
        </html>

        <?php
    }

    public function upload()
    {

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('myfile');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if ($file) {
            $file->validate(['ext'=>'xlsx']);
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
               /*
                // 成功上传后 获取上传信息
                // 输出 文件后缀
                echo $info->getExtension();
                // 输出 路径加文件名
                echo $info->getSaveName();
                // 输出 文件名
                echo $info->getFilename();*/

                $sheet = new Sheet();
                $sheet->importdatabase($info->getSaveName());


            } else {
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }
}

?>









