<?php

namespace App\Controller;

use Exception;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    #[Route('/books', name: 'books')]
    public function getAllBooks(SerializerInterface $serializer, BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();

        try {
            $jsonData = $serializer->serialize($books, 'json', ['json_encode_options' => JSON_UNESCAPED_UNICODE , 'groups' => 'books_infos']);

            return new JsonResponse($jsonData, Response::HTTP_OK, [], true);

        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


    }

    #[Route('/book/{id}')]
    public function getBook($id, BookRepository $bookRepository, SerializerInterface $serializer): Response
    {
        $book = $bookRepository->find($id);
        
        if (!$book) {
            return new JsonResponse(['error' => 'Ressources Inexistantes'], Response::HTTP_NOT_FOUND);
        }

        try {
            $jsonData = $serializer->serialize($book, 'json', ['json_encode_options' => JSON_UNESCAPED_UNICODE , 'groups' => 'book_details']);

            return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
