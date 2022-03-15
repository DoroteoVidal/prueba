<?php

class ModelValoracion{

    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_teneloya;charset=utf8', 'root', '');
    }

    public function verificarValoracion($id){
        $query = $this->db->prepare('SELECT * FROM valoracion WHERE id_usuario=?');
        $query->execute([$id]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function agregarValoracion($idEmpresa, $idUsuario, $valoracion, $resena, $inadecuada){
        $query = $this->db->prepare('INSERT INTO valoracion () VALUES ()');
        $query->execute(array($idEmpresa, $idUsuario, $valoracion, $resena, $inadecuada));
    }

    public function obtenerValoraciones(){
        $query = $this->db->prepare('SELECT * FROM valoracion');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function promediarValores($id){
        $query = $this->db->prepare('SELECT AVG(valoracion) FROM valoracion WHERE id_empresa=?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}