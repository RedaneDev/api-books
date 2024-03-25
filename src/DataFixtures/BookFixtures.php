<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $authors = $manager->getRepository(Author::class)->findAll();

        $booksData = [
            [
                'name' => 'Harry Potter à l\'école des sorciers',
                'description' => 'Premier livre de la serie Harry Potter',
                'publicationDate' => new \DateTime('1997-06-26'),
                'authorId' => 1
            ],
            [
                'name' => 'Harry Potter et la chambre des secrets',
                'description' => 'Deuxieme livre de la serie Harry Potter',
                'publicationDate' => new \DateTime('1998-07-02'),
                'authorId' => 1
            ],
            [
                'name' => 'Le Trône de Fer - Le Trône de Fer',
                'description' => 'Premier livre de la serie Le Trône de fer',
                'publicationDate' => new \DateTime('1998-05-01'),
                'authorId' => 2
            ],
            [
                'name' => 'Le Trône de Fer - Le donjon rouge',
                'description' => 'Deuxieme livre de la serie Le Trône de fer',
                'publicationDate' => new \DateTime('1999-01-01'),
                'authorId' => 2
            ],
            [
                'name' => 'Shining, l\'enfant lumière',
                'description' => "Shining, l'enfant lumière est un roman d'horreur écrit par Stephen King et publié en 1977. Cet ouvrage, le troisième qu’il publie, l’établit comme une figure importante du genre fantastique.",
                'publicationDate' => new \DateTime('1977-01-28'),
                'authorId' => 3
            ],
            [
                'name' => 'Des souris et des hommes',
                'description' => "Des souris et des hommes est un roman court de l'écrivain américain John Steinbeck publié en 1937. Avec Les Raisins de la colère, il s'agit de l'une de ses œuvres les plus connues.",
                'publicationDate' => new \DateTime('1937-01-01'),
                'authorId' => 4
            ],
        ];

        foreach($booksData as $bookData) {
            $book = New Book;
            $book->setName($bookData['name']);
            $book->setDescription($bookData['description']);
            $book->setPublicationDate($bookData['publicationDate']);

            $author = null;
            foreach ($authors as $existingAuthor) {
                if ($existingAuthor->getId() === $bookData['authorId']) {
                    $author = $existingAuthor;
                    break;
                }
            }
            $book->setAuthor($author);

            if (!$author) {
                throw new \Exception('Aucun auteur trouvé pour l\'ID donné.');
            }


            $manager->persist($book);
        }

        $manager->flush();
    }
}
