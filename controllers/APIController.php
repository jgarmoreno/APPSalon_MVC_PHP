<?php

namespace Controllers;
use Model\Cita;
use Model\Servicio;
use Model\CitaServicio;

// Importante. json_encode convierte un arreglo asociativo a un json, que eso sí puedo leerlo en JS. Arreglo asociativo es equivalente a objeto en JS.
class APIController {
    public static function index() {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }
    public static function guardar() {
        // Almacena la cita y devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita -> guardar();
        $id = $resultado['id'];

        // Almacena la cita y el servicio

        $idServicios = explode(",",$_POST['servicios']); // Separar los servicios. Primero el separador y luego el qué quiero separar. Explode separa en PHP. Split en JS.

        foreach($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio -> guardar();
        }
        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita -> eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}