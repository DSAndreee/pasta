<?php
class PastaM extends Neo\Model {

    public function get_paste($hash)
    {
        $query = $this->db->prepare('SELECT * FROM pastes WHERE hash = :hash');
        $query->bindValue('hash', $hash);
        $query->execute();
        $res = $query->fetch();

        if (!empty($res))
        {
            return $res;            
        }
        else
        {
            return null;
        }
    }

}

