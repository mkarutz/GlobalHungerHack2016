<?php
/**
 * Created by PhpStorm.
 * User: mkarutz
 * Date: 27/02/16
 * Time: 9:40 PM
 */

namespace FedUp\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class LandingController
{
	/** @var  Twig_Environment */
	private $twig;

	/**
	 * LandingController constructor.
	 * @param Twig_Environment $twig
	 */
	public function __construct(Twig_Environment $twig)
	{
		$this->twig = $twig;
	}

	public function dispatch()
	{
		return new Response($this->twig->render('landingPage.html.twig'));
	}
}
