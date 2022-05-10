<?php 
    include_once __DIR__.'/../Includes/app.php';

    use MVC\Router;
    use Controller\VeterinarioController;

    $router = new Router;

    // Rutas no protejidas, no se requieren de login
    $router->post('/api',[VeterinarioController::class,'registrar']);
    $router->get('/api/confirmar',[VeterinarioController::class,'confirmar']);
    $router->post('/api/login',[VeterinarioController::class,'autenticar']);

    $router->get('/api/perfil',[VeterinarioController::class,'perfil']);

    $router->comprobarRutas();

?>