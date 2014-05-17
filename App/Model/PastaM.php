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
            return null;
        }
        return $res;
    }

    ///
    /// Add a paste to the database and return the hash.
    ///
    public function create_paste($title, $content)
    {
        $sql = 'INSERT INTO pastes (hash, title, content, visibility) VALUES (:hash, :title, :content, :visibility)';

        // generate a hash
        $hash = sha1(time() . $content);

        // insert into db
        $query = $this->db->prepare($sql);
        $query->bindValue('hash', $hash);
        $query->bindValue('title', $title);
        $query->bindValue('content', $content);
        $query->bindValue('visibility', 0, PDO::PARAM_INT);
        if ($query->execute() === false) {
            return false;
        }
        return $hash;
    }

}
