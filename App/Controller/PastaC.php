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

    protected function hash_to_url_to_paste($hash)
    {
        $is_https = (array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS']) || (array_key_exists('HTTP_X_FORWARDED_PROTO', $_SERVER) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https');
        $url = 'http'.($is_https ? 's' : '').'://'.$_SERVER['SERVER_NAME'];
        if (!$is_https)
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
        $url = str_replace($_SERVER["QUERY_STRING"], '', $url);
        $url .= 'hash='.$hash;
        return $url;
    }

    protected function hash_to_rawurl_to_paste($hash)
    {
        $is_https = (array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS']) || (array_key_exists('HTTP_X_FORWARDED_PROTO', $_SERVER) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https');
        $url = 'http'.($is_https ? 's' : '').'://'.$_SERVER['SERVER_NAME'];
        if (!$is_https)
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
        $url = str_replace($_SERVER["QUERY_STRING"], '', $url);
        $url .= 'raw='.$hash;
        return $url;
    }

    public function paste()
    {
        $content = (string)$this->match['request']['content'];

        // save to db
        $model = new PastaM();
        $hash = $model->create_paste($content);
        if ($hash === null) {
            // on failure go back to editbox
            return $this->editbox();
        }
        return $this->document
            ->append_view(Neo\id(new TextboxV())
                ->assign('url', $this->hash_to_url_to_paste($hash))
                ->assign('rawurl', $this->hash_to_rawurl_to_paste($hash))
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
                ->entete(), 'header')
            ->append_view(Neo\id(new FooterV())
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
                ->entete(), 'header')
            ->append_view(Neo\id(new FooterV())
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

}
