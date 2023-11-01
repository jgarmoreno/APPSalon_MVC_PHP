<?php
// Al crear el panel de admin. es necesario juntar varias tablas (join) para mostrar una "tabla virtual" con las variables que nos interesa mostrar

namespace Model;

class AdminCita extends ActiveRecord {
    protected static $tabla = 'citasServicios';
    protected static $columnasDB = ['id', 'hora', 'cliente', 'email', 'telefono', 'servicio', 'precio']; // Todas las variables resultado de los joins de las tablas. Cliente es alias

    public $id;
    public $hora;
    public $cliente;
    public $email;
    public $telefono;
    public $servicio;
    public $precio;

    public function __construct()
    {
        $this -> id = $args['id'] ?? null;
        $this -> hora = $args['hora'] ?? '';
        $this -> cliente = $args['cliente'] ?? '';
        $this -> email = $args['email'] ?? '';
        $this -> telefono = $args['telefono'] ?? '';
        $this -> servicio = $args['servicio'] ?? '';
        $this -> precio = $args['precio'] ?? '';
    }
}