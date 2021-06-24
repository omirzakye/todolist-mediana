<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);


//gets list of all users
$app->get('/users', function (Request $request, Response $response){
    $sql = "SELECT * FROM users";

    try{
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->query($sql);
        $list = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;
        $response->getBody()->write(json_encode($list));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    }catch(PDOException $e){
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

//gets tasks for specific users
$app->get('/users/{id}', function (Request $request, Response $response, $args){
    $id = $args['id'];
    $sql = "SELECT * FROM tasks WHERE user_id = $id";

    try{
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->query($sql);
        $list = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;
        $response->getBody()->write(json_encode($list));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    }catch(PDOException $e){
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});


//adding tasks for specific users
$app->post('/users/{id}/add', function (Request $request, Response $response, array $args){
    $id = $args['id'];
    $task = $request->getParam('task');
    $tdesc = $request->getParam('task_description');
    $sql = "INSERT INTO tasks (task, task_description, user_id) VALUE (:task, :task_description, $id)";

    try{
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':task', $task);
        $stmt->bindParam(':task_description', $tdesc);
        
        $result = $stmt->execute();

        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    }catch(PDOException $e){
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});


//deleting tasks
$app->delete('/users/{id}/{tid}/delete', function (Request $request, Response $response, array $args){
    $id = $args['id'];
    $tid = $args['tid'];

    $sql = "DELETE FROM tasks WHERE task_id = $tid AND user_id = $id";

    try{
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();

        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    }catch(PDOException $e){
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});


//updating tasks
$app->put('/users/{id}/{tid}/update', function (Request $request, Response $response, array $args){
    $id = $args['id'];
    $tid = $args['tid'];
    $task = $request->getParam('task');
    $tdesc = $request->getParam('task_description');
    $sql = "UPDATE tasks Set task = :task, task_description = :tdesc WHERE task_id = $tid";

    try{
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':task', $task);
        $stmt->bindParam(':task_description', $tdesc);
        
        $result = $stmt->execute();

        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    }catch(PDOException $e){
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});