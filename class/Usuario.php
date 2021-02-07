<?php

class Usuario {
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public function setIdUsuario($idusuario) {
		$this->idusuario = $idusuario;
	}

	public function setDesLogin($deslogin) {
		$this->deslogin = $deslogin;
	}

	public function setDesSenha($dessenha) {
		$this->dessenha = $dessenha;
	}

	public function setDtCadastro($dtcadastro) {
		$this->dtcadastro = $dtcadastro;
	}

	public function getIdUsuario() {
		return $this->idusuario;
	}

	public function getDesLogin() {
		return $this->deslogin;
	}

	public function getDesSenha() {
		return $this->dessenha;
	}

	public function getDtCadastro() {
		return $this->dtcadastro;
	}

	public function loadById($id) {
		$sql = new Sql();
		$result = $sql->select("SELECT * FROM usuario WHERE idusuario = :ID", array(
			":ID" => $id
		));

		if(isset($result[0]) > 0) {
			$this->setData($result[0]);
		}
	}

	public static function getList() {
		return (new Sql)->select("SELECT * FROM usuario ORDER BY deslogin");
	}

	public static function search($login) {
		return (new Sql)->select("SELECT * FROM usuario WHERE deslogin LIKE :LOGIN", array(
			":LOGIN" => "%{$login}%"
		));
	}

	public function login($login, $senha) {
		$sql = new Sql();
		$result = $sql->select("SELECT * FROM usuario WHERE deslogin = :LOGIN AND dessenha = :PASS", array(
			":LOGIN" => $login,
			":PASS" => $senha
		));

		if(isset($result[0])) {
			$this->setData($result[0]);
		} else {
			throw new Exception("Login ou senha inválido", 1);
		}
	}

	public function insert() {
		$sql = new Sql();
		$result = $sql->select("CALL sp_inserir_usuario(:LOGIN, :PASS)", array(
			":LOGIN" => $this->getDesLogin(),
			":PASS" => $this->getDesSenha()
		));

		if(isset($result[0])) {
			$this->setData($result[0]);
		} else {
			throw new Exception("Erro ao tentar inserir um usuário no banco.");
		}
	}

	public function update($login, $pass) {
		$this->setDesLogin($login);
		$this->setDesSenha($pass);

		$sql = new Sql();
		$sql->query("UPDATE usuario SET deslogin = :LOGIN, dessenha = :PASS WHERE idusuario = :ID", array(
			":LOGIN" => $this->getDesLogin(),
			":PASS" => $this->getDesSenha(),
			":ID" => $this->getIdUsuario()
		));
	}

	public function delete() {
		$sql = new Sql();
		$sql->query("DELETE FROM usuario WHERE idusuario = :ID", array(
			":ID" => $this->getIdUsuario()
		));

		$this->setIdUsuario(null);
		$this->setDesLogin(null);
		$this->setDesSenha(null);
		$this->setDtCadastro(null);
	}

	private function setData($data) {
		$this->setIdUsuario($data["idusuario"]);
		$this->setDesLogin($data["deslogin"]);
		$this->setDesSenha($data["dessenha"]);
		$this->setDtCadastro(new DateTime($data["dtcadastro"]));
	}

	public function __toString() {
		return json_encode(array(
			"idusuario" => $this->getIdUsuario(),
			"deslogin" => $this->getDesLogin(),
			"dessenha" => $this->getDesSenha(),
			"dtcadastro" => (!is_null($this->getDtCadastro())) ? $this->getDtCadastro()->format("d/m/Y H:i:s"): null
		));
	}
}