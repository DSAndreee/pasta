<script>
var editor = CodeMirror(document.getElementById('editor'), {
    value: document.getElementById('pastecontent').value,
    lineNumbers: true,
    lineWrapping: true,
    styleActiveLine: true,
    mode: "application/x-httpd-php",
    indentUnit: 4,
    indentWithTabs: false,
    keyMap: "sublime",
    autoCloseBrackets: true,
    matchBrackets: true,
    showCursorWhenSelecting: true,
    cursorBlinkRate: 0, //Disable cursor blinking
    theme: "monokai",
    readOnly: true
});

CodeMirror.modeURL = 'Vendor/CodeMirror/mode/%N/%N.js';

// load given syntax highlight
editor.setOption("mode", "<?php echo $this->get('syntax'); ?>");
CodeMirror.autoLoadMode(editor, "<?php echo $this->get('syntax'); ?>");
</script>
