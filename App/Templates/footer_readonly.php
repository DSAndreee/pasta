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

// load given syntax highlight and select the right list item
var listlang = document.getElementById('lang');
var syntax = "<?php echo $this->values['syntax']; ?>";
for (i = 0; i < listlang.options.length; i++)
{
    if (listlang.options[i].value == syntax)
    {
        listlang.options[i].selected = true;
        editor.setOption("mode", syntax);
        CodeMirror.autoLoadMode(editor, syntax);
    }
}
</script>
