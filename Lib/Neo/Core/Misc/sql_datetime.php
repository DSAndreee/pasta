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
/// Return a SQL DATETIME string like "xxxx-xx-xx xx:xx:xx".
/// It accepts a datetime string, a Unix timestamp, or a DateTime object.
/// If no argument is passed, it uses the current date and time.
///
function sql_datetime($t = null)
{
    if (is_string($t)) return date('Y-m-d H:i:s', strtotime($t));
    if (is_int($t)) return date('Y-m-d H:i:s', $t);
    if ($t instanceof DateTime) return $t->format('Y-m-d H:i:s');
    return date('Y-m-d H:i:s');
}
