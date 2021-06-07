<?php
require_once('DatabaseController.php');
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    $app->get("/users/all", function(Request $request, Response $response){
        $sql = "SELECT * FROM users";
        $stm = $this->db->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();
        return $response->withJson(["data" =>$result, "msg"=>"Success"], 200);
    });

    $app->post("/users/store", function(Request $request, Response $response){
        
        $database = new DatabaseController();
        $formData = $request->getParsedBody();
        $result = $database->getData($formData, $this);
        
        return $response->withJson(["data" => $result, "msg"=>"Success"], 200);
    });

    $app->post("/users/register", function(Request $request, Response $response){
        
        $database = new DatabaseController();
        $formData = $request->getParsedBody();
        $result = $database->register($formData, $this);
        
        return $response->withJson(["data" => $result, "msg"=>"Success"], 200);
    });

    $app->post("/users/login", function(Request $request, Response $response){
        
        $database = new DatabaseController();
        $formData = $request->getParsedBody();
        $result = $database->login($formData, $this);
        
        return $response->withJson($result);
    });


    
};
