<!DOCTYPE html>
<html>
<head>
    <title>Pasta - <?php echo $this->get('page_title'); ?></title>
    <meta name="description" content="Pasta, A pastebin for elite coders by Fabien Wang && YouniS Bensalah" />
    <meta charset="UTF-8">
    <link href="Style/neo.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="Vendor/CodeMirror/lib/codemirror.css">
    <script src="Vendor/CodeMirror/lib/codemirror.js"></script>
    <link rel="stylesheet" href="Vendor/CodeMirror/theme/monokai.css">

    <script src="Vendor/CodeMirror/addon/mode/loadmode.js"></script>
    <script src="Vendor/CodeMirror/addon/mode/overlay.js"></script>
    <!--editor search and replace dialogs-->
    <script src="Vendor/CodeMirror/addon/search/searchcursor.js"></script>
    <script src="Vendor/CodeMirror/addon/search/search.js"></script>
    <!--editor options-->
    <script src="Vendor/CodeMirror/addon/edit/matchbrackets.js"></script>
    <script src="Vendor/CodeMirror/addon/edit/closebrackets.js"></script>
    <script src="Vendor/CodeMirror/addon/comment/comment.js"></script>
    <script src="Vendor/CodeMirror/addon/wrap/hardwrap.js"></script>
    <script src="Vendor/CodeMirror/addon/fold/foldcode.js"></script>
    <script src="Vendor/CodeMirror/addon/fold/brace-fold.js"></script>
    <!--php highlighting-->
    <script src="Vendor/CodeMirror/mode/clike/clike.js"></script>
    <script src="Vendor/CodeMirror/mode/php/php.js"></script>
    <script src="Vendor/CodeMirror/mode/xml/xml.js"></script>
    <script src="Vendor/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>
    <!--sublime shortcuts-->
    <script src="Vendor/CodeMirror/keymap/sublime.js"></script>
</head>
<body>

