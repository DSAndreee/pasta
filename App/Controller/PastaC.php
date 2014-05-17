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

    ///
    /// Handle a paste request.
    ///
    public function paste()
    {
        // escape html
        $title = htmlspecialchars($this->match['request']['title']);
        $content = htmlspecialchars($this->match['request']['content']);

        // save to db
        $model = new PastaM();
        $hash = $model->create_paste($title, $content);
        if ($hash === null) {
            // on failure go back to editbox
            return $this->editbox();
        }
        return $this->document
            ->append_view(Neo\id(new TextboxV())
                ->assign('url', 'https://pad.eliteheberg.fr/?hash=' . $hash)
                ->url())
            ->append_view(Neo\id(new HeaderV())
                ->assign('page_title', 'Your Pasta has been created avec successzz!')
                ->entete(), 'header')
            ->render();
    }

    ///
    /// Display a text edit field.
    ///
    public function editbox()
    {
        return $this->document
            ->append_view(Neo\id(new TextboxV())
                ->editbox())
            ->append_view(Neo\id(new HeaderV())
                ->assign('page_title', 'New Pasta')
                ->entete(), 'header')
            ->render();
    }

    ///
    /// Display a paste.
    ///
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
                ->entete(), 'header')
            ->render();
    }

}
