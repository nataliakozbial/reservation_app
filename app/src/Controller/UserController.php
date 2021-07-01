<?php
/**
 * User controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserService;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class UserController.
 *
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @var Security
     */
    private Security $security;
    /**
     * UserController constructor.
     *
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * Index action.
     *
     * @param UserRepository $userRepository
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="user_index",
     * )
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render(
            'user/index.html.twig',
            ['users' => $userRepository->findAll()]
        );
    }




    /**
     * Show user.
     *
     * @return Response               HTTP response
     *
     * @Route(
     *     "/show",
     *     methods={"GET"},
     *     name="user_show",
     * )
     */
    public function show(): Response
    {
        $user = $this->security->getUser();

        return $this->render(
            'user/show.html.twig',
            ['user' => $user]
        );
    }
}
