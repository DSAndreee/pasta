<!DOCTYPE html>
<html>
<head>
    <title>Pasta - <?php echo $this->get('page_title'); ?></title>
    <meta name="description" content="Pasta, A pastebin for elite coders by Fabien Wang && YouniS Bensalah" />
    <meta charset="UTF-8">
    <link href="Style/neo.css" type="text/css" rel="stylesheet"/>
</head>
<body>
    <div class="navleft">
        <a href="#" onClick="save()" class="navbtn">Paste</a>
        <a href="#" onClick="fork()" class="navbtn">Fork</a>
        <a href="#" onClick="raw()" class="navbtn">Raw</a>
    </div>
    <div id="editor"></div>
