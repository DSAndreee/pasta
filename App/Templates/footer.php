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
    theme: "monokai"
});

CodeMirror.modeURL = 'Vendor/CodeMirror/mode/%N/%N.js';

function loadLang()
{
    var lang = document.getElementById('lang').value;
    editor.setOption("mode", lang);
    CodeMirror.autoLoadMode(editor, lang);
}

//This function sets the expiration option
function changeExpire()
{
    var l_expire = document.getElementById('sel_expire').value;
    document.getElementById('expire').value = l_expire;
}

//This is to load the right list item and the syntax highlighter at the same time
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

function save() {
    document.getElementById('pastecontent').value = editor.getValue();

    // keep track of syntax highlighting
    document.getElementById('syntax').value = document.getElementById('lang').value;

    //submit the form
    document.forms.paste.submit();
}
</script>
