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
        $this->add_marker('editor')->add_marker('bottomlinks')->add_marker('raw')->add_marker('fork')->add_marker('paste')->add_marker('new');
    }

    public function entete()
    {
        return $this
            ->append_template('header.php')
            ->append_code('<div id="navleft">')
            ->append_code('</div><div id="navleftbottom">', 'bottomlinks')
            ->append_code('</div><div id="editor"></div>', 'editor');
    }

    ///
    /// Show the New button
    ///
    public function newz()
    {
        return $this->append_code('<a href="./" class="navbtn" title="New"><i class="icon-new icon-2x"></i></a>', 'new');
    }

    ///
    /// Show the fork button.
    ///
    public function fork()
    {
        return $this->append_code('<a href="?fork=' . $this->values['hash'] . '" class="navbtn" title="Fork"><i class="icon-fork icon-2x"></i></a>', 'fork');
    }

    ///
    /// Show the paste button.
    ///
    public function paste()
    {
        return $this->append_code('<a href="#" onClick="save()" class="navbtn" title="Paste"><i class="icon-paste icon-2x"></i></a>', 'paste');
    }

    //
    /// Show the raw button.
    ///
    public function raw()
    {
        return $this->append_code('<a href="?raw=' . $this->values['hash'] . '" class="navbtn" title="Raw"><i class="icon-raw icon-2x"></i></a>', 'raw');
    }

    public function bottomlinks()
    {
        return $this->append_code('<a href="?action=about" class="bignavbtn">Pasta</a>', 'bottomlinks');
    }

}
