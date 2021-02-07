<?php

class Sql {
	private $conn;

	public function __construct() {
		$this->conn = new PDO("mysql:host=localhost;dbname=chat", "root", "");
	}

	private function setParams($statment, $parameters = []) {
		foreach ($parameters as $key => $value) {
			$this->setParam($statment, $key, $value);
		}
	}

	private function setParam($statment, $key, $value) {
		$statment->bindParam($key, $value);
	}

	public function query($rawQuery, $params = array()) {
		$stmt = $this->conn->prepare($rawQuery);
		$this->setParams($stmt, $params);
		$stmt->execute();
		return $stmt;
	}

	public function select($rawQuery, $parameters = array()):array {
		return $this->query($rawQuery, $parameters)->fetchAll(PDO::FETCH_ASSOC);
	}
} 