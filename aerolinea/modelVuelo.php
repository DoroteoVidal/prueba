<?php

class ModelVuelo{
    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_aerolineas;charset=utf8', 'root', '');
    }

    public function modificarFechaVuelo($fecha, $id){
        $query = $this->db->prepare('UPDATE vuelos SET fecha=? WHERE id=? ');
        $query->execute([$fecha, $id]);
    }

    public function obtenerVuelos(){
        $query = $this->db->prepare('SELECT * FROM vuelos');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function borrarVuelo($id){
        $query = $this->db->prepare('DELETE FROM vuelos WHERE id=?');
        $query->execute([$id]);
    }

    public function obtenerVuelo($id){
        $query = $this->db->prepare('SELECT * FROM vuelos WHERE id=?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function eliminarPasaje($id){
        $query = $this->db->prepare('DELETE FROM vuelos WHERE id=?');
        $query->execute([$id]);
    }
}