<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class AdminController extends AbstractFOSRestController
{
    private $articleRepository;
    private $userRepository;
    private $em;

    public function __construct(ArticleRepository $articleRepository, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/api/admin/users")
     */
    public function getApiUsers()
    {
        $users = $this->userRepository->findAll();
        return $this->view($users);
    }

    /**
     * @Rest\View(serializerGroups={"article"})
     * @Rest\Get("/api/admin/articles")
     */
    public function getApiArticles()
    {
        $articles = $this->articleRepository->findAll();
        return $this->view($articles);
    }

    // ajouter le reste
}
