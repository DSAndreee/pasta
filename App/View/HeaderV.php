<?php
class HeaderV extends Neo\View {

    public function __construct($flags = null, $data = null)
    {
        // overload and keep parent ctor.
        parent::__construct($flags, $data);

        // define some markers:
        //
        // - default
        // - paste
        // - fork
        // - raw
        // - editor
        $this->add_marker('editor')->add_marker('raw')->add_marker('fork')->add_marker('paste');
    }

    public function entete()
    {
        return $this
            ->append_template('header.php')
            ->append_code('<div id="navleft">')
            ->append_code('</div><div id="editor"></div>', 'editor');
    }

    ///
    /// Show the fork button.
    ///
    public function fork()
    {
        return $this->append_code('<a href="?fork="' . $this->values['hash'] . '\" class="navbtn">Fork</a>', 'fork');
    }

    ///
    /// Show the paste button.
    ///
    public function paste()
    {
        return $this->append_code('<a href="#" onClick="save()" class="navbtn">Paste</a>', 'paste');
    }

    //
    /// Show the raw button.
    ///
    public function raw()
    {
        return $this->append_code('<a href="?raw="' . $this->values['hash'] . '" onClick="raw()" class="navbtn">Raw</a>', 'raw');
    }

}
