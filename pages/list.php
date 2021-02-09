<?php
// 外部ファイルの読み込み
require_once "./common/db.php";
?>
<?php
// データベース接続オブジェクトを取得
$pdo = connectDB();

/* productテーブルの全件検索 */
try{
	// SQLの設定
	$sql = "select * from product";
	// SQL接続オブジェクトを取得
	$pstmt = $pdo->prepare($sql);
	// SQLの実行と結果セットの取得
	$pstmt->execute();
	$records = $pstmt->fetchAll(PDO::FETCH_ASSOC);
	// 結果セットから商品の配列へ入れ替え
	$products = [];
	foreach ($records as $record) {
		$product = [];
		$product["id"] = $record["id"];
		$product["name"] = $record["name"];
		$product["price"] = $record["price"];
		$product["category"] = $record["category"];
		$product["detail"] = $record["detail"];
		$products[] = $product;
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
<main id="list">
	<h2>商品一覧</h2>
	<?php if (count($products) > 0): ?>
	<table class="list">
		<tr>
			<th>商品ID</th>
			<th>カテゴリ</th>
			<th>商品名</th>
			<th>価格</th>
			<th></th>
		</tr>
		<?php foreach($products as $product): ?>
		<tr>
			<td><?= $product["id"] ?></td>
			<td><?= $product["category"] ?></td>
			<td><?= $product["name"] ?></td>
			<td>&yen;<?= $product["price"] ?></td>
			<td class="buttons">
				<form name="inputs">
					<input type="hidden" name="id" value="<?= $product["id"] ?>" />
					<button formaction="update.php" formmethod="post" name="action" value="update">更新</button>
					<button formaction="confirm.php" formmethod="post" name="action" value="delete">削除</button>
				</form>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php endif; ?>
</main>
<footer>
	<div id="copyright">&copy; 2021 The Applied Course of Web System Development.</div>
</footer>
</body>
</html>