<?php

namespace App\Core;


class Database
{

	private $pdo;
	private $table;
	private $query;
	private $last_result = [];

	public function __construct()
	{
		try {
			$this->pdo = new \PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PASSWORD);
		} catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());
		}

		$classExploded = explode("\\", get_called_class());
		$this->table = strtolower(end($classExploded));
	}


	public function save()
	{

		$column = array_diff_key(
			get_object_vars($this),
			get_class_vars(get_class())
		);

		if (is_null($this->getId())) {

			$query = $this->pdo->prepare("INSERT INTO " . $this->table . " 
						(" . implode(',', array_keys($column)) . ") 
						VALUES 
						(:" . implode(',:', array_keys($column)) . ") ");
		} else {

			$column['id'] = $this->getId();

			$query = "UPDATE " . $this->table . " SET";

			foreach (array_keys($column) as $key) {
				$query .= " " . $key . " = :" . $key . ",";
			}

			$query = trim($query, ',');
			$query .= " WHERE id = :id";
			$query = $this->pdo->prepare($query);
		}

		if ($query->execute($column))
			return 1;
		else
			return 0;
	}

	public function selectAll()
	{
		$sql = "SELECT * FROM " . $this->table;

		$result = [];

		try {
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$prep = $this->pdo->prepare($sql);
			$prep->execute();
			$result = $prep->fetchAll(\PDO::FETCH_ASSOC);
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

	public function deleteById()
	{
		$sql = "DELETE FROM " . $this->table . " WHERE id = :id";

		try {
			$prep = $this->pdo->prepare($sql);
			$prep->execute(['id' => $this->getId()]);
			return 1;
		} catch (\PDOException $e) {
			$e->getMessage();
		}
		return 0;
	}

	public function import($data)
	{
		$columns = array_diff_key(
			get_object_vars($this),
			get_class_vars(get_class())
		);

		foreach ($columns as $key => $value) {
			$setter = 'set' . ucfirst($key);
			$this->$setter($data[$key]);
		}
	}

	public function seed()
	{
		$sqlArray = explode(';\r', file_get_contents('Core/sql/default.sql'));
		$success = false;
		foreach ($sqlArray as $sql) {
			$stmt = $this->pdo->prepare($sql);
			if (!$stmt->execute())
				return false;
		}
		Helpers::redirect('/');
	}
}
