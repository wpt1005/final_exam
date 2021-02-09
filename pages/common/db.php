<?php
function connectDB():PDO {
	// データベース接続情報文字列
	$dns = "mysql:host=localhost;dbname=productdb;port=3306;charset=utf8";
	$user = "productdb_admin";
	$password = "admin123";
	// データベースに接続：失敗した場合はPDOExceptionが投げられる
	try {
		$pdo = new PDO($dns, $user, $password);
		return $pdo;
	} catch (PDOException $e) {
		die($e->getMessage());
	}
}