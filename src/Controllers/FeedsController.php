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
use FedUp\DAOs\UserDAO;
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

	/** @var UserDAO */
	private $userDAO;

	/** @var  Twig_Environment */
	private $twig;

	/**
	 * FeedsController constructor.
	 * @param UserAuthenticationService $userAuthenticationService
	 * @param FeedDAO $feedDAO
	 * @param AddressDAO $addressDAO
	 * @param SuburbDAO $suburbDAO
	 * @param UserDAO $userDAO
	 * @param Twig_Environment $twig
	 */
	public function __construct(UserAuthenticationService $userAuthenticationService, FeedDAO $feedDAO,
	                            AddressDAO $addressDAO, SuburbDAO $suburbDAO, UserDAO $userDAO, Twig_Environment $twig)
	{
		$this->userAuthenticationService = $userAuthenticationService;
		$this->feedDAO = $feedDAO;
		$this->addressDAO = $addressDAO;
		$this->suburbDAO = $suburbDAO;
		$this->userDAO = $userDAO;
		$this->twig = $twig;
	}

	public function index(Request $request)
	{
		$user = $this->userAuthenticationService->getUser();
		$suburbs = $this->suburbDAO->findAll();

		if (!$request->query->has('suburbId')) {
			$feeds = $this->feedDAO->findAll();

			return new Response($this->twig->render('feeds/index.html.twig', array(
				'user' => $user,
				'suburbs' => $suburbs,
				'feeds' => $feeds
			)));
		}

		$suburb = $this->suburbDAO->find($request->query->get('suburbId'));
		$feeds = $this->feedDAO->findBySuburbId($request->query->get('suburbId'));

		return new Response($this->twig->render('feeds/index.html.twig', array(
			'user' => $user,
			'suburbParam' => $suburb,
			'suburbs' => $suburbs,
			'feeds' => $feeds
		)));
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
		$addressLine2 = $form->get('line2') === '' ? null : $form->get('line2');
		$suburbId = $form->get('suburbId');

		$address = $this->addressDAO->findByDetails($addressLine1, $addressLine2, $suburbId);
		if (is_null($address)) {
			$address = new Address();
			$address->setFirstLine($addressLine1);
			$address->setSecondLine($addressLine2);
			$address->setSuburbId($suburbId);
			$this->addressDAO->save($address);
		}

		$feed->setAddressId($address->getAddressId());

		$extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
		$feed->setFileExt($extension);
		$this->feedDAO->save($feed);

		$target = '/var/www/GlobalHungerHack2016/web/photos/' . $feed->getFeedId() . '.' . $extension;
		move_uploaded_file($_FILES['photo']['tmp_name'], $target);

		return new RedirectResponse('/feeds/' . $feed->getFeedId());
	}

	public function view(Request $request, $feedId)
	{
		$user = $this->userAuthenticationService->getUser();
		$feed = $this->feedDAO->find($feedId);
		$owner = $this->userDAO->find($feed->getUserId());
		$address = $this->addressDAO->find($feed->getAddressId());
		$suburb = $this->suburbDAO->find($address->getSuburbId());
		return new Response($this->twig->render('feeds/view.html.twig', array(
			'user' => $user,
			'feed' => $feed,
			'owner' => $owner,
			'address' => $address,
			'suburb' => $suburb
		)));
	}
}
