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
        $hash = $this->match['request']['fork'];
        $model = new PastaM();
        $paste = $model->get_paste($hash);

        $textbox = new TextboxV();
        $textbox->editbox();

        if ($paste !== null) {
            $textbox->assign($paste);

            return $this->document
                ->append_view($textbox)
                ->append_view(Neo\id(new HeaderV())
                    ->assign('page_title', 'Forkz')
                    ->entete()
                    ->paste(), 'header')
                ->append_view(Neo\id(new FooterV())
                    ->assign('syntax', $paste['syntax'])
                    ->expiration_list()
                    ->lang_list()
                    ->footer(), 'footer')
                ->render();
        }
        else {
            return $this->document
                ->append_view(Neo\id(new TextboxV())
                    ->assign('msg', 'UR PASTA NOES EXISTINGZ')
                    ->msg())
                ->append_view(Neo\id(new HeaderV())
                    ->assign('page_title', 'UR PASTA NOES EXISTINGZ')
                    ->newz()
                    ->entete()
                    ->bottomlinks(), 'header')
                ->append_view(Neo\id(new FooterV())
                    ->lang_list()
                    ->footer_readonly(), 'footer')
                ->render();
        }
    }

    ///
    /// Paste some text.
    ///
    public function paste()
    {
        // check if content request is not empty
        if (Neo\blank($content = (string)$this->match['request']['content']) || Neo\blank($syntax = (string)$this->match['request']['syntax']) || Neo\blank($expire = (string)$this->match['request']['expire'])) {
            return $this->editbox();
        }

        // save to db
        $model = new PastaM();
        $hash = $model->create_paste($content, $syntax, $expire);
        if ($hash === null) {
            // on failure go back to editbox
            return $this->editbox();
        }

        header('Location: ' . $this->complete_url() . '?hash=' . $hash);
        return '';
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
                ->bottomlinks()
                ->paste(), 'header')
            ->append_view(Neo\id(new FooterV())
                ->assign('syntax', 'php')
                ->expiration_list()
                ->lang_list()
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
            $textbox->assign($paste);

            $date1 = new DateTime($paste['delete_after']);
            if ($date1->format('Ymd') == '99991231')
            {
              $str_interval = 'Never';
            }
            else
            {
              $date2 = new DateTime();
              $interval = $date1->diff($date2);
              //var_dump($interval);
              $str_interval = '';
              if ($interval->format('%m') > '0') {
                $str_interval .= $interval->format('%m month(s) ');
              }
              if ($interval->format('%d') > '0') {
                $str_interval .= $interval->format('%d day(s) ');
              }
              if ($interval->format('%h') > '0') {
                $str_interval .= $interval->format('%h hour(s) ');
              }
              if ($interval->format('%i') > '0') {
                $str_interval .= $interval->format('%i minute(s)');
              }
            }

            return $this->document
                ->append_view($textbox)
                ->append_view(Neo\id(new HeaderV())
                    ->assign('page_title', 'Do what you want \'cause a pirate is free. You are a pirate.')
                    ->assign('hash', $hash)
                    ->newz()
                    ->raw()
                    ->fork()
                    ->entete()
                    ->bottomlinks(), 'header')
                ->append_view(Neo\id(new FooterV())
                    ->assign('syntax', $paste['syntax'])
                    ->assign('expires_at', $str_interval)
                    ->lang_list()
                    ->expiration_date()
                    ->footer_readonly(), 'footer')
                ->render();
        }
        else {
            return $this->document
                ->append_view(Neo\id(new TextboxV())
                    ->assign('msg', 'UR PASTA NOES EXISTINGZ')
                    ->msg())
                ->append_view(Neo\id(new HeaderV())
                    ->assign('page_title', 'UR PASTA NOES EXISTINGZ')
                    ->newz()
                    ->entete()
                    ->bottomlinks(), 'header')
                ->append_view(Neo\id(new FooterV())
                    ->lang_list()
                    ->footer_readonly(), 'footer')
                ->render();
        }
    }

    ///
    /// Display a paste.
    ///
    public function raw()
    {
        $hash = $this->match['request']['raw'];
        $model = new PastaM();
        $paste = $model->get_paste($hash);

        if (empty($paste['content'])) {
            header('Content-Type: text/plain; charset=UTF-8');
            http_response_code(404);
            return 'UR PASTA NOES EXISTINGZ';
        }

        // just return the raw code directly!
        header('Content-Type: text/plain; charset=UTF-8');
        return $paste['content'];
    }

    ///
    /// Display about page.
    ///
    public function about()
    {
        $model = new PastaM();
        $total = $model->get_total();
        $about = new AboutV(null, array('total'=> $total));

        return $this->document
            ->append_view(Neo\id(new TextboxV())
                ->assign('msg', $about)
                ->msg())
            ->append_view(Neo\id(new HeaderV())
                ->assign('page_title', 'Aboutz')
                ->newz()
                ->entete()
                ->bottomlinks(), 'header')
            ->append_view(Neo\id(new FooterV())
                ->footer_readonly(), 'footer')
            ->render();
    }

    ///
    /// Return complete URL to page without GET arguments.
    /// eg. "https://pad.eliteheberg.fr:9000/"
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
        $url = str_replace('?' . $_SERVER['QUERY_STRING'], '', $url);
        return $url;
    }

}
