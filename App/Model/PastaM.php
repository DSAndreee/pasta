<?php
class PastaM extends Neo\Model {

    ///
    /// Retrieve a paste by its hash.
    ///
    public function get_paste($hash)
    {
        $sql = 'SELECT * FROM pastes WHERE hash = :hash';
        $query = $this->db->prepare($sql);
        $query->bindValue('hash', $hash);
        $query->execute();
        $res = $query->fetch();

        if (empty($res)) {
            return;
        }
        return $res;
    }

    ///
    /// Add a paste to the database and return the hash.
    ///
    public function create_paste($content, $syntax, $expire)
    {
        $date = new DateTime('now');
        switch ($expire) {
            case 'open':
                $date = new DateTime('1970-01-01');
                break;
            case '1hour':
                $date->modify('+1 hour');
                break;
            case '1day':
                $date->modify('+1 day');
                break;
            case '1week':
                $date->modify('+1 week');
                break;
            case '1month':
                $date->modify('+1 month');
                break;
            case '1year':
                $date->modify('+1 year');
                break;
            case 'never':
                $date = new DateTime('9999-12-31');
                break;
        }
        $sql = 'INSERT INTO pastes (hash, content, visibility, syntax) VALUES (:hash, :content, :visibility, :syntax, :expiration)';

        // generate a hash
        $hash = sha1(time() . $content);

        //expiration date
        $expiration_date = $date->format('Y-m-d H:i:sP');

        // insert into db
        $query = $this->db->prepare($sql);
        $query->bindValue('hash', $hash);
        $query->bindValue('content', $content);
        $query->bindValue('visibility', 0, PDO::PARAM_INT);
        $query->bindValue('syntax', $syntax);
        $query->bindValue('expiration', $expiration_date);
        if ($query->execute() === false) {
            return;
        }
        return $hash;
    }

    ///
    /// Destroy paste by id or hash.
    ///
    public function destroy_paste($id_or_hash)
    {
        $sql = 'DELETE FROM pastes WHERE ' . (is_int($id_or_hash) ? 'id' : 'hash') . '=?';
        $data = array($id_or_hash);
        $query = $this->db->prepare($sql);
        return $query->execute($data);
    }

}
