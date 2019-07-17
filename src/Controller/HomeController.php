<?php

namespace App\Controller;

use App\Repository\ToolsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param UsersRepository $usersRepository
     * @param ToolsRepository $toolsRepository
     * @return Response
     */
    public function index(UsersRepository $usersRepository, ToolsRepository $toolsRepository): Response
    {
        $user = $usersRepository->findAll()[0];
        $skills = $toolsRepository->findAll();
          return $this->render('home/index.html.twig', [
            'user' => $user,
            'skills' => $skills
        ]);
    }
}
