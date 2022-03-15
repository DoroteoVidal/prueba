<?php

class ModelValoracion{

    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_teneloya;charset=utf8', 'root', '');
    }

    public function obtenerEmpresas(){
        $query = $this->db->prepare('SELECT * FROM empresa');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function marcarPremiumEmpresa($id){
        $query = $this->db->prepare('UPDATE empresa SET premium=1 WHERE id=?');
        $query->execute([$id]);
    }
}