<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    //$this->logger->info("Slim-Skeleton '/' route");

    $post = new Post($this->db);
    $posts = $post->test();

    $vars = compact('posts');

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $vars);
});

$app->get('/records', function (Request $request, Response $response, array $args) {

	$table = $this->db->table('mesaj');

    $posts = $table->get();

    return $response->withJson($posts);
});

$app->post('/login', function (Request $request, Response $response, array $args) {
	$body = $request->getParsedBody();
	$login = new App\Login();
	$result = $login->check($body, $this->db->table('ogrenci'));
	
	return $response->withJson($result);
});

$app->get('/sifreler', function (Request $request, Response $response, array $args) {

	$table = $this->db->table('ogrenci');

    $posts = $table->get();

    return $response->withJson($posts);
});

$app->get('/token', function (Request $request, Response $response, array $args) {

	$login = new App\Login();
	$result = $login->getToken();
	
	return $response->withJson($result);
});

$app->get('/logout', function (Request $request, Response $response, array $args) {

	$login = new App\Login();
	$result = $login->logout();
	
	return $response->withJson($result);
});