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
    /// Fork a paste by its hash.
    ///
    public function fork()
    {

    }

    ///
    /// Paste some text.
    ///
    public function paste()
    {
        // check if content request is not empty
        if (Neo\blank($content = (string)$this->match['request']['content'])) {
            return $this->editbox();
        }

        // save to db
        $model = new PastaM();
        $hash = $model->create_paste($content);
        if ($hash === null) {
            // on failure go back to editbox
            return $this->editbox();
        }
        return $this->document
            ->append_view(Neo\id(new TextboxV())
                ->assign('url', $this->complete_url() . '?hash=' . $hash)
                ->assign('rawurl', $this->complete_url() . '?raw=' . $hash)
                ->url())
            ->append_view(Neo\id(new HeaderV())
                ->assign('page_title', 'Your Pasta has been created avec successzz!')
                ->entete(), 'header')
            ->append_view(Neo\id(new FooterV())
                ->footer(), 'footer')
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
                ->assign('page_title', 'Newz')
                ->entete()
                ->paste(), 'header')
            ->append_view(Neo\id(new FooterV())
                ->assign('hash', '')
                ->footer(), 'footer')
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

        $textbox = new TextboxV();
        $textbox->readbox();

        if ($paste !== null) {
            // escape html, replace special entities, and replace newlines as well as spaces with br tags and nbsp entities.
            $paste['content'] = str_replace(' ', '&nbsp;', nl2br(htmlspecialchars(htmlentities($paste['content']))));
            $textbox->assign('paste', $paste);
        }

        return $this->document
            ->append_view($textbox)
            ->append_view(Neo\id(new HeaderV())
                ->assign('page_title', 'Do what you want \'cause a pirate is free. You are a pirate.')
                ->assign('hash', $hash)
                ->raw()
                ->fork()
                ->entete(), 'header')
            ->append_view(Neo\id(new FooterV())
                ->assign('hash', $hash)
                ->footer(), 'footer')
            ->render();
    }

    ///
    /// Display a paste.
    ///
    public function raw()
    {
        $hash = $this->match['request']['raw'];
        $model = new PastaM();
        $paste = $model->get_paste($hash);

        header('Content-Type: text/plain; charset=UTF-8');

        return $this->document
            ->append_view(Neo\id(new TextboxV())
                ->raw()
                ->assign('paste', $paste))
            ->render();
    }

    ///
    /// Return complete URL to page without GET arguments.
    /// eg. https://pad.eliteheberg.fr:9000
    ///
    protected function complete_url()
    {
        $is_https = (array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS']) || (array_key_exists('HTTP_X_FORWARDED_PROTO', $_SERVER) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
        $url = 'http' . ($is_https ? 's' : '') . '://' . $_SERVER['SERVER_NAME'];
        // explicit port?
        if (!$is_https) {
            if ($_SERVER['SERVER_PORT'] != 80) {
                $url .= ':'.$_SERVER['SERVER_PORT'];
            }
        }
        else {
            if ($_SERVER['SERVER_PORT'] != 443) {
                $url .= ':'.$_SERVER['SERVER_PORT'];
            }
        }
        $url .= $_SERVER['REQUEST_URI'];
        $url = str_replace($_SERVER['QUERY_STRING'], '', $url);
        return $url;
    }

}
