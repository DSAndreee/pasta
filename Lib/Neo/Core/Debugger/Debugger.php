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
/// Debugger
///
class Debugger {

    ///
    /// Append a debug message, prefixed with a timestamp, to static journal array and log it to journal file.
    /// Return false if logging to file was not possible; true if everything was fine.
    ///
    static public function append($msg)
    {
        global $_NEO;

        // prepend timestamp to msg
        $msg = date('[Y-m-d H:i:s]  ') . htmlspecialchars((string)$msg);

        // append msg to journal
        self::$journal[] = $msg;

        // write to log file and attempt to create it if it doesn't exist
        if ($file = @fopen($_NEO['PATHS']['LOG_DIR'] . 'Journal.log', 'a')) {
            fwrite($file, "$msg\n");
            fclose($file);
            return true;
        }
        return false;
    }

    static public function debug()
    {
        return '<pre class="debug">' . self::$journal . '</pre>';
    }

    ///
    /// Debug message journal array
    ///
    static protected $journal = array();

}
