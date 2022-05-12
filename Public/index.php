<?php 
    include_once __DIR__.'/../Includes/app.php';

    use MVC\Router;
    use Controller\VeterinarioController;
    use Model\PacienteController;

    $router = new Router;

    // **               RUTAS DE VETERINARIO              **
    // Rutas no protegidas
    $router->post('/api/veterinarios',[VeterinarioController::class,'registrar']);
    $router->get('/api/veterinarios/confirmar',[VeterinarioController::class,'confirmar']);
    $router->post('/api/veterinarios/login',[VeterinarioController::class,'autenticar']);

    $router->post('/api/veterinarios/olvide-password',[VeterinarioController::class,'olvidePassword']);
    $router->get('/api/veterinarios/establecer-password',[VeterinarioController::class,'comprobarToken']);
    $router->post('/api/veterinarios/nuevo-password',[VeterinarioController::class,'nuevoPassword']);
    $router->post('/api/veterinarios/establecer-password',[VeterinarioController::class,'comprobarToken']);

    // Ruta protegida con JWT
    $router->get('/api/veterinarios/perfil',[VeterinarioController::class,'perfil']);

    // **               RUTAS DE PACIENTE              **
    $router->post('/api/pacientes',[PacienteController::class,'agregarPaciente']);
    $router->get('/api/pacientes',[PacienteController::class,'obtenerPacientes']);

    $router->comprobarRutas();

?>