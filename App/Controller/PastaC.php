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
    public function url_to_hash($hash)
    {
        $isHttps = (array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS']) || (array_key_exists('HTTP_X_FORWARDED_PROTO', $_SERVER) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https');
        $url = 'http'.($isHttps ? 's' : '').'://'.$_SERVER['SERVER_NAME'];
        if (!$isHttps)
        {
            if ($_SERVER['SERVER_PORT'] != 80)
            {
                $url .= ':'.$_SERVER['SERVER_PORT'];
            }
        }
        else
        {
            if ($_SERVER['SERVER_PORT'] != 443)
            {
                $url .= ':'.$_SERVER['SERVER_PORT'];
            }
        }
        $url .= $_SERVER['REQUEST_URI'];
        $url .= '?hash='.$hash;
        return $url;
    }

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
                ->assign('url', $this->url_to_hash($hash))
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
