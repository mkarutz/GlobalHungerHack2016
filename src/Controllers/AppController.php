<?php
/**
 * Created by PhpStorm.
 * User: mkarutz
 * Date: 28/02/16
 * Time: 3:09 AM
 */

namespace FedUp\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \Twig_Environment;

class AppController
{
	/** @var  Twig_Environment */
	private $twig;

	/**
	 * AppController constructor.
	 * @param Twig_Environment $twig
	 */
	public function __construct(Twig_Environment $twig)
	{
		$this->twig = $twig;
	}


	public function home(Request $request)
	{
		return new Response($this->twig->render('appHome.html.twig'));
	}
}
