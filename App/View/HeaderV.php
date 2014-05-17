<?php
class HeaderV extends Neo\View {

    public function entete()
    {
        return $this->append_template('header.php');
    }

}
