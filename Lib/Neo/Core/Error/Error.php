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
/// Error modes
///
/// ERROR_MODE_EXCEPTION          Throw an exception.
/// ERROR_MODE_RETURN             Return false.
/// ERROR_MODE_VERBOSE            Die noisily.
/// ERROR_MODE_SILENT             Die silenty.
///
define('Neo\ERROR_MODE_EXCEPTION', 1);
define('Neo\ERROR_MODE_RETURN', 2);
define('Neo\ERROR_MODE_VERBOSE', 3);
define('Neo\ERROR_MODE_DIE', 4);

///
/// Default error mode
///
define('Neo\ERROR_MODE_DEFAULT', 1);

///
/// Default exception class name
///
define('Neo\ERROR_DEFAULT_EXCEPTION_CLASS', 'Neo\NeoException');


///
/// Error provides custom error handling in classes.
///
trait Error {

    ///
    /// Get the last error message.
    ///
    public function get_last_error()
    {
        return $this->last_error;
    }

    ///
    /// Set the error handling mode.
    ///
    public function set_error_mode($error_mode)
    {
        $this->error_mode = (int)$error_mode;
    }

    ///
    /// Set the exception class.
    ///
    public function set_exception_class($class)
    {
        $this->exception_class = $class;
    }

    ///
    /// Handle an error and save last error message.
    ///
    /// $msg : Error message
    ///
    /// This method should be called like this whenever you wish to handle an error that occurs in your class:
    ///
    /// if (fail) {
    ///     return $this->handle_error('Whoopsie...');
    /// }
    ///
    protected function handle_error($msg)
    {
        $this->last_error = (string)$msg;
        switch ($this->error_mode) {
            case ERROR_MODE_EXCEPTION:
            throw new $this->exception_class($this->last_error);
            case ERROR_MODE_RETURN:
            return false;
            case ERROR_MODE_VERBOSE:
            die($this->last_error);
        }
        die();
    }

    ///
    /// Get the last error message in a static context.
    ///
    static public function get_last_error_static()
    {
        return self::$_last_error;
    }

    ///
    /// Set the error handling mode in static context.
    ///
    static public function set_error_mode_static($error_mode)
    {
        self::$_error_mode = $error_mode;
    }

    ///
    /// Set the exception class in a static context.
    ///
    static public function set_exception_class_static($class)
    {
        self::$_exception_class = $class;
    }

    ///
    /// Handle an error in a static context.
    ///
    /// $msg : Error message
    ///
    /// This method should be called like this whenever you wish to handle an error that occurs in your class:
    ///
    /// if (fail) {
    ///     return self::_handle_error('Whoopsie...');
    /// }
    ///
    static protected function handle_error_static($msg)
    {
        self::$_last_error = (string)$msg;
        switch (self::$_error_mode) {
            case ERROR_MODE_EXCEPTION:
            throw new self::$_exception_class(self::$_last_error);
            case ERROR_MODE_RETURN:
            return false;
            case ERROR_MODE_VERBOSE:
            die(self::$_last_error);
        }
        die();
    }

    ///
    /// Selected error mode
    ///
    protected $error_mode = ERROR_MODE_DEFAULT;

    ///
    /// Selected exception class name
    ///
    protected $exception_class = ERROR_DEFAULT_EXCEPTION_CLASS;

    ///
    /// Last error message
    ///
    protected $last_error = 'No last error.';

    ///
    /// Selected error mode in a static context
    ///
    static protected $error_mode_static = ERROR_MODE_DEFAULT;

    ///
    /// Selected exception class name in a static context
    ///
    static protected $exception_class_static = ERROR_DEFAULT_EXCEPTION_CLASS;

    ///
    /// Last error message in a static context
    ///
    static protected $last_error_static = 'No last error.';

}
