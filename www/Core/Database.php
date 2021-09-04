<?php

namespace App\Core;


class Database
{

	private $pdo;
	private $table;
	private $last_result = [];

	public function __construct()
	{
		try {
			$this->pdo = new \PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PASSWORD);
		} catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());
		}

		//  jclm_   App\Models\User -> jclm_User
		$classExploded = explode("\\", get_called_class());
		$this->table = strtolower(DB_PREFIXE . end($classExploded)); //jclm_User
	}


	public function save()
	{

		//INSERT OU UPDATE

		//Array ( [firstname] => Yves [lastname] => SKRZYPCZYK [email] => y.skrzypczyk@gmail.com [pwd] => Test1234 [country] => fr [role] => 0 [status] => 1 [isDeleted] => 0)

		$column = array_diff_key(
			get_object_vars($this),
			get_class_vars(get_class())
		);



		if (is_null($this->getId())) {
			//INSERT


			$query = $this->pdo->prepare("INSERT INTO " . $this->table . " 
						(" . implode(',', array_keys($column)) . ") 
						VALUES 
						(:" . implode(',:', array_keys($column)) . ") "); //1 

		} else {
			//UPDATE

		}


		$query->execute($column);
	}

	//Fonctions CRUD 

	public function createTable($table, $columns)
	{
		$sql = "CREATE TABLE IF NOT EXISTS " . DB_PREFIXE . $table . "(" . $columns . ")";

		try {
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->pdo->exec($sql);
		} catch (\PDOException $e) {
			$e->getMessage();
		}
	}

	public function editTable($table, $columns)
	{
		$sql = "ALTER TABLE" . DB_PREFIXE . $table . "(" . $columns . ")";

		try {
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->pdo->exec($sql);
		} catch (\PDOException $e) {
			$e->getMessage();
		}
	}

	public function selectAll()
	{
		$sql = "SELECT * FROM " . $this->table;

		$result = [];

		try {
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$prep = $this->pdo->prepare($sql);
			$prep->execute();
			$result = $prep->fetch(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			$e->getMessage();
		}
		$this->last_result = $result;
		return $result;
	}

	public function selectById($id)
	{
		$sql = "SELECT * FROM " . $this->table . " WHERE id = :id";

		$result = [];

		try {
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$prep = $this->pdo->prepare($sql);
			$prep->execute(['id' => $id]);
			$result = $prep->fetch(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			$e->getMessage();
		}
		$this->last_result = $result;
		return $result;
	}

	public function search($column, $value)
	{
		$sql = "SELECT * FROM " . $this->table . " WHERE " . $column . " = :value";

		$result = [];

		try {
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$prep = $this->pdo->prepare($sql);
			$prep->execute(['value' => $value]);
			$result = $prep->fetch(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			$e->getMessage();
		}
		$this->last_result = $result;
		return $result;
	}

	public function limit($int)
	{
		if (count($this->last_result) > 0) {
			array_slice($this->last_result, 0, $int);
		}
	}

	public function deleteById()
	{
	}

	public function deleteAll()
	{
	}
}
