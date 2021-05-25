<?php
/**
 * Book fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Persistence\ObjectManager;

/**
 * Class BookFixtures.
 */
class BookFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; ++$i) {
            $book = new Book();
            $book->setTitle($this->faker->sentence);
            $book->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $book->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $this->manager->persist($book);
        }

        $manager->flush();
    }
}