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
/// Counter allows you to keep track of the number of visitors per day on your web site.
///
class Counter {

    ///
    /// Create the neo_counter table in database.
    ///
    static public function init()
    {
        $db = Database::load();
        $sql = 'CREATE TABLE IF NOT EXISTS neo_counter (visited varchar(50) NOT NULL, PRIMARY KEY (`visited`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

        if ($db->exec($sql) === false) {
            return $this->handle_error(sprintf('%s(): Failed to execute SQL query.', __METHOD__));
        }
        return new static;
    }

    ///
    /// Add current visitor to neo_counter table.
    ///
    static public function add()
    {
        $db = Database::load();
        $sql = 'INSERT IGNORE INTO neo_counter VALUES (?)';
        $data = array($_SERVER['REMOTE_ADDR'] . '@' . date('Y-m-d'));

        if ($ste = $db->prepare($sql)) {
            if ($ste->execute($data)) {
                return new static;
            }
            return $this->handle_error(sprintf('%s(): Failed to execute prepared SQL query.', __METHOD__));
        }
        return $this->handle_error(sprintf('%s(): Failed to prepare SQL query.', __METHOD__));
    }

    ///
    /// Return current number of visitors from neo_counter table.
    ///
    static public function count()
    {
        $db = Database::load();
        $sql = 'SELECT COUNT(*) AS i FROM neo_counter';

        if ($ste = $db->query($sql)) {
            if (($result = $ste->fetch()) !== false) {
                return (int)$result['i'];
            }
            return $this->handle_error(sprintf('%s(): Failed to fetch data.', __METHOD__));
        }
        return $this->handle_error(sprintf('%s(): Failed to execute SQL query.', __METHOD__));
    }

}
