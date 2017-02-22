<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>图片上传和浏览</title>
<link rel="stylesheet" href="style/main.css" type="text/css" />


</head>
<body>
	<div class="page-format">

		<div id='upload'>
			<h2>
				<strong>上传图片</strong>
			</h2>
			<form action="doAction3.php" method="post"
				enctype="multipart/form-data">
				上传文件：<input type="file" name="myFile" id="myFile"
					multiple="multiple"
					accept="image/jpeg,image,image/png,image/jpg,image/gif,image/wbmp" />
				<input type="submit" value="点击上传" /><br />
				<hr />

			</form>
		</div>
		<div class='picture-format'><?php
$mode = "r";
$fp = fopen("fileLine.con", $mode);

while (! feof($fp)) {
    $path = fread($fp, 46);
    echo "<a  href='#'><img src=$path alt='' /></a>";
}
?>
		</div>
	</div>
</body>
</html>