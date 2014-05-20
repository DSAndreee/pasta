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
    public function create_paste($content, $syntax)
    {
        $sql = 'INSERT INTO pastes (hash, content, visibility, syntax) VALUES (:hash, :content, :visibility, :syntax)';

        // generate a hash
        $hash = sha1(time() . $content);

        // insert into db
        $query = $this->db->prepare($sql);
        $query->bindValue('hash', $hash);
        $query->bindValue('content', $content);
        $query->bindValue('visibility', 0, PDO::PARAM_INT);
        $query->bindValue('syntax', $syntax);
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
