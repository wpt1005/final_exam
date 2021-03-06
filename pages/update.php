<?php
// 外部ファイルの読み込み
require_once "./common/db.php";
require_once "./common/Product.php";
?>
<?php
// リクエストパラメータを取得
isset($_REQUEST["action"]) ? $action = $_REQUEST["action"] : $action = "";
isset($_REQUEST["id"]) ? $id = $_REQUEST["id"] : $id = 0;
/* 指定されたIDの商品の検索 */
$pdo = null;
$pstmt = null;
try {
	// データベース接続オブエジェクトの取得
	$pdo = connectDB();
	// 実行するSQLの設定
	$sql = "select * from product where id = ?";
	// SQL実行オブジェクトを取得
	$pstmt = $pdo->prepare($sql);
	// プレースホルダを設定
	$pstmt->bindValue(1, $id);
	// SQLの実行と結果セットの取得
	$pstmt->execute();
	$records = $pstmt->fetchAll(PDO::FETCH_ASSOC);
	// 結果セットから商品クラスのインスタンスを取得
	$product = null;
	if (count($records) > 0) {
		$id = $records[0]["id"];
		$name = $records[0]["name"];
		$price = $records[0]["price"];
		$category = $records[0]["category"];
		$detail = $records[0]["detail"];
		$product = new Product($id, $name, $price, $category, $detail);
	}
} catch (PDOException $e) {
	die($e->getMessage());
} finally {
	unset($pstmt);
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
<main id="update">
	<h2>商品の更新</h2>
	<?php if(!is_null($product)): ?>
	<p class="note">商品名と価格は<em>必須入力</em>です。</p>
	<form class="update">
		<table class="form">
			<tr>
				<th>商品ID</th>
				<td>
					<?= $product->getId() ?>
					<input type="hidden" name="id" value="<?= $product->getId() ?>">
				</td>
			</tr>
			<tr>
				<th>カテゴリ</th>
				<td>
					<select name="category">
						<option value="財布・小物入れ" <?php if ($product->getCategory() === "財布・小物入れ") echo "selected"; ?> >財布・小物入れ</option>
						<option value="食卓用" <?php if ($product->getCategory() === "食卓用") echo "selected"; ?>selected>食卓用</option>
						<option value="その他" <?php if ($product->getCategory() === "その他") echo "selected"; ?>>その他</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>商品名</th>
				<td><input type="text" name="name" value="<?= $product->getName() ?>"></td>
			</tr>
			<tr>
				<th>価格</th>
				<td><input type="number" name="price" value="<?= $product->getPrice() ?>">円</td>
			</tr>
			<tr>
				<th>商品説明</th>
				<td><textarea name="detail" id="" cols="30" rows="3"><?= $product->getDetail() ?></textarea></td>
			</tr>
			<tr class="buttons">
				<td colspan="2">
					<button formaction="confirm.php" formmethod="post" name="action" value="update">確認画面へ</button>
				</td>
			</tr>
		</table>
	</form>
	<?php endif; ?>
</main>
<footer>
	<div id="copyright">&copy; 2021 The Applied Course of Web System Development.</div>
</footer>
</body>
</html>