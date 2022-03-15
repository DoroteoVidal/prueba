<?php

class ModelValoracion{
    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_toktak;charset=utf8', 'root', '');
    }

    public function obtenerValoracion($id){
        $query = $this->db->prepare('SELECT * FROM valoraciones WHERE id_usuario=?');
        $query->execute([$id]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertarValoracion($idVideo, $idUsuario, $valoracionN){
        $query = $this->db->prepare('INSERT INTO valoraciones (id_video, id_usuario, valoracion) VALUES (?, ?, ?)');
        $query->execute(array($idVideo, $idUsuario, $valoracionN));
    }

    public function obtenerValoraciones(){
        $query = $this->db->prepare('SELECT * FROM valoraciones');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function promediarValores($id){
        $query = $this->db->prepare('SELECT AVG(valoracion) FROM valoraciones WHERE id_video=?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function obtenerValoracionesPorIdVideo($id){
        $query = $this->db->prepare('SELECT * FROM valoraciones WHERE id_video=?');
        $query->execute([$id]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}