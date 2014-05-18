<div id="footer">
    Pasta &mdash; A pastebin for elite coders by <a href="mailto:fabienwang@eliteheberg.fr">Fabien Wang</a> &amp;&amp; <a href="mailto:younishd@eliteheberg.fr">YouniS Bensalah</a>
    <span class="aright">
        <!-- Language list goes here -->
        <select id="lang" onchange="loadLang();">
            <option value="apl">APL</option>
            <option value="asterisk">Asterisk</option>
            <option value="clike">C, C++, C#</option>
            <option value="clojure">Clojure</option>
            <option value="cobol">COBOL</option>
            <option value="coffeescript">CoffeeScript</option>
            <option value="commonlisp">Common Lisp</option>
            <option value="css">CSS</option>
            <option value="python">Cython</option>
            <option value="d">D</option>
            <option value="django">Django</option>
            <option value="diff">Diff</option>
            <option value="dtd">DTD</option>
            <option value="dylan">Dylan</option>
            <option value="ecl">ECL</option>
            <option value="eiffel">Eiffel</option>
            <option value="erlan">Erlang</option>
            <option value="fortran">Fortran</option>
            <option value="mllike">F#</option>
            <option value="gas">Gas</option>
            <option value="gherkin">Gherkin</option>
            <option value="go">Go</option>
            <option value="groovy">Groovy</option>
            <option value="haml">HAML</option>
            <option value="haskell">Haskell</option>
            <option value="haxe">Haxe</option>
            <option value="htmlembedded">HTML embedded scripts</option>
            <option value="htmlmixed">HTML mixed-mode</option>
            <option value="http">HTTP</option>
            <option value="clike">Java</option>
            <option value="jade">Jade</option>
            <option value="javascript">JavaScript</option>
            <option value="jinja2">Jinja2</option>
            <option value="julia">Julia</option>
            <option value="css">LESS</option>
            <option value="livescript">LiveScript</option>
            <option value="lua">Lua</option>
            <option value="markdown">Markdown</option>
            <option value="gfm">Markdown GitHub Flavored</option>
            <option value="mirc">mIRC</option>
            <option value="nginx">Nginx</option>
            <option value="ntriples">NTriples</option>
            <option value="mllike">OCaml</option>
            <option value="octave">Octave</option> (MATLAB)
            <option value="pascal">Pascal</option>
            <option value="pegjs">PEG</option>
            <option value="perl">Perl</option>
            <option value="php" selected=selected>PHP</option>
            <option value="pig">Pig Latin</option>
            <option value="properties">Properties files</option>
            <option value="puppet">Puppet</option>
            <option value="python">Python</option>
            <option value="q">Q</option>
            <option value="r">R</option>
            <option value="rpm">RPM</option>
            <option value="rst">reStructuredText</option>
            <option value="ruby">Ruby</option>
            <option value="rust">Rust</option>
            <option value="sass">Sass</option>
            <option value="clike">Scala</option>
            <option value="scheme">Scheme</option>
            <option value="css">SCSS</option>
            <option value="shell">Shell</option>
            <option value="sieve">Sieve</option>
            <option value="smalltalk">Smalltalk</option>
            <option value="smarty">Smarty</option>
            <option value="smartymixed">Smarty/HTML mixed</option>
            <option value="solr">Solr</option>
            <option value="sql">SQL</option>
            <option value="sparql">SPARQL</option>
            <option value="stex">sTeX, LaTeX</option>
            <option value="tcl">Tcl</option>
            <option value="tiddlywiki">Tiddlywiki</option>
            <option value="tiki">Tiki wiki</option>
            <option value="toml">TOML</option>
            <option value="turtle">Turtle</option>
            <option value="vb">VB.NET</option>
            <option value="vbscript">VBScript</option>
            <option value="velocity">Velocity</option>
            <option value="verilog">Verilog/SystemVerilog</option>
            <option value="xml">XML/HTML</option>
            <option value="xquery">XQuery</option>
            <option value="yaml">YAML</option>
            <option value="z80">Z80</option>
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
    theme: "monokai"
});

CodeMirror.modeURL = 'Vendor/CodeMirror/mode/%N/%N.js';

function loadLang() {
    var lang = document.getElementById('lang').value;
    editor.setOption("mode", lang);
    CodeMirror.autoLoadMode(editor, lang);
}

function save() {

}

function fork() {

}

function raw() {

}

</script>
