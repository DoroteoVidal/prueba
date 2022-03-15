<?php

class ApiController{

    private $modelVideo;
    private $authHelper;
    private $apiView;

    public function __construct(){
        $this->modelVideo = new ModelVideo();
        $this->authHelper = new AuthHelper();
        $this->apiView = new ApiView();
    }

    public function editarVideo($params = null){
        $this->authHelper->checkLoggedIn();
        $id = $params[':ID'];
        $video = $this->modelVideo->obtenerVideo($id);

        if($video){
            $body = $this->getBody();
            if(isset($body->titulo)){
                $this->modelVideo->modificarTituloVideo($body->titulo);
                $this->apiView->response("Titulo modificado con exito", 200);
            }else{
                $this->apiView->response("No ingreso titulo", 404);
            }
        }else{
            $this->apiView->response("El video con id: $id no existe", 404);
        }
    }

    private function getBody(){
        $bodyString = file_get_contents("php://input");
        return json_decode($bodyString);
    }

    public function obtenerValoracionesVideo($params = null){
        if(!AuthHelper::usuarioAdministrador()){
            $this->apiView->response("No tiene permisos de administrador", 404);
        }
        $id = $params[':ID'];
        $video = $this->modelVideo->obtenerVideo($id);
        $valoraciones = $this->modelValoracion->obtenerValoracionesDeVideo($id);

        if($video){
            if($valoraciones){
                $this->apiView->response($valoraciones, 200);
            }else{
                $this->apiView->response("No existen valoraciones para el video con id: $id", 404);
            }
        }else{
            $this->apiView->response("El video con id: $id no existe", 404);
        }
    }
}