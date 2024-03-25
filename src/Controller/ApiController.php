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
            $jsonData = $serializer->serialize($books, 'json', ['json_encode_options' => JSON_UNESCAPED_UNICODE, 'groups' => 'books_infos']);

            return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/book/{id}')]
    public function getBook($id, BookRepository $bookRepository, SerializerInterface $serializer): Response
    {
        // Récupération du livre à partir de l'ID
        $book = $bookRepository->find($id);

        // Si aucun livre correspondant à l'ID n'est trouvé
        if (!$book) {
            return new JsonResponse(['error' => 'Ressources Inexistantes'], Response::HTTP_NOT_FOUND);
        }

        try {
            // Sérialisation du livre en JSON en spécifiant les options de sérialisation
            $jsonData = $serializer->serialize($book, 'json', ['json_encode_options' => JSON_UNESCAPED_UNICODE, 'groups' => 'book_details']);

            // Réponse JSON contenant les données sérialisées du livre
            return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
        } catch (Exception $e) {
            // En cas d'erreur pendant la sérialisation
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
