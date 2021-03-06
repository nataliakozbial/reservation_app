<?php
/**
 * Book fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class BookFixtures.
 */
class BookFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'books', function () {
            $book = new Book();
            $book->setTitle($this->faker->sentence);
            $book->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $book->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $book->setCategory($this->getRandomReference('categories'));
            $book->setAvailability($this->faker->randomDigit);



            return $book;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}
