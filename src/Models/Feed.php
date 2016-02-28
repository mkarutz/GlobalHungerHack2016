<?php
/**
 * Created by PhpStorm.
 * User: mkarutz
 * Date: 28/02/16
 * Time: 4:14 AM
 */

namespace FedUp\Models;


class Feed
{
	/** @var  int */
	private $feedId;

	/** @var  int */
	private $userId;

	/** @var  string */
	private $title;

	/** @var  string */
	private $description;

	/** @var  int */
	private $addressId;

	/** @var  string */
	private $fileExt;

	/**
	 * @return string
	 */
	public function getFileExt()
	{
		return $this->fileExt;
	}

	/**
	 * @param string $fileExt
	 */
	public function setFileExt($fileExt)
	{
		$this->fileExt = $fileExt;
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

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @return int
	 */
	public function getAddressId()
	{
		return $this->addressId;
	}

	/**
	 * @param int $addressId
	 */
	public function setAddressId($addressId)
	{
		$this->addressId = $addressId;
	}
}