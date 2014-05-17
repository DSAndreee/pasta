<?php
class PastaC extends Neo\Controller {

    public function __construct($match = null)
    {
        parent::__construct($match);

        // header
        // default
        // footer
        $this->document->add_marker('header', 'default', true)->add_marker('footer');
    }

    public function dispatch()
    {
        return $this->editbox();
    }

    public function editbox()
    {
        return $this->document
            ->append_view(Neo\id(new TextboxV())
            ->editbox());
    }

    public function readbox()
    {
        $hash = $this->match['request']['hash'];
        $model = new PastaM();
        $paste = $model->get_paste($hash);

        return $this->document
            ->append_view(Neo\id(new TextboxV())
                ->readbox()
                ->assign('paste', $paste))
            ->append_view(Neo\id(new HeaderV())
                ->assign('page_title', $paste['title'])
                ->entete(), 'header');
    }

}

