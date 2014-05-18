<?php
class FooterV extends Neo\View {

    public function footer()
    {
        if (!empty($this->values['hash']))
        {
            return $this->append_template('footer_readonly.php');
        }
        else
        {
            return $this->append_template('footer.php');
        }

    }

}
