<?php

class ResenasController{
    public function verResenasPorEmpresa($params = null){
        $this->authHelper->checkLoggedIn();
        $id = $params[':ID'];

        $resenas = $this->modelValoracion->obtenerValoracionesDeEmpresa($id);
        if($resenas){
            $this->apiView->response($resenas, 200);
        }else{
            $this->apiView->response("No existen valoraciones para esta empresa", 404);
        }     
    }

    public function editarResena($params = null){
        $this->authHelper->checkLoggedIn();
        $id = $params[':ID'];
        $idUsuario = $this->authHelper->obtenerIdUsuario();
        $resena = $this->modelValoracion->obtenerResena($id);

        if($resena){
            if($resena->id_usuario == $idUsuario){
                $body = $this->getBody();

                if(isset($body->id_empresa) && isset($body->valoracion) && isset($body->resena) && isset($body->inadecuada)){
                $this->modelValoracion->modificarResena($body->id_empresa, $idUsuario, $body->valoracion, $body->resena, $body->inadecuada);
                $this->apiView->response("La resena fue modificada con exito", 200);
                }else{
                    $this->apiView->response("Faltan datos", 404);
                }
            }else{
                $this->apiView->response("Esta resena no fue hecha por usted", 404);
            }               
        }else{
            $this->apiView->response("No existe la resena con id: $id", 404);
        }     
    }

    private function getBody(){
        $bodyString = file_get_contents("php://input");
        return json_decode($bodyString);
    }
}