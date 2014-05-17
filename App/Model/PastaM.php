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

    public function create_paste($title, $content)
    {

      //Generate a unique hash
      $hash = sha1(time().$content);

      //Insert into DB
      $query = $this->db->prepare('INSERT INTO pastes VALUES (:hash, :title, :content, :visibility)');
      $query->bindValue('hash', $hash);
      $query->bindValue('title', $title);
      $query->bindValue('content', $content);
      $query->bindValue('visibility', 0, PDO::PARAM_INT);
      $res = $query->execute();

      if (!empty($res))
      {
        //If it was inserted in DB, we return the hash
        return $hash;
      }
      else
      {
        return null;
      }
    }

}
