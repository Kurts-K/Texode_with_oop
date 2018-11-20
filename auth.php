<?php
header('Content-Type: text/html; charset=utf-8');
header ('Location: index.php');
session_start();
require_once "connect.php";

class Auth {
	
	public $login;
	public $password;
	public $finite_password;
	
	function __construct($login, $password) {
		$this->login = $login;
		$this->password = $password;
	}
	
	function screening($login, $password) {
		$login = trim(htmlspecialchars(stripslashes($login)));
		$password = trim(htmlspecialchars(stripslashes($password)));
	}
	
	function finitePassword($password) {
		$this->finite_password = password_hash($password, PASSWORD_DEFAULT);
	}
	
	function passwordVerify($password, $passDb) {
		if (password_verify ($password, $passDb)) {
		$_SESSION[user_login] = $this->login;
		}
	}
}

$Auth = new Auth($_POST['login'], $_POST['password']);
$Auth->screening($Auth->login, $Auth->password);
$Auth->finitePassword($Auth->password);
$authDb = DataBase::getDb();

$passDb = $authDb->selectAuth($Auth->login);//возвращает pwd
$Auth->passwordVerify($Auth->password, $passDb);







?>