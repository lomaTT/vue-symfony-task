<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Message;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home', methods: ['get'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/home', name: 'message_post', methods: ['post'])]
    public function create(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator, SerializerInterface $serializer): JsonResponse
    {
        $message = new Message();

        $data = $request->toArray();
        if (!isset($data['name'])) {
            $data['name'] = '';
        }
        if (!isset($data['surname'])) {
            $data['surname'] = '';
        }
        if (!isset($data['email'])) {
            $data['email'] = '';
        }
        if (!isset($data['message'])) {
            $data['message'] = '';
        }

        if (strlen($data['name']) > 255) {
            return new JsonResponse('Name is too long, please use less than 255 symbols.', Response::HTTP_BAD_REQUEST, [], false);
        }
        if (strlen($data['surname']) > 255) {
            return new JsonResponse('Surname is too long, please use less than 255 symbols.', Response::HTTP_BAD_REQUEST, [], false);
        }
        if (strlen($data['email']) > 255) {
            return new JsonResponse('Email is so long, please use less than 255 symbols.', Response::HTTP_BAD_REQUEST, [], false);
        }
        if (strlen($data['message']) > 1000) {
            return new JsonResponse('Text is so long, please use less than 255 symbols.', Response::HTTP_BAD_REQUEST, [], false);
        }


        $message->setName($data['name']);
        $message->setSurname($data['surname']);
        $message->setEmail($data['email']);
        $message->setText($data['message']);

        $errors = $validator->validate($message);

        if (count($errors) == 0) {
            $entityManager->persist($message);
            $entityManager->flush();
            $data = $serializer->serialize($message, JsonEncoder::FORMAT);
            return new JsonResponse($data, Response::HTTP_CREATED, [], true);
        } else {
            $data = $serializer->serialize($message, JsonEncoder::FORMAT);
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
        }
    }
}
