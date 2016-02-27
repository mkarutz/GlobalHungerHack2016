<?php
/**
 * Created by PhpStorm.
 * User: mkarutz
 * Date: 28/02/16
 * Time: 3:40 AM
 */

namespace FedUp\Controllers;

use FedUp\DAOs\FeedDAO;
use FedUp\DAOs\SuburbDAO;
use FedUp\Services\UserAuthenticationService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \Twig_Environment;

class FeedsController
{

	/** @var  FeedDAO */
	private $feedDAO;

	/** @var  SuburbDAO */
	private $suburbDAO;

	/** @var  Twig_Environment */
	private $twig;

	/**
	 * FeedsController constructor.
	 * @param FeedDAO $feedDAO
	 * @param SuburbDAO $suburbDAO
	 * @param Twig_Environment $twig
	 */
	public function __construct(FeedDAO $feedDAO, SuburbDAO $suburbDAO, Twig_Environment $twig)
	{
		$this->feedDAO = $feedDAO;
		$this->suburbDAO = $suburbDAO;
		$this->twig = $twig;
	}


	public function form(Request $request)
	{
		$suburbs = $this->suburbDAO->findAll();
		return new Response($this->twig->render('feeds/new.html.twig'));
	}
}
