<?php
/**
 * Created by PhpStorm.
 * User: mkarutz
 * Date: 28/02/16
 * Time: 4:44 AM
 */

namespace FedUp\DAOs;

use FedUp\Models\Address;
use \PDO;
use \PDOException;
use \Exception;

class AddressDAO
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

	public function find($addressId)
	{
		try {
			$sql = "SELECT * FROM Address " .
				"WHERE addressId=:addressId";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array(
				":addressId" => $addressId
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

	public function findByDetails($firstLine, $secondLine, $suburbId)
	{
		try {
			$sql = "SELECT * FROM Address " .
				"WHERE firstLine=:firstLine " .
				"AND secondLine=:secondLine " .
				"AND suburbId=:suburbId";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array(
				":firstLine" => $firstLine,
				":secondLine" => $secondLine,
				":suburbId" => $suburbId
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

	public function save(Address $address)
	{
		try {
			$sql = "INSERT INTO Address (firstLine, secondLine, suburbId) " .
				"VALUES (:firstLine, :secondLine, :suburbId)";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array(
				":firstLine" => $address->getFirstLine(),
				":secondLine" => $address->getSecondLine(),
				":suburbId" => $address->getSuburbId()
			));

			if ($stmt->errorCode() != '0000') {
				throw new Exception($stmt->errorInfo()[2]);
			}

			$address->setAddressId($this->dbh->lastInsertId());

		} catch (PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}

	private static function build($row)
	{
		$address = new Address();
		$address->setAddressId(intval($row['addressId']));
		$address->setFirstLine($row['firstLine']);
		$address->setSecondLine($row['secondLine']);
		$address->setSuburbId(intval($row['suburbId']));
		return $address;
	}
}