<?php
$dir = opendir(".");
while($entryName = readdir($dir)) {
    $dirArray[] = $entryName;
}
closedir($dir); ?>
<html>
<head>
    <style>
        html {background: #EFEFEF;font-family: Arial, sans-serif;font-size: 14px;}
        img {margin:0 auto;}
        .logo {text-align: center;}
        .container {background: #FFFFFF;border-radius: 10px;margin:20px auto;width: 400px;padding:20px;}
        .container ul {padding:0;margin: 25px 0 0 0;}
        .container ul li {padding:0;margin: 0;border-bottom: 1px solid #aaa;list-style: none;clear: both;overflow: hidden;}
        .container ul li a {padding:10px 0;margin: 0;color:teal;display: block;float: left;}
        .container ul li span {padding:10px 0;display: block;float: right;}
    </style>
</head>
<body>
<div class="container">
    <ul>
    <?php foreach ($dirArray as $key => $file) { ?>
        <?php if (strpos($file, 'html')) { ?>
            <?php $lastModified = date('M d, H:i',filemtime($file)); ?>
                <li><a href="<?php echo 'https://'.$_SERVER['HTTP_HOST'].'/html/dkubs/'; ?><?php echo $file;?>"><?php echo $file; ?></a><span><?php  echo $lastModified; ?></span></li>
            <?php }; ?>
    <?php } ?>
    </ul>
</div>
</body>
</html>