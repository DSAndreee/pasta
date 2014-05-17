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
        if (!empty($_POST['title']) and !empty($_POST['content']))
        {
          $model = new PastaM();
          $paste = $model->create_paste($_POST['title'], $_POST['content']);
          if (!empty($paste))
          {
            header('Location: ?hash='.$paste['hash']);
          }
        }
        return $this->document
            ->append_view(Neo\id(new TextboxV())
                ->editbox())
            ->render();
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
                ->entete(), 'header')
            ->render();
    }

}
