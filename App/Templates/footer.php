<div id="footer">
    Pasta &mdash; A pastebin for elite coders by <a href="mailto:fabienwang@eliteheberg.fr">Fabien Wang</a> &amp;&amp; <a href="mailto:younishd@eliteheberg.fr">YouniS Bensalah</a>
    <span class="aright">
        <!-- Language list goes here -->
        <select name="lang" onchange="">
            <option value=""></option>
        </select>
    </span>
</div>
<script>
var editor = CodeMirror(document.getElementById('editor'), {
    value: document.getElementById('pastecontent').value,
    lineNumbers: true,
    lineWrapping: true,
    styleActiveLine: true,
    mode: "php",
    keyMap: "sublime",
    autoCloseBrackets: true,
    matchBrackets: true,
    showCursorWhenSelecting: true,
    theme: "monokai"
});
</script>
