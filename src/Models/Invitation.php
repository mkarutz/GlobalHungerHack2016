<?php
/**
 * Created by PhpStorm.
 * User: mkarutz
 * Date: 28/02/16
 * Time: 4:14 AM
 */

namespace FedUp\Models;


class Invitation
{
	/** @var  int */
	private $invitationId;

	/** @var  int */
	private $feedId;

	/** @var  int */
	private $userId;

	/**
	 * @return int
	 */
	public function getInvitationId()
	{
		return $this->invitationId;
	}

	/**
	 * @param int $invitationId
	 */
	public function setInvitationId($invitationId)
	{
		$this->invitationId = $invitationId;
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