<?php

namespace FedUp\Services;

use FedUp\Models\User;
use FedUp\DAOs\UserDAO;
use Exception;

/**
 * This Service handles User sessions, login and logout.
 * @package Kepler\Services
 */
class UserAuthenticationService
{
	/** @var  UserDAO */
	private $userDAO;

	/**
	 * UserAuthenticationService constructor.
	 * @param UserDAO $userDAO
	 * @throws Exception
	 */
	public function __construct(UserDAO $userDAO)
	{
		if (is_null($userDAO)) {
			throw new Exception("UserRepository cannot be null.");
		}
		$this->userDAO = $userDAO;
	}

	/**
	 * Authenticate user credentials. If successful, updates User session and returns true.
	 * Otherwise, returns false.
	 * @param $username
	 * @param $password
	 * @return bool
	 * @throws Exception
	 */
	public function login($username, $password)
	{
		if (is_null($username)) {
			throw new Exception("Username cannot be null.");
		}

		if (is_null($username)) {
			throw new Exception("Password cannot be null.");
		}

		try {
			/** @var User $user */
			$user = $this->userDAO->login($username, $password);
			if (is_null($user)) {
				return false;
			}
			$_SESSION['user'] = $user;
			return true;
		} catch (Exception $e) {
			throw new Exception("Error logging in.");
		}
	}

	/**
	 * Destroy user session.
	 */
	public function logout()
	{
		session_unset();
		session_destroy();
	}

	/**
	 * Returns true if user is logged in, else returns false.
	 * @return bool
	 */
	public function isLoggedIn()
	{
		return array_key_exists('user', $_SESSION);
	}

	/**
	 * Get the currently logged in User object.
	 * @return User
	 */
	public function getUser()
	{
		if ($this->isLoggedIn()) {
			return $_SESSION['user'];
		}
		return null;
	}
}
