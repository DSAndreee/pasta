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
/// Database provides a PDO singleton instance based on the config in $_NEO['DB'].
///
/// This class takes into account the following keys:
///
///     ['ENGINE']        Database engine
///     ['HOST']          Database server hostname
///     ['PORT']          Database server port
///     ['NAME']          Database name
///     ['USER']          Database user
///     ['PASS']          Database password
///
/// Note that only MySQL ('mysql') and SQLite ('sqlite') are supported as database engine for now.
///
/// For more information about PDO, consult the fine manual at <http://php.net/pdo>.
///
class Database {

    use Error;

    ///
    /// Return PDO singleton instance.
    ///
    static public function load()
    {
        global $_NEO;

        if (self::$_singleton === null) {

            switch (strtolower($_NEO['DB']['ENGINE'])) {
                case 'mysql':
                $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s', $_NEO['DB']['HOST'], $_NEO['DB']['PORT'], $_NEO['DB']['NAME']);
                $options = array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND       => 'SET NAMES utf8',
                    \PDO::ATTR_ERRMODE                  => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE       => \PDO::FETCH_ASSOC
                );
                self::$_singleton = new \PDO($dsn, $_NEO['DB']['USER'], $_NEO['DB']['PASS'], $options);
                break;

                case 'sqlite':
                $dsn = sprintf('sqlite:%s', $_NEO['DB']['HOST']);
                $options = array(
                    \PDO::ATTR_ERRMODE                  => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE       => \PDO::FETCH_ASSOC
                );
                self::$_singleton = new \PDO($dsn, null, null, $options);
                break;

                default:
                return self::handle_error_static(sprintf('%s() : Only MySQL ("mysql") and SQLite ("sqlite") database engines supported. You should instead try to instantiate PDO manually. Sorry about that.', __METHOD__));
            }

        }

        return self::$_singleton;
    }

    ///
    /// Destroy PDO singleton instance.
    ///
    static public function destroy()
    {
        self::$_singleton = null;
    }

    ///
    /// PDO singleton instance.
    ///
    static protected $_singleton = null;

}
