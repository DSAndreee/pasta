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
/// Crop an array.
/// 
/// $array : [0][1][2][3][4][5][6][7][8][9]
///                 ^           ^
///                 |           |
///               from         to
///               
/// return :       [2][3][4][5][6]
///
function array_crop($array, $from, $to)
{
    return array_slice($array, $from, $to - $from + 1);
} 
