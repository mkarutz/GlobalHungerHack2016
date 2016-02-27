<?php
/**
 * Created by PhpStorm.
 * User: mkarutz
 * Date: 27/02/16
 * Time: 9:40 PM
 */

namespace FedUp\Controllers;

use PDO;

class LandingController
{
	/** @var  PDO */
	private $pdo;

	/**
	 * LandingController constructor.
	 * @param PDO $pdo
	 */
	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function dispatch()
	{
		$query = "SELECT * FROM User";
		$this->pdo->query($query);
		return "OKAY!";
	}
}