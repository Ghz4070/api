<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractFOSRestController
{
    private $userRepository;
    private $em;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
     * @Rest\Get("/api/users/{email}")
     */
    public function getApiUser(User $user)
    {
        return $this->json($user);
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/api/users")
     */
    public function getApiUsers()
    {
        $users = $this->userRepository->findAll();
        return $this->view($users);

//        return $this->json($users);
    }

    /**
     * @Rest\Post("/api/users")
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function postApiUser(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
        return $this->json($user);
    }

    /**
     * @Rest\Patch("/api/users/{id}")
     */
    public function patchApiUser(User $user, Request $request)
    {
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $email = $request->get('email');
        $birthday = $request->get('birthday');
        $apiKey = $request->get('api_key');

        if ($firstname !== null) {
           $user->setFirstname($firstname);
        }elseif ($lastname !== null) {
            $user->setLastname($lastname);
        }elseif ($email !== null) {
            $user->setEmail($email);
        }elseif ($birthday !== null) {
            $user->setBirthday($birthday);
        }elseif ($apiKey !== null) {
            $user->setApiKey($apiKey);
        }

        $this->em->persist($user);
        $this->em->flush();
        return $this->json($user);
    }

    /**
     * @Rest\Delete("/api/users/{email}")
     */
    public function deleteApiUser(User $user)
    {

    }
}
