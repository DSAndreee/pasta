<?php
class FooterV extends Neo\View {

    public function footer()
    {
        return $this->append_template('footer.php');
    }

    public function footer_readonly()
    {
        return $this->append_template('footer_readonly.php');
    }

}
