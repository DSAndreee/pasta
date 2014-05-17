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
/// MarkdownW encapsulates markdown code.
///
class MarkdownW extends Widget {

    ///
    /// Simply append some markdown code.
    ///
    public function markdown($md)
    {
        return $this->append_code($md, 'default', 'md');
    }

}
