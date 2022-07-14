<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
	.center {
		position: absolute;
		top: 50%;
		left: 50%;
		width: 300px;
		height: 200px;
		margin: -100px 0 0 -100px;
		font-family: sans-serif;
		font-size: large;
	}
	</style>
	<title><?php if (isset($_GET['note'])) print $_GET['note']; ?></title>
</head>
<body onload="document.forms[0].password.focus();">
<div class="center">
<form method="POST">
	<p style="font-size: small">此笔记有密码：</br>
	<input type="password" name="password" placeholder="输入密码" autofocus>
	<button type="submit">确定</button>
	</br>
	<a href="<?php echo strtok($_SERVER["REQUEST_URI"],'?') . "?view"; ?>">以只读方式查看</a>
	   
	</p>
	<?php if ($allowReadOnlyView == "1") { ?>
		<p style="font-size: small"><a href="<?php echo dirname($_SERVER['PHP_SELF']);?>">创建新笔记</a> </p>
	<?php } if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?> <p style="font-size: small">无效的密码</p> <? } ?>
</form>
</div>
</body>
</html>
