<?php
/**
 * Created by PhpStorm.
 * User: mkarutz
 * Date: 28/02/16
 * Time: 4:44 AM
 */

namespace FedUp\DAOs;

use FedUp\Models\Address;
use FedUp\Models\Feed;
use \PDO;
use \PDOException;
use \Exception;

class FeedDAO
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

	public function find($feedId)
	{
		try {
			$sql = "SELECT * FROM Feed " .
				"WHERE feedId=:feedId";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array(
				":feedId" => $feedId
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

	public function save(Feed $feed)
	{
		try {
			$sql = "INSERT INTO Feed (userId, title, description, addressId) " .
				"VALUES (:userId, :title, :description, :addressId)";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array(
				":userId" => $feed->getUserId(),
				":title" => $feed->getTitle(),
				":description" => $feed->getDescription(),
				":addressId" => $feed->getAddressId()
			));

			if ($stmt->errorCode() != '0000') {
				throw new Exception($stmt->errorInfo()[2]);
			}

			$feed->setAddressId($this->dbh->lastInsertId());

		} catch (PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}

	private static function build($row)
	{
		$feed = new Feed();
		$feed->setFeedId(intval($row['feedId']));
		$feed->setUserId(intval($row['userId']));
		$feed->setTitle($row['title']);
		$feed->setDescription($row['description']);
		$feed->setAddressId(intval($row['addressId']));
		return $feed;
	}
}
