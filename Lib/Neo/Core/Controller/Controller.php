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
/// Builds up the page from a user request by assembling views and sub-controllers and retrieving data from models.
///
abstract class Controller {

    use Error;

    ///
    /// Build up page and return code.
    ///
    abstract public function dispatch();

    ///
    /// $match : assoc array that has the following keys: 'map', 'class', 'method', 'request'
    ///
    public function __construct($match = null)
    {
        $this->match = $match === null ? array() : $match;
        $this->document = new DocumentV();
    }

    ///
    /// Match assoc array from router
    ///
    protected $match;

    ///
    /// A base view that represents the whole document.
    ///
    protected $document;

}
