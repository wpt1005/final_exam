<?php
// 外部ファイルの読み込み
require_once "./common/db.php";
require_once "./common/Product.php";
?>
<?php
// リクエストパラメータを取得
isset($_REQUEST["action"]) ? $action = $_REQUEST["action"] : $action = "";
// セッションからデータを取得
session_start();
$product = $_SESSION["product"];

// データベース接続オブジェクトを取得
$pdo = connectDB();
try {
	if ($action === "entry" or $action === "update") {
		// SQLとプレースホルダに設定するパラメータの連想配列を設定
		$params = [];
		if ($action === "entry") {
			$sql = "insert into product (name, price, category, detail) values (:name, :price, :category, :detail)";
		} else {
			$sql = "update product set name = :name, price = :price, category = :category, detail = :detail where id = :id";
			$params["id"] = $product->getId();
		}
		$params[":name"] = $product->getName();
		$params[":price"] = $product->getPrice();
		$params[":category"] = $product->getCategory();
		$params[":detail"] = $product->getDetail();
		// SQL実行オブジェクトを取得
		$pstmt = $pdo->prepare($sql);
		// SQLを実行
		$pstmt->execute($params);
	}
} catch (PDOException $e) {
	die($e->getMessage());
} finally {
	unset($pdo);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>商品データベース</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
<header>
	<h1>商品データベース</h1>
</header>
<main id="complete">
	<h2>商品の完了</h2>
	<p>処理を完了しました。</p>
	<p><a href="top.php">トップページに戻る</a></p>
</main>
<footer>
	<div id="copyright">&copy; 2021 The Applied Course of Web System Development.</div>
</footer>
</body>
</html>