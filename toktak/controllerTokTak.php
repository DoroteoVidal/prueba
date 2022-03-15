<?php

class ControllerTokTak{
    private $modelVideo;
    private $modelValoracion;
    private $view;
    private $authHelper;

    public function __construct(){
        $this->modelVideo = new ModelVideo();
        $this->modelValoracion = new ModelValoracion();
        $this->view = new View();
        $this->authHelper = new AuthHelper();
    }

    public function agregarValoracion(){
        $this->authHelper->checkLoggedIn();

        if(isset($_POST['valoracion']) && isset($_POST['id_video'])){
            $valoracionN = $_POST['valoracion'];
            $idVideo = $_POST['id_video'];

            $idUsuario = $this->authHelper->obtenerIdUsuario();
            $video = $this->modelVideo->obtenerVideo($idVideo);
            $valoraciones = $this->modelValoracion->obtenerValoracion($idUsuario);

            if($valoracionN >= 1 && $valoracionN <= 5){
                if($valoraciones){
                    foreach ($valoraciones as $valoracion) {
                        if($valoracion->id_video == $idVideo){
                            $this->view->mensaje("ya voto el video");
                            break;
                        }else{
                            if($video){
                                if($vi->id_usuario == $idUsuario){
                                    $this->view->mensaje("no puede votar un video propio");                            
                                }else{
                                    $this->modelValoracion->insertarValoracion($idVideo, $idUsuario, $valoracionN);                              
                                }                                                                        
                            }else{
                                $this->view->mensaje("No existe video");
                            }
                            break;
                        }
                    }  
                }else{
                    $this->view->mensaje("No existe valoraciones");
                }
            }else{
                $this->view->mensaje("El numero ingresado no es valido");
            }          
        }else{
            $this->view->mensaje("Faltan datos");
        }
    }

    public function ocultarVideos(){
        if(!AuthHelper::usuarioAdministrador()){
            $this->view->mensaje("No tiene permiso de administrador");
        }

        if(isset($_POST['valoracion'])){
            $numero = $_POST['valoracion'];

            if($valoracion >= 1 && $valoracion <= 5){
                $videos = $this->modelVideos->obtenerVideos();
                $valoraciones = $this->modelValoraciones->obtenerValoraciones();

                if($videos){
                    foreach ($videos as $video) {
                        if($valoraciones){
                            foreach($valoraciones as $valoracion){
                                if($valoracion->id_video == $video->id){
                                    $promedio = $this->modelValoracion->promediarValores($valoracion->id_video);
                                    if($promedio < $numero){
                                        $this->modelVideo->ocultarVideoDB($video->id);
                                        $this->view->mensaje("El video con id: $id ha sido ocultado");
                                    }else{
                                        $this->view->mensaje("No hay videos con promedio menor al numero ingresado");
                                    }
                                }
                            }
                        }else{
                            $this->view->mensaje("no hay valoraciones");
                        }                     
                    }
                }else{
                    $this->view->mensaje("no hay videos");
                }               
            }else{
                $this->view->mensaje("numero incorrecto");
            }
        }else{
            $this->view->mensaje("faltan datos");
        }
    }

    public function resumen($params = null){
        $id = $params[':ID'];
        $video = $this->modelVideo->obtenerVideo($id);
        $valoraciones = $this->modelValoraciones->obtenerValoracionesPorIdVideo($id);

        if($video){
            if($valoraciones){
                $this->view->generarTabla($valoraciones);
            }else{
                $this->view->mensaje("El video con id: $id no tiene valoraciones");
            }
        }else{
            $this->view->mensaje("El video con id: $id no existe");
        }
        
    }
}

////API REST

4)a- Se debe crear un nuevo controller, una nueva vista, un router para las direcciones api y modificar el .htaccess
b-
1- ("videos", "GET", "ApiController", "obtenerVideos");
2- ("videos/:ID", "PUT", "ApiController", "editarVideo");
3- ("videos/:ID", "POST", "ApiController", "agregarVideo");
4- ("videos/:ID", "DELETE", "ApiController", "eliminarVideo");
5- ("videos/:ID", "GET", "ApiController", "obtenerValoracionesVideo");