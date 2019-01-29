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
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/api/users/{id}")
     */
    public function getApiUser(User $user)
    {
        return $this->view($user);
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/api/users")
     */
    public function getApiUsers()
    {
        $users = $this->userRepository->findAll();
        return $this->view($users);
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Post("/api/users")
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function postApiUser(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
        return $this->view($user);
    }

    /**
     * @Rest\View(serializerGroups={"user"})
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
        }
        if ($lastname !== null) {
            $user->setLastname($lastname);
        }
        if ($email !== null) {
            $user->setEmail($email);
        }
        if ($birthday !== null) {
            $user->setBirthday($birthday);
        }
        if ($apiKey !== null) {
            $user->setApiKey($apiKey);
        }

        $this->em->persist($user);
        $this->em->flush();
        return $this->view($user);
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Delete("/api/users/{id}")
     */
    public function deleteApiUser(User $user, Request $request)
    {
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $email = $request->get('email');
        $birthday = $request->get('birthday');
        $apiKey = $request->get('api_key');

        if ($firstname !== null) {
            $user->setFirstname($firstname);
        }
        if ($lastname !== null) {
            $user->setLastname($lastname);
        }
        if ($email !== null) {
            $user->setEmail($email);
        }
        if ($birthday !== null) {
            $user->setBirthday($birthday);
        }
        if ($apiKey !== null) {
            $user->setApiKey($apiKey);
        }

        $this->em->remove($user);
        $this->em->flush();
        return $this->view($user);
    }
}
