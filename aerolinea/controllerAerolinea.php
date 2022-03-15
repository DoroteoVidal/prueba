<?php

class AerolineaController{
    private $view;
    private $modelPasaje;
    private $modelVuelo;
    private $authHelper;

    public function __construct(){
        $this->view = new view();
        $this->modelPasaje = new ModelPasaje();
        $this->modelVuelo = new ModelVuelo();
        $this->authHelper = new AuthHelper();
    }

    public function borrarVueloClase(){

        $this->authHelper->checkLoggedIn();

        $vuelos = $this->modelVuelo->obtenerVuelos();
        $pasajes = $this->modelPasaje->obtenerPasajes();

        if($vuelos){
            foreach ($vuelos as $vuelo){
                if($pasajes){
                    foreach ($pasajes as $pasaje){
                        if($vuelo->id == $pasaje->id_vuelo){
                            if($pasaje->clase != 1){
                                $this->modelVuelo->borrarVuelo($vuelo->id);
                            }else{
                                $this->view->mensaje("Todos los pasajeros tienen primera clase");
                            }
                        }else{
                            $this->view->mensaje("Este vuelo no tiene pasajes aun");                
                        }
                    }
                }else{
                    $this->view->mensaje("No hay pasajes");
                } 
            }
        }else{
            $this->view->mensaje("No hay vuelos");
        }
    }

    public function compraPasaje(){
        $this->authHelper->checkLoggedIn();
        $idUsuario = $this->authHelper->obtenerIdUsuarioSession();

        if(isset($_POST['fecha_venta'])....... isset($_POST['id_vuelo']){
            $fecha_venta = $_POST['fecha_venta'];
            ...
            $idVuelo = $_POST['id_vuelo'];

            $vuelo = $this->modelVuelo->obtenerVuelo($idVuelo);
            if($vuelo){
                if($vuelo->fecha < FECHA_ACTUAL){
                    $this->modelPasaje($fecha_venta, .... $idUsuario, $idVuelo);
                }else{
                    $this->view->mensaje("No puede comprar pasaje para este vuelo");
                }
            }else{
                $this->view->mensaje("Este vuelo no existe");
            }          
        }else{
            $this->view->mensaje("Faltan datos");
        }
    }

    public function cancelarPasaje($id){
        $this->authHelper->checkLoggedIn();

        $pasaje = $this->modelPasaje->obtenerPasaje($id); //traigo el arreglo con ese id

        if($pasaje){
            if($pasaje->fecha_venta < 15_DIAS_ANTICIPACION){
                $this->view->mensaje("No puede cancelar el pasaje");                
            }else{
                $this->modelVuelo->eliminarPasaje($pasaje->id_vuelo);
            }
        }else{
            $this->view->mensaje("El pasaje con id: $id no existe");
        }
    }
}