<?php
/**
 * Created by PhpStorm.
 * User: mkarutz
 * Date: 28/02/16
 * Time: 4:14 AM
 */

namespace FedUp\Models;


class Request
{
	/** @var  int */
	private $requestId;

	/** @var  int */
	private $feedId;

	/** @var  int */
	private $userId;

	/**
	 * @return int
	 */
	public function getRequestId()
	{
		return $this->requestId;
	}

	/**
	 * @param int $requestId
	 */
	public function setRequestId($requestId)
	{
		$this->requestId = $requestId;
	}

	/**
	 * @return int
	 */
	public function getFeedId()
	{
		return $this->feedId;
	}

	/**
	 * @param int $feedId
	 */
	public function setFeedId($feedId)
	{
		$this->feedId = $feedId;
	}

	/**
	 * @return int
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @param int $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}
}