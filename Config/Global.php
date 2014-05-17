<?php
///
/// Neo
/// Framework
/// 
/// YouniS Bensalah <younis.bensalah@riseup.net>
/// 
/// Released under the MIT License.
///


namespace Neo;


$_NEO['GLOBAL'] = array_merge(isset($_NEO['GLOBAL']) ? $_NEO['GLOBAL'] : array(), array(

    
    ///
    /// PHP Timezone
    /// <http://php.net/timezones.php>
    /// 
    'PHP_TIMEZONE' => 'Europe/Paris',


    ///
    /// Debug mode
    ///
    'DEBUG_MODE' => true,


    ///
    /// Online
    ///
    'ONLINE' => true


));
