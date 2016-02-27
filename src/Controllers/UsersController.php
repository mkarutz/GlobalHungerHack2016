<?php
/**
 * Created by PhpStorm.
 * User: mkarutz
 * Date: 28/02/16
 * Time: 1:30 AM
 */

namespace FedUp\Controllers;


use FedUp\DAOs\UserDAO;
use FedUp\Models\User;
use FedUp\Services\UserAuthenticationService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \Twig_Environment;

class UsersController
{
	/** @var  UserAuthenticationService */
	private $userAuthenticationService;

	/** @var  UserDAO */
	private $userDAO;

	/** @var  Twig_Environment */
	private $twig;

	/**
	 * UsersController constructor.
	 * @param UserAuthenticationService $userAuthenticationService
	 * @param UserDAO $userDAO
	 * @param Twig_Environment $twig
	 */
	public function __construct(UserAuthenticationService $userAuthenticationService,
	                            UserDAO $userDAO,
	                            Twig_Environment $twig)
	{
		$this->userAuthenticationService = $userAuthenticationService;
		$this->userDAO = $userDAO;
		$this->twig = $twig;
	}


	public function signup(Request $request)
	{
		if ($this->userAuthenticationService->isLoggedIn()) {
			return new RedirectResponse('/app');
		}
		return new Response($this->twig->render('/signup.html.twig'));
	}

	/**
	 * Handle form submission.
	 * Create new user and persist then log in.
	 */
	public function create(Request $request)
	{
		$username = $request->request->get('username');
		$password = $request->request->get('password');
		$user = new User();
		$user->setUsername($username);
		$user->setPassword($password);
		$this->userDAO->save($user);
		$this->userAuthenticationService->login($username, $password);
		return new RedirectResponse('/app');
	}

	public function login(Request $request)
	{
		if ($this->userAuthenticationService->isLoggedIn()) {
			return new RedirectResponse('/app');
		}
		return new Response($this->twig->render('/login.html.twig'));
	}

	public function auth(Request $request)
	{
		$username = $request->request->get('username');
		$password = $request->request->get('password');
		$this->userAuthenticationService->login($username, $password);
		return new RedirectResponse('/app');
	}
}