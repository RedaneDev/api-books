<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $authorsData = [
            [
                'name' => 'J.K Rowling',
            ],
            [
                'name' => 'George R.R Martin',
            ],
            [
                'name' => 'Stephen King',
            ],
            [
                'name' => 'John Steinbeck',
            ],
        ];

        foreach($authorsData as $authorData) {
            $author = New Author;
            $author->setName($authorData['name']);
            $manager->persist($author);
        }

        $manager->flush();
    }
}
