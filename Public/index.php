<?php 
    include_once __DIR__.'/../Includes/app.php';

    use MVC\Router;
    use Controller\VeterinarioController;

    $router = new Router;

    // Rutas no protegidas
    $router->post('/api',[VeterinarioController::class,'registrar']);
    $router->get('/api/confirmar',[VeterinarioController::class,'confirmar']);
    $router->post('/api/login',[VeterinarioController::class,'autenticar']);

    $router->post('/api/olvide-password',[VeterinarioController::class,'olvidePassword']);
    $router->get('/api/olvide-password',[VeterinarioController::class,'comprobarToken']);
    // $router->post('/api/olvide-password',[VeterinarioController::class,'nuevoPassword']);

    // Ruta protegida con JWT
    $router->get('/api/perfil',[VeterinarioController::class,'perfil']);

    $router->comprobarRutas();

?>