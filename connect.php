<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

class DataBase {
	
	private static $db = null;
	private $msqli;
	
	public static function getDb() {
		if (self::$db == null) {
			self::$db = new DataBase();
		}
		return self::$db;
	}
	
	private function __construct() {
		$this->msqli = mysqli_connect('localhost', 'root', '', 'Texode');
	}
	
	public function __destruct() {
		if ($this->msqli) {
			$this->msqli->close();
		}
	}
	
	
	
	public function insertPost($postArr, $avatar_path) {
		
		if ($_SESSION[errorServer] != '') {
			return false;
		}
		
		$date = date("Y-m-d H:i:s");
		extract($postArr);
		$null = null;
		$stmt = $this->msqli->prepare("INSERT INTO `feedback` (`user_name`, `user_email`, `user_text`, `user_foto`, `user_date`, `user_id`) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('sssssb', $name, $email, $textarea, $avatar_path, $date, $null);
		$stmt->execute();
	}
	
	
	
	public function selectAuth($login) {
		$stmt = $this->msqli->prepare("SELECT * FROM `users` WHERE user_login=?");
		$stmt->bind_param("s", $login);
		$stmt->execute(); 
		$stmt->bind_result($user_id, $user_login, $user_password); 
		$stmt->fetch();
		return($user_password);
	}
	
	public function deletePost($numdel) {
		$stmt = $this->msqli->prepare("DELETE FROM `feedback` WHERE `user_id` =?");
		$stmt->bind_param('i', $numdel);
		$stmt->execute();
		

	}
	
	public function sortPost($sort, $access) {
		$query = mysqli_query($this->msqli, "SELECT * FROM `feedback` $sort");
		while($row=mysqli_fetch_array($query)) {
			 if ($access) {
			 $delete_num = $row[user_id];
			 $delete = "<a href=\"?delete=$delete_num\">Удалить</a>";
			 }
			generatePost ($row[user_foto], $row[user_name], $row[user_text], $row[user_email], $row[user_date], $delete);
			}
	}
}


?>