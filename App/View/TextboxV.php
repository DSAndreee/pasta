<?php
class TextboxV extends Neo\View {

    public function editbox()
    {
        return $this->append_template('editbox.php');
    }

    public function readbox()
    {
        return $this->append_template('readbox.php');
    }

}
