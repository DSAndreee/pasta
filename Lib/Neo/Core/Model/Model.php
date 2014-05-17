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
/// Model
///
abstract class Model {

    use Error;

    ///
    /// Use a database object.
    ///
    public function __construct($db = null)
    {
        if ($db === null) {
            $db = Database::load();
        }
        $this->db = $db;
    }

    ///
    /// Database instance
    ///
    protected $db;

}
