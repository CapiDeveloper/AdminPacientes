<?php

namespace Model;

class PacienteController{
    public static function agregarPaciente(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            debuguear('Agregando Pacientes...');
        }
    }
    public static function obtenerPacientes(){
        echo 'Mostrando pacientes';
    }
}