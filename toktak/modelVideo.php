<?php

class ModelVideo{
    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_toktak;charset=utf8', 'root', '');
    }

    public function  obtenerVideo($id){
        $query = $this->db->prepare('SELECT * FROM video WHERE id=?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function obtenerVideos(){
        $query = $this->db->prepare('SELECT * FROM video');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}