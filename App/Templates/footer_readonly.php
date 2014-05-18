<div id="footer">
    Pasta &mdash; A pastebin for elite coders by <a href="mailto:fabienwang@eliteheberg.fr">Fabien Wang</a> &amp;&amp; <a href="mailto:younishd@eliteheberg.fr">YouniS Bensalah</a>
    <span class="aright">
        <!-- Language list goes here -->
        <select id="lang" onchange="loadLang();" disabled=disabled>
        </select>
    </span>
</div>
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
    theme: "monokai",
    readOnly: true
});

CodeMirror.modeURL = 'Vendor/CodeMirror/mode/%N/%N.js';

function loadLang() {
    var lang = document.getElementById('lang').value;
    editor.setOption("mode", lang);
    CodeMirror.autoLoadMode(editor, lang);
}

function save() {
    document.getElementById('pastecontent').value = editor.getValue();
    //submit the form
    document.forms.paste.submit();
}

</script>
