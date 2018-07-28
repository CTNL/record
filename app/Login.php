<?php

namespace App;

use Illuminate\Database\Query\Builder;

class Login {

	public function check($post, Builder $studentDB)
	{
		//$studentId = preg_replace('~\D~', '', $post['username']);
		$username = $post['username'];

		$this->checkBanned($username);

		$correct = $studentDB
			->where([
				'id'	=>$username, 
				'ksifre'=>$post['password']
			])
			->count();

		if (!$correct) {
			$this->error('error');
		}

		$_SESSION['id'] = $username;

		$result = [
			'result' => 'success',
			'token' => session_id(),
			'id' => $username
		];
		return $result;
	}

	public function checkWriter($post, Builder $studentDB)
	{
		//$studentId = preg_replace('~\D~', '', $post['username']);
		$username = $post['username'];

		$this->checkBanned($username);

		$correct = $studentDB
			->where([
				'id'	=>$username, 
				'zsifre'=>$post['password']
			])
			->count();

		if (!$correct) {
			$this->error('error');
		}

		$result = [
			'result' => 'success'
		];
		return $result;
	}

	public function verify($post){
		//$studentId = preg_replace('~\D~', '', $post['username']);
		$username = $post['username'];

		if(
			$post['token'] === session_id() &&
		    $username === $_SESSION['id']
		)
			return true;
		else
			return false;
	}

	static public function getToken(){
		if(@$_SESSION['id'])
			return ['result'=>'success', 'id' => $_SESSION['id'], 'token' => session_id()];
		else
			return false;
	}

	public function logout(){
		session_destroy();
	}

	private function error($error) {
		$this->recordError();
		die(json_encode(['result' => $error]));
	}

	private function recordError(){
		// Record error
		# TODO
	}

	private function checkBanned(){
		// Check banned
		# TODO
	}
}