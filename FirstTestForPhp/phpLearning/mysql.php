<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>phpLearn/Mysql表格输出</title>


    <?php
    //数据库所用信息
    $host = 'localhost';
    $user = 'root';
    $pass = '923132714';
    $database = "phplearn";
    $table = "mysql";
    $step = 10;
    $page = 1;
    $data_len = 0;

    //检测Mysql扩展
    /*
     *
    if (function_exists('mysql_connect')) {
        echo 'Mysql扩展已经安装';
        echo "<br/>";
    }

    //mysql 过时

    //$link = mysql_connect($host, $user, $pass)or die('mysql数据库连接失败');
    //mysql_select_db('code1');
    //mysql_query("set names 'utf8'");
    //$result = mysql_query('select * from user limit 1');
    //$row = mysql_fetch_assoc($result);
    //print_r($row);
    */

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
    //打印
/*    echo '<br/>';
    echo '<br/>';
    echo '<pre>';
    print_r($data);
    echo '</pre>';*/




    //只获取数字索引数组
    /*
    $row = mysqli_fetch_row($res);
    var_dump($row);
    echo "mysqli_fetch_row(\$res)";
    echo "<br/>";
    echo '<pre>';
    print_r($row);
    echo '</pre>';
    */

    //只获取数字索引数组
    /*$row = mysqli_fetch_array($res, MYSQLI_NUM);
    var_dump($row);
    echo "mysqli_fetch_array(\$res, MYSQLI_NUM)";
    echo "<br/>";*/

    //默认的会包含数字索引的下标以及字段名的关联索引下标
    /*$row = mysqli_fetch_array($res);
    var_dump($row);
    echo "mysqli_fetch_array(\$res)";
    echo "<br/>";
    echo '<pre>';
    print_r($row);
    echo '</pre>';*/

    //只获取关联索引数组
    /*$row = mysqli_fetch_assoc($res);
    var_dump($row);
    echo "mysqli_fetch_assoc(\$result)";
    echo "<br/>";
    echo '<pre>';
    print_r($row);
    echo '</pre>';*/

    //设定参数为MYSQL_ASSOC则只获取关联索引数组，等同于mysql_fetch_assoc函数。
    /*$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
    var_dump($row);
    echo "mysqli_fetch_array(\$result, MYSQLI_ASSOC)";
    echo "<br/>";*/


    //PDO
    /*$dsn = 'mysql:dbname=testdb;host=127.0.0.1';
    $user = 'dbuser';
    $password = 'dbpass';
    $dbh = new PDO($dsn, $user, $password);*/

    //    随机颜色
    /*    $bc = "000000";
        $color = array();
        for ($i=0; $i<10000; $i++)
        {
            $color[$i] = "#" . $bc;
            $bc += 0x00000f;

    //echo($color[$i] . "\t");
        }*/

    echo "<hr/>";

    ?>
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
        <td  align=center width="200" height="20" >
            help_topic_id
        </td>
        <td  align=center width="200" height="20" >
            help_keyword_id
        </td>
    </tr>
    <?php
    for ($i = 1; $i <= $step; $i++) {
        if($data_len>=$i){

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

?>