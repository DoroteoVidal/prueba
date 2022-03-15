<?php

class ModelPedido{

    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_teneloya;charset=utf8', 'root', '');
    }

    public function verificarPedido($id){
        $query = $this->db->prepare('SELECT * FROM pedido WHERE id_usuario=?');
        $query->execute([$id]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}