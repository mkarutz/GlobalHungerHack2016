<?php
/**
 * Created by PhpStorm.
 * User: mkarutz
 * Date: 28/02/16
 * Time: 4:04 AM
 */

namespace FedUp\DAOs;

use FedUp\Models\Suburb;
use \PDO;
use \PDOException;
use \Exception;

class SuburbDAO
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

	public function findAll()
	{
		try {
			$sql = "SELECT * FROM Suburb";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute();

			if ($stmt->errorCode() != '0000') {
				throw new Exception($stmt->errorInfo()[2]);
			}

			$result = array();

			foreach ($stmt->fetchAll() as $row) {
				$result[] = self::build($row);
			}

			return $result;

		} catch (PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}

	private static function build($row)
	{
		$suburb = new Suburb();
		$suburb->setName($row['name']);
		$suburb->setPostCode($row['postCode']);
		return $suburb;
	}
}