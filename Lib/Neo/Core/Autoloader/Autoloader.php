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
/// Autoloader allows you to add class sources and load them.
///
class Autoloader {

    ///
    /// Load a class.
    ///
    static public function load($class)
    {
        global $_NEO;
        if ((($source = self::source($class)) !== null) || (preg_match('/M$/', $class) && file_exists($source = $_NEO['PATHS']['APP_DIR'] . 'Model/' . $class . '.php')) || (preg_match('/V$/', $class) && file_exists($source = $_NEO['PATHS']['APP_DIR'] . 'View/' . $class . '.php')) || (preg_match('/C$/', $class) && file_exists($source = $_NEO['PATHS']['APP_DIR'] . 'Controller/' . $class . '.php'))) {
            neo("Autoload $class ($source)");
            require_once $source;
        }
    }

    ///
    /// Define a source.
    ///
    static public function source($class, $source = null)
    {
        if ($source === null) return isset(self::$sources[$class]) ? self::$sources[$class] : null;
        neo("Source $class ($source)");
        self::$sources[$class] = $source;
        return new static;
    }

    ///
    /// Unset a source.
    ///
    static public function unsource($class)
    {
        if (isset(self::$sources[$class])) {
            unset(self::$sources[$class]);
            neo("Unsource $class ($source)");
        }
        return new static;
    }

    ///
    /// Array of defined sources
    ///
    static protected $sources;

}
