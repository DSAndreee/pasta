<?php
///////////////////////////////////////////////////
///                                              //
/// Neo                                          //
/// Framework                                    //
///                                              //
/// YouniS Bensalah <younis.bensalah@riseup.net> //
///                                              //
/// Released under the MIT License.              //
///                                              //
///////////////////////////////////////////////////


namespace Neo;


///
/// Translator is a language interface that allows you to get text in some language by providing an identifier.
/// 
/// This class will remind you of translating the texts by creating all the files for you
/// and displaying a placeholder indicating the file you need to edit.
/// 
/// All texts are stored in flat text files.
///
class Translator {

    use Error;

    ///
    /// $lang : The selected language
    /// 
    /// $options : Assoc array of options. (See option keys documentation below.)
    /// 
    /// Sets error mode to ERROR_MODE_RETURN. (See docs for more information about error modes.)
    /// Defines the default options, then overrides them by the user defined ones (if any).
    /// Sets the user-defined language.
    ///
    public function __construct($lang = null, $options = null)
    {
        global $_NEO;
        $this->set_error_mode(ERROR_MODE_RETURN);
        $this->options = array(
            self::DEVEL_MODE => true,
            self::FALLBACK_LANG => 'en',
            self::LANG_DIR => $_NEO['PATHS']['I18N_DIR']
        );
        if ($options !== null) $this->set_options($options);
        $this->lang = empty($lang) ? $this->options[self::FALLBACK_LANG] : (string)$lang;
    }

    ///
    /// Gives you the text.
    /// 
    /// $id : The text identifier string
    /// 
    /// $lang :  Explicit language argument
    ///
    public function get_text($id, $lang = null)
    {
        if (empty($lang)) {
            $lang = $this->lang;
        }
        if ($this->options[self::DEVEL_MODE]) {
            if (!file_exists($filepath = $this->options[self::LANG_DIR] . (string)$lang . '/' . (string)$id)) {
                if (!$this->supports((string)$lang)) {
                    if (is_writable($this->options[self::LANG_DIR])) {
                        mkdir($this->options[self::LANG_DIR] . (string)$lang . '/');
                    }
                    else {
                        return $this->handle_error(sprintf('%s(): Failed to create missing language directory: Check permissions.', __METHOD__));
                    }
                }
                // create requested file
                if ($filestream = @fopen($filepath, 'a')) {
                    fwrite($filestream, sprintf('%s [%s]', $id, $filepath));
                    fclose($filestream);
                }
                else {
                    return $this->handle_error(sprintf('%s(): Failed to create missing file: Check permissions.', __METHOD__));
                }
            }
            $text = file_get_contents($filepath);
        }
        else {
            $text = file_exists($filepath = $this->options[self::LANG_DIR] . (string)$lang . '/' . $id) || file_exists($filepath = $this->options[self::LANG_DIR] . $this->options[self::FALLBACK_LANG] . '/' . (string)$id) ? file_get_contents($filepath) : (string)$id;
        }
        return $text;
    }

    ///
    /// Returns true if requested language directory exists and false otherwise.
    ///
    public function supports($lang)
    {
        return is_dir($this->options[self::LANG_DIR].(string)$lang.'/');
    }

    ///
    /// Select language.
    /// Returns true if language is selected and false if fallback is selected.
    ///
    public function select_lang($lang)
    {
        $this->lang = empty($lang) ? $this->options[self::FALLBACK_LANG] : (string)$lang;
    }

    ///
    /// Get a list of available languages.
    ///
    public function get_supported_langs()
    {
        return array_values(array_diff(scandir($this->options[self::LANG_DIR]), array('.', '..', 'index.php')));
    }

    ///
    /// Set an option using a key-value couple or an assoc array to set multiple options.
    ///
    public function set_options($option_key, $option_value = null)
    {
        if (is_array($option_key)) {
            if (!empty($option_key[self::LANG_DIR]) && is_dir((string)$option_key[self::LANG_DIR])) {
                $this->options[self::LANG_DIR] = (string)$option_key[self::LANG_DIR];
            }
            if (!empty($option_key[self::FALLBACK_LANG]) && $this->supports((string)$option_key[self::FALLBACK_LANG])) {
                $this->options[self::FALLBACK_LANG] = (string)$option_key[self::FALLBACK_LANG];
            }
            if (isset($option_key[self::DEVEL_MODE])) {
                $this->options[self::DEVEL_MODE] = (bool)$option_key[self::DEVEL_MODE];
            }
        }
        elseif ($option_value !== null) {
            switch ($option_key) {
                case self::LANG_DIR:
                if (is_dir((string)$option_value)) {
                    $this->options[self::LANG_DIR] = (string)$option_value;
                    return true;
                }
                break;

                case self::FALLBACK_LANG:
                if ($this->supports((string)$option_value) && !empty($option_value)) {
                    $this->options[self::FALLBACK_LANG] = (string)$option_value;
                    return true;
                }
                break;

                case self::DEVEL_MODE:
                $this->options[self::DEVEL_MODE] = (bool)$option_value;
                return true;
            }
        }
        return $this->handle_error(sprintf('%s(): Invalid option.', __METHOD__));
    }
    
    ///
    /// Get a list of accepted languages from the user's browser.
    /// 
    /// Thanks @fabienwang
    ///
    static public function get_client_langs()
    {
        $httplanguages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $languages = array();
        if (empty($httplanguages)) {
            return $languages;
        }
        foreach (preg_split('/,\s*/', $httplanguages) as $accept) {
            $result = preg_match('/^([a-z]{1,8}(?:[-_][a-z]{1,8})*)(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$/i', $accept, $match);
            if (!$result) {
                continue;
            }
            if (isset($match[2])) {
                $quality = (float)$match[2];
            }
            else {
                $quality = 1.0;
            }
            $countries = explode('-', $match[1]);
            $region = array_shift($countries);
            $country_sub = explode('_', $region);
            $region = array_shift($country_sub);
            foreach ($countries as $country) {
                $languages[$region . '_' . strtoupper($country)] = $quality;
            }
            foreach($country_sub as $country) {
                $languages[$region . '_' . strtoupper($country)] = $quality;
            }
            $languages[$region] = $quality;
        }
        return $languages;
    }

    ///
    /// Selected language
    ///
    protected $lang;

    ///
    /// Options
    ///
    protected $options;

    /// 
    /// In development mode, get_text() will create missing files,
    /// return a placeholder reminding you of missing language files, and tell you the paths.
    /// 
    /// In production mode, get_text() will try to give you a text from a fallback language if there are missing files.
    /// 
    /// If the fallback language doesn't contain the requested text either, then it will return the identifier string.
    /// 
    /// Defaults to true.
    /// 
    const DEVEL_MODE = 'a';

    ///
    /// This is a fallback language used in case you either didn't select a valid language
    /// or you tried to request a missing text (in production mode).
    /// 
    /// Defaults to 'en'.
    /// 
    const FALLBACK_LANG = 'b';
    
    ///
    /// The default path to the language files directory with a trailing slash.
    ///
    /// Defaults to whatever you've set I18N_DIR in the paths config.
    ///
    const LANG_DIR = 'c';

}
