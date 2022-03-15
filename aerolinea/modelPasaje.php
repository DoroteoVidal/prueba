<?php

class ModelPasaje{
    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_aerolineas;charset=utf8', 'root', '');
    }

    public function obtenerPasajes(){
        $query = $this->db->prepare('SELECT * FROM pasajes');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function modelPasaje($fecha_venta, .... $idUsuario, $idVuelo){
        $query = $this->db->prepare('INSERT INTO pasajes (fecha_venta, .... id_usuario, id_vuelo) VALUES (?,?...?,?)');
        $query->execute(array($fecha_venta, .... $idUsuario, $idVuelo));
    }

    public function obtenerPasaje($id){
        $query = $this->db->prepare('SELECT * FROM pasajes WHERE id=?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}