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


$_NEO['DB'] = array_merge(isset($_NEO['DB']) ? $_NEO['DB'] : array(), array(


    ///
    /// Database engine
    /// 
    'ENGINE' => 'mysql',


    ///
    /// Database server hostname
    /// 
    'HOST' => 'localhost',


    ///
    /// Database server port
    /// 
    'PORT' => '3306',


    ///
    /// Database name
    /// 
    'NAME' => 'neo',


    ///
    /// Database user
    /// 
    'USER' => 'fabien',


    ///
    /// Database password
    /// 
    'PASS' => 'trololooo'


));
