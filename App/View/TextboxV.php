<?php
class TextboxV extends Neo\View {

    ///
    /// Edit text box
    ///
    public function editbox()
    {
        return $this->append_template('editbox.php');
    }

    ///
    /// RAW view
    ///
    public function raw()
    {
        return $this->append_template('raw.php');
    }

    ///
    /// Read-only text box
    ///
    public function readbox()
    {
        return $this->append_template('readbox.php');
    }

    ///
    /// Show paste url with hash.
    ///
    public function url()
    {
        return $this->append_code('<a href="<?php echo $this->get(\'url\'); ?>"><?php echo $this->get(\'url\'); ?></a>', 'default', 'php');
    }

}
