<?php
/**
 * Created by PhpStorm.
 * User: mkarutz
 * Date: 28/02/16
 * Time: 4:09 AM
 */

namespace FedUp\Models;


class Suburb
{
	/** @var  int */
	private $suburbId;

	/** @var  string */
	private $name;

	/** @var  string */
	private $postCode;

	/**
	 * @return int
	 */
	public function getSuburbId()
	{
		return $this->suburbId;
	}

	/**
	 * @param int $suburbId
	 */
	public function setSuburbId($suburbId)
	{
		$this->suburbId = $suburbId;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getPostCode()
	{
		return $this->postCode;
	}

	/**
	 * @param string $postCode
	 */
	public function setPostCode($postCode)
	{
		$this->postCode = $postCode;
	}
}