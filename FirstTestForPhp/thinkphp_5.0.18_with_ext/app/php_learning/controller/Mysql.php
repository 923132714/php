<?php
namespace app\php_learning\controller;
use think\Db;

class Mysql
{

public function insert($valArray){
    if($valArray)
    try{
        $result = Db::execute("insert into mysql(id1,id2) values($valArray[0],$valArray[1])");
        dump($result);
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}

public function test(){
//数据库所用信息
$host = 'localhost';
$user = 'root';
$pass = '923132714';
$database = "phplearn";
$table = "mysql";
$step = 10;
$page = 1;
$data_len = 0;
//检测Mysqli扩展
if (function_exists('mysqli_connect')) {
    echo 'Mysqli扩展已经安装';
    echo "<br/>";
}
//mysqli
//连接
$link = mysqli_connect($host, $user, $pass) or die('mysqli数据库连接失败');
//选库
$res = mysqli_select_db($link, $database) or die('选择数据库 $database 失败');
//设置编码
$res = mysqli_query($link, "set names 'utf8'") or die('设置编码失败');

// 显示数据库
/*$res = mysqli_query($link, "show databases") or die('显示数据库失败');*/


//查询语句
$pos = ($page - 1) * $step;
$res = mysqli_query($link, "select * from $table limit $pos,$step") or die('查询语句失败');
// 赋值
while ($row = mysqli_fetch_row($res)) {
    $data_len++;
    $data[] = $row;

}

echo "<hr/>";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>phpLearn/Mysql表格输出</title>


</head>


<body>
<dir>
    <?php

    ?>
    <input type=button on_click=last(); value="上一页">
    <?php
    echo "这是第 $page 页"
    ?>
    <input type=button on_click=next(); value="下一页">
</dir>
<table cellspacing="0" cellpadding="0" border="1px solid #000">
    <tr>
        <td align=center width="200" height="20">
            help_topic_id
        </td>
        <td align=center width="200" height="20">
            help_keyword_id
        </td>
    </tr>
    <?php
    for ($i = 1; $i <= $step; $i++) {
        if ($data_len >= $i) {

            echo("<tr>");
            for ($j = 1; $j <= 2; $j++) {

                echo("<td  align=center width=\"200\" height=\"20\" >");

                print_r($data[$i - 1][$j - 1]);

                echo("</td>");

            }
            echo("</tr>");

        }

    }
    ?>
</table>


</body>
</html>
<?php

mysqli_close($link);


}
}

