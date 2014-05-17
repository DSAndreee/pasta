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
/// Return a simply formatted HTML message.
///
function message($title, $msg)
{
    return sprintf('<div style="text-align:center;color:#333;"><h1>%s</h1><hr><h2>%s</h2></div>', $title, $msg);
}
