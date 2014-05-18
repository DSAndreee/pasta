<!DOCTYPE html>
<html>
<head>
    <title>Pasta - <?php echo $this->get('page_title'); ?></title>
    <meta name="description" content="Pasta, A pastebin for elite coders by Fabien Wang && YouniS Bensalah" />
    <meta charset="UTF-8">
    <link href="Style/neo.css" type="text/css" rel="stylesheet"/>

    <link rel="stylesheet" href="Vendor/CodeMirror/lib/codemirror.css">
    <link rel="stylesheet" href="Vendor/CodeMirror/addon/fold/foldgutter.css">
    <link rel="stylesheet" href="Vendor/CodeMirror/addon/dialog/dialog.css">
    <link rel="stylesheet" href="Vendor/CodeMirror/theme/monokai.css">
    <script src="Vendor/CodeMirror/lib/codemirror.js"></script>
    <script src="Vendor/CodeMirror/addon/search/searchcursor.js"></script>
    <script src="Vendor/CodeMirror/addon/search/search.js"></script>
    <!--<script src="Vendor/CodeMirror/addon/dialog/dialog.js"></script>-->
    <script src="Vendor/CodeMirror/addon/edit/matchbrackets.js"></script>
    <script src="Vendor/CodeMirror/addon/edit/closebrackets.js"></script>
    <script src="Vendor/CodeMirror/addon/comment/comment.js"></script>
    <script src="Vendor/CodeMirror/addon/wrap/hardwrap.js"></script>
    <script src="Vendor/CodeMirror/addon/fold/foldcode.js"></script>
    <script src="Vendor/CodeMirror/addon/fold/brace-fold.js"></script>
    <script src="Vendor/CodeMirror/mode/php/php.js"></script>
    <script src="Vendor/CodeMirror/keymap/sublime.js"></script>

</head>
<body>
    <div id="navleft">
        <a href="#" onClick="save()" class="navbtn">Paste</a>
        <a href="#" onClick="fork()" class="navbtn">Fork</a>
        <a href="#" onClick="raw()" class="navbtn">Raw</a>
    </div>
    <div id="editor"></div>
