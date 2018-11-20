<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
//header ('Location: index.php');
require_once "connect.php";

class Extractor {
	
	public $postArr = [];
	public $filesArr = [];
	public $avatar_path;
	
	function csrf() {
		if (!isset($_SESSION['csrf_token'])) {
			$_SESSION['csrf_token'] = bin2hex(md5(uniqid()));
		}
			$token = $_SESSION['csrf_token'];
		
		echo $token;
	}
	
	public function PostInit($post) {
		foreach ($post as $key => $value) {
		$this->postArr["$key"] = trim(htmlspecialchars(stripslashes($value)));
		}
	}
	
	public function FilesInit($files) {
		foreach ($files as $nameForm => $arr) {
		foreach ($arr as $inner_key => $val) {
			$this->filesArr[$nameForm . '_' . $inner_key] = $val;
			}
		}	
	}
	
	public function ServValid($postArr) {
		extract($postArr);
		$_SESSION[errorServer] = '';
		$_SESSION[errorServer] .= (iconv_strlen($name) > 50) ? 'Имя не длиннее 50 символов' . "<br>" : '';
		$_SESSION[errorServer] .= (iconv_strlen($name) == 0) ? 'Имя не заполнено' . "<br>" : '';
		$_SESSION[errorServer] .= (iconv_strlen($textarea) > 200) ? 'Сообщение не длиннее 200 символов' . "<br>" : '';
		$_SESSION[errorServer] .= (iconv_strlen($textarea) == 0) ? 'Сообщение не заполнено' . "<br>" : '';
		$_SESSION[errorServer] .= ( preg_match("/[0-9a-z]+@[a-z]/", $email) == 0  ) ? 'Формат ввода email не верен!' . "<br>" : '';
		
		
		
	}
	
	
	function removeFiles($postArr, $filesArr) {
		extract($postArr);
		extract($filesArr);
		if (strlen($foto_name) == 0) {
		$this->avatar_path = 'avatars/noavatar.png';
		} else {
		$foto_name = explode(".", $foto_name);
		$extension = $foto_name[1];
		$this->avatar_path = 'avatars/' . $email . "." . $extension;
		move_uploaded_file($foto_tmp_name, $this->avatar_path);
		}
	}
	
	
}


$extract1 = new Extractor();//создается объект
$extract1->csrf();
$extract1->PostInit($_POST);//инициализируются переменные post
$extract1->FilesInit($_FILES);//инициализируются переменные files
$extract1->removeFiles($extract1->postArr, $extract1->filesArr);

$db = DataBase::getDb();
$extract1->ServValid($extract1->postArr);
$db->insertPost($extract1->postArr, $extract1->avatar_path);



 
?>

