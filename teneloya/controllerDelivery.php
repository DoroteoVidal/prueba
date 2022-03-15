<?php

class ControllerDelivery{
    private $view;
    private $authHelper;
    private $modelValoracion;
    private $modelPedido;

    public function __construct(){
        $this->view = new View();
        $this->authHelper = new AuthHelper();
        $this->modelValoracion = new ModelValoracion();
        $this->modelPedido = new ModelPedido();
        $this->modelEmpresa = new ModelEmpresa();
    }

    public function resenaEmpresa(){
        $this->authHelper->checkLoggedIn();

        if(isset($_POST['id_empresa']) && isset($_POST['valoracion']) && isset([$_POST['resena']) && isset($_POST['inadecuada'])){
            $idEmpresa = $_POST['id_empresa'];
            $valoracion = $_POST['valoracion'];
            $resena = $_POST['resena'];
            $inadecuada = $_POST['inadecuada'];

            if($valoracion >= 1 && $valoracion <=5){
                $idUsuario = $this->authHelper->obtenerIdUsuarioSession();

                $verificacion = $this->modelValoracion->verificarValoracion($idUsuario);
                $pedido = $this->modelPedido->verificarPedido($idUsuario);

                if($verificacion){
                    foreach ($verificacion as $verf) {
                        if($verf->id_empresa == $idEmpresa){
                            $this->view->mensaje("El usuario ya valoro empresa");
                            break;
                        }else{
                            if($pedido){
                                foreach ($pedido as $ped) {
                                    if($ped->id_empresa == $idEmpresa){
                                        $this->modelValoracion->agregarValoracion($idEmpresa, $idUsuario, $valoracion, $resena, $inadecuada);
                                        break;
                                    }else{
                                        $this->view->mensaje("El usuario no hizo pedido");
                                        break;
                                    }
                                }
                            }
                            break;
                        } 
                    }    
                }
            }else{
                $this->view->mensaje("valor incorrecto");
            }   
        }else{
            $this->view->mensaje("Faltan datos");
        }
    }

    public function marcarPremium(){
        if(!AuthHelper::usuarioAdministrador()){
            $this->view->mensaje("No tiene permisos de administrador");
        }

        if (isset($_POST['valoracion'])){
            $valoracion = $_POST['valoracion'];

            if($valoracion >= 1 && $valoracion <=5){
                $empresas = $this->modelEmpresa->obtenerEmpresas();
                $valoraciones = $this->modelValoracion->obtenerValoraciones();

                foreach ($empresas as $emp) {
                    foreach ($valoraciones as $val) {
                        if($emp->id == $val->id_empresa){
                            $promedio = $this->modelValoracion->promediarValores($val->id_empresa);
                            if($promedio > $valoracion){
                                $this->modelEmpresa->marcarPremiumEmpresa($emp->id);
                                $this->view->mensaje("La empresa con id: $id ha sido marcada como premium");
                                break;
                            }else{
                                $this->view->mensaje("no hay empresas con promedio mayor al numero ingresado");
                                break;
                            }
                        }
                        
                    }
                }
            }else{
                $this->view->mensaje("valor incorrecto");
            }   
        }else{
            $this->view->mensaje("Faltan datos");
        }
    }

    public function tablaResena(){

        if(!AuthHelper::usuarioAdministrador()){
            $this->view->mensaje("No tiene permiso de administrador");
        }
        $resenas = $this->modelValoracion->obtenerValoraciones();
        $usuarios = $this->modelUsuario->obtenerUsuarios();

        $this->view->mostrarTabla($resenas, $usuarios);
    }
}

///API REST

4)a- para agregar una api rest a la aplicacion, se debe crear un nuevo controlador, un nuevo router, modificar el .htaccess y crear una vista donde va a recibir un json.

b-
1- ("resenas/:ID", "GET", "ResenasController", "verResenasPorEmpresa");
2- ("resenas/:ID", "PUT", "ResenasController", "editarResena");
3- ("resenas/:ID", "POST", "ResenasController", "agregarResena");
4- ("resenas/:ID", "DELETE", "ResenasController", "eliminarResena");