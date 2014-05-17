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
/// Router allows you to define routes by mapping actions to controller classes and methods.
///
class Router {

    ///
    /// Map an action to a controller class and a dispatch method.
    /// 
    /// $action : This can either be a string holding the action regex or an associative array as a key-value couple.
    /// The former will assume the key to be 'action'.
    /// Note that if you pass an array then you can use regular expressions for both the key and the value.
    /// You may also pass multiple rules at once. Remember that this won't define two different routes. It rather
    /// defines a single composed route. The rules are linked with a logical AND.
    /// 
    /// $class : The controller class.
    /// 
    /// $method : The dispatch method.
    /// 
    /// The regex format is like the Perl syntax, just without any delimiters or options.
    /// The regex always describes the whole input string.
    /// eg. 'a|b' only matches 'a' and 'b' but does not match 'aa'.
    /// Any hash '#' characters in regex must be escaped with a backslash.
    ///
    public function map($action, $class, $method)
    {
        $this->routes[] = array(
            'map' => is_array($action) ? $action : array('action' => (string)$action),
            'class' => (string)$class,
            'method' => (string)$method
        );
    }

    ///
    /// Look for a matching route to the request.
    /// 
    /// match() loops through all defined routes and seeks for a route where all defined rules match the request.
    /// 
    /// Return assoc array that contains the full request along with the mapped route:
    /// ['request', 'map', 'class', 'method']
    /// 
    /// If no route matched the request, then return null.
    /// If the request is empty, match() defaults to 'action=index'.
    /// 
    /// If the request matches more than one route, the more specific one wins.
    /// (Note that this does not apply to regular expressions.)
    ///
    public function match($request)
    {
        if (empty($request)) $request = array('action' => 'index');

        $result = array();
        foreach ($this->routes as $r) {
            $found = true;
            foreach ($r['map'] as $map_key => $map_value) {
                $match = false;
                foreach ($request as $req_key => $req_value) {
                    if (preg_match("#^$map_key$#", $req_key) && preg_match("#^$map_value$#", $req_value)) {
                        $match = true;
                        break; // next map
                    }
                }
                if (!$match) {
                    $found = false;
                    break; // next route
                }
            }
            if ($found) $result[] = $r;
        }

        if (empty($result)) return null;

        $max = 0;
        foreach ($result as $each) {
            if (($i = count($each['map'])) > $max) {
                $max = $i;
                $final = $each;
            }
        }
        return array_merge($final, array('request' => $request));
    }

    ///
    /// Array of defined routes.
    ///
    protected $routes = array();

} 
