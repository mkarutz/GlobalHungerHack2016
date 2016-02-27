<?php
/**
 * Created by PhpStorm.
 * User: mkarutz
 * Date: 28/02/16
 * Time: 4:13 AM
 */

namespace FedUp\Models;


class Address
{
	/** @var  int */
	private $addressId;

	/** @var  string */
	private $firstLine;

	/** @var  string */
	private $secondLine;

	/** @var  int */
	private $suburbId;

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

	/**
	 * @return string
	 */
	public function getFirstLine()
	{
		return $this->firstLine;
	}

	/**
	 * @param string $firstLine
	 */
	public function setFirstLine($firstLine)
	{
		$this->firstLine = $firstLine;
	}

	/**
	 * @return string
	 */
	public function getSecondLine()
	{
		return $this->secondLine;
	}

	/**
	 * @param string $secondLine
	 */
	public function setSecondLine($secondLine)
	{
		$this->secondLine = $secondLine;
	}

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
}