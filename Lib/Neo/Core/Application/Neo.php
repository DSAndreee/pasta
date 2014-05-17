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
/// Application class that passes the user request to the router and calls the mapped controller.
///
class Neo {

    use Error;

    ///
    /// Set the user request and instanciate a Router.
    /// $request : assoc request array that defaults to array_merge($_POST, $_GET).
    ///
    public function __construct($request = null)
    {
        $this->request = $request === null ? array_merge($_POST, $_GET) : $request;
        $this->router = new Router();
    }

    ///
    /// Invoke as run().
    ///
    public function __invoke()
    {
        return $this->run();
    }

    ///
    /// Run a Neo application.
    ///
    /// Running is done inside a try block.
    /// run() checks if the website is online "offline" page if it's not.
    /// It looks for a matching route to the request and calls the mapped controller or prints a 404 page.
    ///
    /// Return $this instance for fluent coding.
    ///
    public function run()
    {
        global $_NEO;

        try {
            if ($_NEO['GLOBAL']['ONLINE']) {
                $match = $this->router->match($this->request);
                if ($match !== null) {
                    if (class_exists($match['class'])) {
                        $controller = new $match['class']($match);
                        if (method_exists($controller, $match['method'])) {

                            echo $controller->$match['method']();

                        }
                        else {
                            return $this->handle_error(sprintf('%s() : Controller method %s::%s() doesn\'t exist.', __METHOD__, $match['class'], $match['method']));
                        }
                    }
                    else {
                        return $this->handle_error(sprintf('%s() : Controller class %s doesn\'t exist.', __METHOD__, $match['class']));
                    }
                }
                else {
                    echo message('404', 'Invisible ninjas stole this page.');
                }
            }
            else {
                echo message('Offline.', 'Invisible ninjas are maintaining this page.');
            }
            neo('Good bye...');
        }

        catch (NeoException $e) {
            neo('NeoException: ' . $e->getMessage());
            neo('Good bye...');

            $_NEO['GLOBAL']['DEBUG_MODE'] && die(message('NeoException', $e->getMessage()));
            die();
        }

        catch (\PDOException $e) {
            neo('PDOException: ' . $e->getMessage());
            neo('Good bye...');

            $_NEO['GLOBAL']['DEBUG_MODE'] && die(message('PDOException', $e->getMessage()));
            die();
        }

        catch (\Exception $e) {
            neo('Exception: ' . $e->getMessage());
            neo('Good bye...');

            $_NEO['GLOBAL']['DEBUG_MODE'] && die(message('Exception', $e->getMessage()));
            die();
        }

        return $this;
    }

    ///
    /// Map an action to a controller class and a dispatch method.
    ///
    /// $action : This can either be a string holding the action regex or an associative array as a key-value couple.
    /// The former will assume the key to be 'action'.
    /// Note that if you pass an array then you can use regular expressions for both the key and the value.
    /// You may also pass multiple rules at once. Remember that this won't define two different routes. It rather
    /// defines a single composed route. The rules are linked with a logical AND.
    ///
    /// $class : The Controller class name that should get mapped to the action.
    /// Note that any class must implement the same constructor prototype as Neo\Controller.
    ///
    /// $method : The method replacing the default dispatch().
    /// Note that any method must be public and return the actual code.
    ///
    /// The Regex format is like the Perl syntax, just without any delimiters or options.
    /// The regex always describes the whole input string.
    /// For eg 'a|b' only matches 'a' and 'b' but does not match 'aa'.
    /// Any hash '#' characters in regex must be escaped with a backslash.
    ///
    /// Return $this instance for fluent coding.
    ///
    public function map($action, $class, $method = 'dispatch')
    {
        $this->router->map($action, $class, $method);
        return $this;
    }

    ///
    /// Define a source for autoloading.
    ///
    public function source($class, $source = null)
    {
        Autoloader::_source($class, $source);
        return $this;
    }

    ///
    /// Assoc array containing the user request
    ///
    protected $request;

    ///
    /// Router instance
    ///
    protected $router;

}
