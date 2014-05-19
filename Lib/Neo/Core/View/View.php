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
/// A view sums up a specific module appearance composed of different template files, code snippets, and nested views.
///
/// Eg. a blog page, an album, a sign up page, a footer...
///
abstract class View {

    use Markers;

    use Error;

    ///
    /// $flags : array of methods that will get called just before rendering.
    ///
    /// $data : assoc array of key-value pairs that get assigned to this view.
    ///
    public function __construct($flags = null, $data = null)
    {
        $this->code = '';
        $this->values = is_array($data) ? $data : array();
        $this->flags = array();
        $this->render_once = false;

        // init markers
        $this->init_default_marker();
        $this->init_markers();

        // keep only existing view flags
        if (is_array($flags)) {
            foreach ($flags as $method) {
                if (method_exists($this, $method)) {
                    $this->flags[] = $method;
                }
                else {
                    neo(sprintf('%s() : View flag method %s() is not defined in this view.', __METHOD__, $method));
                }
            }
        }
    }

    ///
    /// Render and return view code.
    ///
    /// View flags get called before rendering.
    ///
    /// Supported code types are:
    ///     'raw'    :   Raw code, left unchanged
    ///     'php'    :   PHP code, gets recursively eval()'d
    ///     'md'     :   Markdown code, gets parsed using Parsedown
    ///     'view'   :   View instance, gets recursively rendered.
    ///
    /// Note that this method will use eval() and output buffering functions for 'php' code.
    ///
    public function render()
    {
        foreach ($this->flags as $method) $this->$method();

        $marker = $this->markers['default']->head();

        do {
            $codes = $marker->get_data();
            foreach ($codes as $c) {
                switch ($c['type']) {

                    case 'php':
                    ob_start();
                    eval('?>' . $c['code']);
                    $c['code'] = ob_get_contents();
                    if ($this->render_once === false) {
                        while (strpos($c['code'], '<?php') !== false) {
                            ob_clean();
                            eval('?>' . $c['code']);
                            $c['code'] = ob_get_contents();
                        }
                    }
                    $this->code .= $c['code'];
                    ob_end_clean();
                    break;

                    case 'md':
                    $parsedown = Parsedown::instance();
                    $this->code .= $parsedown->parse($c['code']);
                    break;

                    case 'view':
                    $this->code .= $c['code']->render();
                    break;

                    case 'raw':
                    default:
                    $this->code .= $c['code'];

                }
            }
        } while (($marker = $marker->next()) !== null);

        return $this->code;
    }

    ///
    /// Toggle render only once. This only affects PHP code.
    ///
    public function render_once($value = true)
    {
        $this->render_once = (bool)$value;
        return $this;
    }

    ///
    /// Cast to string returns rendered view code.
    ///
    /// WARNING: You should always prefer calling render() or __toString() explicitely,
    /// as PHP/Zend Engine cannot handle throwing exceptions within this magic function
    /// when it is called in an implicit context. That's not so magical.
    ///
    public function __toString()
    {
        return $this->render();
    }

    ///
    /// Add a key=value data couple for php templates.
    ///
    /// assign() accepts an assoc array as $key, which will recursively merge all key=value couples.
    ///
    /// Return $this instance for fluent coding.
    ///
    public function assign($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $subkey => $subvalue) $this->assign($subkey, $subvalue);
        }
        else {
            $this->values[$key] = $value;
        }
        return $this;
    }

    ///
    /// Append a view instance to a marker.
    ///
    public function append_view(self $view, $marker = 'default')
    {
        return $this->append_data(array('code' => $view, 'type' => 'view'), $marker);
    }

    ///
    /// Prepend a view instance to a marker.
    ///
    public function prepend_view(self $view, $marker = 'default')
    {
        return $this->prepend_data(array('code' => $view, 'type' => 'view'), $marker);
    }

    ///
    /// Append template file to marker.
    ///
    /// Look for $template first, then try to look in default template directory.
    ///
    /// Try to autodetect the code type by extention ('.php', '.md')
    /// if none was specified ($type = null) and fallback to 'raw'.
    ///
    /// Return $this instance for fluent coding.
    ///
    protected function append_template($template, $marker = 'default', $type = null)
    {
        global $_NEO;

        if (!file_exists($template)) {
            if (!file_exists($template = $_NEO['PATHS']['TEMPLATES_DIR'] . $template)) {
                return $this->handle_error(sprintf('%s() : Template file not found. Looking in default template directory failed as well. (%s)', __METHOD__, $template));
            }
        }

        $code = file_get_contents($template);

        if ($type === null) {
            $type = pathinfo($template, PATHINFO_EXTENSION);
            if ($type !== 'md' && $type !== 'php') $type = 'raw';
        }

        return $this->append_code($code, $marker, $type);
    }

    ///
    /// Prepend template file to marker.
    ///
    /// Look for $template first, then try to look in default template directory.
    ///
    /// Try to autodetect the code type by extention ('.php', '.md')
    /// if none was specified (null) and fallback to 'raw'.
    ///
    /// Return $this instance for fluent coding.
    ///
    protected function prepend_template($template, $marker = 'default', $type = null)
    {
        global $_NEO;

        if (!file_exists($template)) {
            if (!file_exists($template = $_NEO['PATHS']['TEMPLATES_DIR'] . $template)) {
                return $this->handle_error(sprintf('%s() : Template file not found. Looking in default template directory failed as well. (%s)', __METHOD__, $template));
            }
        }

        $code = file_get_contents($template);

        if ($type === null) {
            $type = pathinfo($template, PATHINFO_EXTENSION);
            if ($type !== 'md' && $type !== 'php') $type = 'raw';
        }

        return $this->prepend_code($code, $marker, $type);
    }

    ///
    /// Append code to marker.
    ///
    /// Return $this instance for fluent coding.
    ///
    protected function append_code($code, $marker = 'default', $type = 'raw')
    {
        return $this->append_data(array('code' => $code, 'type' => $type), $marker);
    }

    ///
    /// Prepend code to marker.
    ///
    /// Return $this instance for fluent coding.
    ///
    protected function prepend_code($code, $marker = 'default', $type = 'raw')
    {
        return $this->prepend_data(array('code' => $code, 'type' => $type), $marker);
    }

    ///
    /// Return data value casted to string.
    ///
    /// If the key doesn't exist, return an empty string.
    /// If the value is an instance of Neo\View, return rendered code instead.
    ///
    /// This method is used inside php templates.
    ///
    protected function get($key)
    {
        if (isset($this->values[$key])) {
            if ($this->values[$key] instanceof self) {
                return $this->values[$key]->render();
            }
            return (string)$this->values[$key];
        }
        return '';
    }

    ///
    /// Return true if value is not set or empty and false otherwise.
    ///
    protected function blank($key)
    {
        return empty($this->values[$key]);
    }

    ///
    /// Generated code
    ///
    protected $code;

    ///
    /// Assoc array of values that fill the php templates
    ///
    protected $values;

    ///
    /// Array of methods that will get called just before rendering.
    ///
    protected $flags;

    ///
    /// Render only once
    ///
    protected $render_once;

}
