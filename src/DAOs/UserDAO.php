<?php

namespace FedUp\DAOs;

use FedUp\Models\User;

use \PDO;
use \PDOException;
use \Exception;

class UserDAO
{
	/** @var  PDO */
	private $dbh;

	/**
	 * @param PDO $dbh
	 */
	public function __construct(PDO $dbh)
	{
		$this->dbh = $dbh;
	}

	/**
	 * @param $userId
	 * @return User
	 * @throws Exception
	 */
	public function find($userId)
	{
		try {
			$sql = "SELECT * FROM User " .
				"WHERE userId=:userId ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array(
				":userId" => $userId
			));

			if ($stmt->errorCode() != '0000') {
				throw new Exception($stmt->errorInfo()[2]);
			}

			if (!($row = $stmt->fetch())) {
				return null;
			}

			return self::build($row);

		} catch (PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * @param $username
	 * @param $password
	 * @return User
	 * @throws Exception
	 */
	public function login($username, $password)
	{
		try {
			$sql = "SELECT * FROM User " .
				"WHERE username=:username " .
				"AND password=:password";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array(
				":username" => $username,
				":password" => $password
			));

			if ($stmt->errorCode() != '0000') {
				throw new Exception($stmt->errorInfo()[2]);
			}

			if (!($row = $stmt->fetch())) {
				return null;
			}

			return self::build($row);

		} catch (PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}

	public function save(User $user)
	{
		try {
			$sql = "INSERT INTO User (username, password, phone) " .
				"VALUES (:username, :password, :phone)";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array(
				":username" => $user->getUsername(),
				":password" => $user->getPassword(),
				":phone" => $user->getPhone()
			));

			if ($stmt->errorCode() != '0000') {
				throw new Exception($stmt->errorInfo()[2]);
			}

			$user->setUserId($this->dbh->lastInsertId());

		} catch (PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * @param array $row
	 * @return User
	 */
	private static function build($row)
	{
		$user = new User();
		$user->setUserId(intval($row["userId"]));
		$user->setUsername($row["username"]);
		$user->setPassword($row["password"]);
		$user->setPhone($row["phone"]);
		return $user;
	}
}