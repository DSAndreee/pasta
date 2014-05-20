<?php
class FooterV extends Neo\View {

    public function __construct($flags = null, $data = null)
    {
        parent::__construct($flags, $data);

        // - list
        // - default
        $this->add_marker('list', 'default', true);
    }

    public function footer()
    {
        return $this->append_template('footer.php');
    }

    public function footer_readonly()
    {
        return $this->append_template('footer_readonly.php');
    }

    public function lang_list()
    {
        return $this->append_template('lang_list.html', 'list');
    }

}
