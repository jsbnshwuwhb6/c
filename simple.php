<?php

//  configuration settings, edit settings in config.php as appropriate
// settings include the base url, the notes path and the menu items displayed
include('config.php');

// Disable caching.
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// If a note's name is not provided or contains non-alphanumeric/non-ASCII or a '-' characters.
if (!isset($_GET['note']) || !preg_match('/^([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*)$/', $_GET['note'])) {

    // Generate a name with 5 random unambiguous characters. Redirect to it.
    header("Location: $base_url/" . substr(str_shuffle('012345679abcdefghjkmnpqrstwxyz'), -5));
    die;
}

$path = $data_directory . $_GET['note'];

// set to false to hide individual menu items
$allow_copy = true;
$allow_delete = true;
$allow_download = true;
$allow_view = true; // requires $allow_menu = true
$allow_new = true;
$allow_mono = true;

// if the notelist files isn't there then automatically set allow_notelist to false
if(!file_exists('notelist.php')) {$allow_noteslist = false; }

$include_Header = true;
$allow_password = true; // to work with files that already have a password set
include 'modules/header.php';

if (isset($_POST['text'])) {
    // Update file.
    $header = "";
    $responseText = "";
	  if ($include_Header) { if (checkHeader($path, null) || isset($_POST['notepwd'])) { $header = setHeader($allow_password);} else $header = "";}
    file_put_contents($path, $header . $_POST['text']);
    $responseText =  "saved"; //for lastsaved logic

    // the following 3 lines can be commented out if you don't want to check write permissions
    $filecheck = file_exists($path);
    if ($filecheck) $responseText =  "saved"; //for lastsaved logic
    if (!is_writable($path)) $responseText = 'error';

    // If provided input is empty, delete file.
    if (!strlen($_POST['text'])) {
        unlink($path);
        $responseText = "deleted";
    }
    echo $responseText;
    die();

}

$content = '';
if (is_file($path)) {
	$content= htmlspecialchars(getFileContents($path), ENT_QUOTES, 'UTF-8'); // requires custom function instead of just file_get_contents to handle header data in first line of file
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="referrer" content="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print $_GET['note']; ?></title>
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="css/simple.min.css">
</head>
<body>
    <div class="container">
		<textarea id="contentAdd" class="contentAdd" placeholder="可在此处添加，按回车键新增到下一行" autofocus></textarea>
        <textarea id="content" class="content"><?php
           echo $content;
        ?></textarea>
    </div>
    <pre id="printable"></pre>
    <script src="js/script.min.js"></script>
    <script src="js/simple.min.js"></script>
    <script src="modules/js/view.min.js"></script>
  	<div class="footer">
  		<div class="navbar" id="navbar">
		    <?php if($allow_view) echo "<a onclick='toggleView(this)' id='a_view' class='active'>预览</a>".PHP_EOL; ?>
		    <?php if($allow_copy) echo "<a onclick='toggleModal_Copy();navbarResponsive();' title='复制笔记链接或内容'>复制</a>".PHP_EOL; ?>
		    <?php if($allow_download) echo "<a onclick='downloadFile();navbarResponsive();'>下载</a>".PHP_EOL; ?>
		    <?php if($allow_mono) echo "<a onclick='toggleMonospace(this);navbarResponsive();' title='等宽字体开/关'>字体</a>".PHP_EOL; ?>
		    <?php if($allow_password) echo "<a onclick='toggleModal_Password();'>密码</a>".PHP_EOL; ?>
		    <?php if($allow_delete) echo "<a onclick='navbarResponsive();deleteFile()'>删除</a>".PHP_EOL; ?>
		    <?php if($allow_new) echo "<a href=" . $base_url . "/>新建</a>".PHP_EOL; ?>
		    <?php if($allow_noteslist) echo "<a href='?' title='切换编辑模式'>模式</a>".PHP_EOL; ?>
  		    <a onclick='location.reload();' id='a_view' class='active'>刷新</a>
  		</div>
  	</div>
  <?php
  if ($allow_lastsaved) include 'modules/lastsaved.php';
  // add this last to make sure modal handling is loaded
  if ($allow_password) {
    include 'modules/password.php';
    echo '<script src="modules/js/modal.min.js"></script>'.PHP_EOL;
    echo "<script src='modules/js/password.min.js'></script>".PHP_EOL;
  }
	if ($include_Header) { checkHeader($path, null, true); } //check if the removePassword be shown ?>
    <script>toggleView('a_view');</script>
    <?php include 'modules/lastsaved.php' ?>
</body>
</html>
