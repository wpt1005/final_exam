<?php
/**
 * productテーブルの1レコードを管理するクラス
 */
class Product {
	/**
	 * プロパティ
	 */
	private $id;
	private $name;
	private $price;
	private $category;
	private $detail;

	/**
	 * コンストラクタ
	 * @param int 商品ID
	 * @param string 商品名
	 * @param int 価格
	 * @param string 商品カテゴリ
	 * @param string 商品説明
	 */
	function __construct(int $id, string $name, int $price, string $category, string $detail) {
		$this->id = $id;
		$this->name = $name;
		$this->price = $price;
		$this->category = $category;
		$this->detail = $detail;
	}

	/** アクセサメソッド群 */

	function setId(int $id):void {
		$this->id = $id;
	}

	function getId():int {
		return $this->id;
	}

	function setName(string $name):void {
		$this->name = $name;
	}

	function getName():string {
		return $this->name;
	}

	function setPrice(int $price):void {
		$this->price = $price;
	}

	function getPrice():int {
		return $this->price;
	}

	function setCategory(string $category):void {
		$this->category = $category;
	}

	function getCategory():string {
		return $this->category;
	}

	function setDetail(string $detail):void {
		$this->detail = $detail;
	}

	function getDetail():string {
		return $this->detail;
	}

}