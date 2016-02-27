<?php
/**
 * Created by PhpStorm.
 * User: mkarutz
 * Date: 28/02/16
 * Time: 3:40 AM
 */

namespace FedUp\Controllers;

use FedUp\DAOs\AddressDAO;
use FedUp\DAOs\FeedDAO;
use FedUp\DAOs\SuburbDAO;
use FedUp\Models\Address;
use FedUp\Models\Feed;
use FedUp\Services\UserAuthenticationService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class FeedsController
{
	/** @var  UserAuthenticationService */
	private $userAuthenticationService;

	/** @var  FeedDAO */
	private $feedDAO;

	/** @var  AddressDAO */
	private $addressDAO;

	/** @var  SuburbDAO */
	private $suburbDAO;

	/** @var  Twig_Environment */
	private $twig;

	/**
	 * FeedsController constructor.
	 * @param UserAuthenticationService $userAuthenticationService
	 * @param FeedDAO $feedDAO
	 * @param AddressDAO $addressDAO
	 * @param SuburbDAO $suburbDAO
	 * @param Twig_Environment $twig
	 */
	public function __construct(UserAuthenticationService $userAuthenticationService, FeedDAO $feedDAO,
	                            AddressDAO $addressDAO, SuburbDAO $suburbDAO, Twig_Environment $twig)
	{
		$this->userAuthenticationService = $userAuthenticationService;
		$this->feedDAO = $feedDAO;
		$this->addressDAO = $addressDAO;
		$this->suburbDAO = $suburbDAO;
		$this->twig = $twig;
	}

	public function form(Request $request)
	{
		$suburbs = $this->suburbDAO->findAll();
		return new Response($this->twig->render('feeds/new.html.twig', array(
			'suburbs' => $suburbs
		)));
	}

	public function create(Request $request)
	{
		$user = $this->userAuthenticationService->getUser();
		$form = $request->request;

		$feed = new Feed();
		$feed->setUserId($user->getUserId());
		$feed->setTitle($form->get('title'));
		$feed->setDescription($form->get('description'));

		$addressLine1 = $form->get('line1');
		$addressLine2 = $form->get('line2');
		$suburbId = $form->get('suburbId');

		$address = $this->addressDAO->find($addressLine1, $addressLine2, $suburbId);
		if (is_null($address)) {
			$address = new Address();
			$address->setFirstLine($addressLine1);
			$address->setSecondLine($addressLine2);
			$address->setSuburbId($suburbId);
			$this->addressDAO->save($address);
		}

		$feed->setAddressId($address->getAddressId());

		$this->feedDAO->save($feed);

		$uploadedFileName = $_FILES['photo']['name'];
		$exploded = explode('.', $uploadedFileName);
		$extension = end($exploded);
		move_uploaded_file($_FILES['photo']['name'], '/var/www/GlobalHungerHack2016/web/photos/' . $feed->getFeedId() . '.' . $extension);

		return new RedirectResponse('/app');
	}
}
