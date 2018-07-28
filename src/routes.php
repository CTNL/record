<?php

use Slim\Http\Request;
use Slim\Http\Response;

use App\Models\Record;
use App\Login;

// Routes

$app->get('/test', function (){
	return "TEST";
});

$app->post('/login', function (Request $request, Response $response, array $args) {
	$body = $request->getParsedBody();
	$login = new App\Login();
	$result = $login->check($body, $this->db->table('ogrenci'));
	
	return $response->withJson($result);
});

$app->post('/write', function (Request $request, Response $response, array $args) {
	$record = $request->getParsedBody();
	
	$login = new App\Login();
	$check = $login->checkWriter($record, $this->db->table('ogrenci'));
	if($check['result'] !== "success") 
		return $response->withJson($check, 401);

	$ip = ip2long($request->getAttribute('ip_address'));
        
	if( strlen(trim($record['name'])) < 3 or 
			strlen(trim($record['text'])) < 3)
	{
		return $response->withJson(['result'=>'error'],401);
	}

	$text = trim(preg_replace('/\s+/', ' ', $record['text']));

	$data = Record::create([
		'sid' => $record['username'],
		'name' => $record['name'],
		'text' => $text,
		'ip' => $ip
	]);

  $result = ['result'=>'success', 'data'=>$data];
	
	return $response->withJson($result);
});

/*
$app->get('/sifreler', function (Request $request, Response $response, array $args) {

	$table = $this->db->table('ogrenci');

    $posts = $table->get();

    return $response->withJson($posts);
});
*/
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


$app->group('/record', function () use ($app){

    $app->get('/all', function ($request, $response) {
    	$token = $request->getAttribute('token');
			$sid = $token['id']; // Studentid

    	$data = Record::where(['sid'=>$sid, 'deleted'=>0])->get();

    	$result = ['result'=>'success', 'data'=>$data];
        return $this->response->withJson($result, 200);
    });

    /*
    $app->get('/[{id}]', function($request, $response, $args){
        $data = Record::find($args['id']);
        return $this->response->withJson($data, 200);
    });
    */

	// ADD a new record
    $app->post('/', function ($request, $response) {
    	
        $record = $request->getParsedBody();

        $ip = ip2long($request->getAttribute('ip_address'));

        $token = $request->getAttribute('token');
		$sid = $token['id']; // Studentid
        
		if( strlen(trim($record['name'])) < 3 or 
			strlen(trim($record['text'])) < 3)
		{
			return $response->withJson(['result'=>'error'],401);
		}

        $data = Record::create([
	        'sid' => $sid,
	        'name' => $record['name'],
	        'text' => $record['text'],
	        'ip' => $ip
	    ]);
	    $data['active'] = 0;

        $result = ['result'=>'success', 'data'=>$data];
        return $this->response->withJson($result, 200);
    });

    // UPDATE a record
    $app->put('/[{id}]', function ($request, $response, $args) {

        $record = $request->getParsedBody();

        $token = $request->getAttribute('token');
		$sid = $token['id']; // Studentid

		$old_record = Record::find($args['id']);

		if(!$old_record) return $response->withJson(['result'=>'error'], 404);

		if($old_record['sid'] != $sid ) return $response->withJson(['result'=>'error'], 401);

		if(isset($record['active'])){
			$done = $old_record->update([
		        'active' => $record['active']
		    ]);
		} else {
			$done = $old_record->update([
		        'name' => $record['name'],
		        'text' => $record['text'],
		    ]);
		}

		if(!$done) return $response->withJson(['result'=>'error'], 403);

		$result = ['result'=>'success', 'data'=>$old_record];

        return $this->response->withJson($result, 200);
    });

    $app->delete('/[{id}]', function ($request, $response, $args) {
        // DELETE a record
        $token = $request->getAttribute('token');
		$sid = $token['id']; // Studentid

		$old_record = Record::find($args['id']);

		if(!$old_record) return $response->withJson(['result'=>'error'], 404);

		if($old_record['sid'] != $sid ) return $response->withJson(['result'=>'error'],401);

        $done = $old_record->update([
	        'deleted' => 1
	    ]);

	    $result = ['result'=>'success'];

        return $this->response->withJson($result, 200);
    });

	/*    
	$app->post('/activate/[{id}]', function ($request, $response, $args) {
        // ACTIVATE of a record
        $record = $request->getParsedBody();

        $token = $request->getAttribute('token');
		$sid = $token['id']; // Studentid

		$old_record = Record::find($args['id']);

		if(!$old_record) return $response->withJson(['result'=>'error'], 404);

		if($old_record['sid'] !== $sid ) return $response->withJson(['result'=>'error'],401);

        $data = $old_record->update([
	        'active' => $record['active'] ? 1 : 0,
	    ]);

        return $this->response->withJson($data, 200);
    });
    */

})->add(function ($request, $response, $next) {
	$token = Login::getToken();

	if(!$token) return $response->withJson(['result'=>'error'],401);

	$request = $request->withAttribute('token', $token);

	$response = $next($request, $response);

	return $response;
});