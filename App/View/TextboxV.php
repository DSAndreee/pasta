<?php
class TextboxV extends Neo\View {

    ///
    /// Edit text box
    ///
    public function editbox()
    {
        return $this->append_template('editbox.php')->render_once();
    }

    ///
    /// Read-only text box
    ///
    public function readbox()
    {
        return $this->append_template('readbox.php')->render_once();
    }

    ///
    /// Show paste url with hash.
    ///
    public function url()
    {
        return $this->append_code('<div class="center"><div class="centeredbox"><?php echo $this->get(\'page_title\'); ?><br/><a href="<?php echo $this->get(\'url\'); ?>"><?php echo $this->get(\'url\'); ?></a></div></div>', 'default', 'php');
    }

    ///
    /// Show a message
    ///
    public function msg()
    {
        return $this->append_code('<div class="center"><div class="centeredbox"><?php echo $this->get(\'msg\'); ?></div></div>', 'default', 'php');
    }

}
