<?php
/**
 * Reservation service.
 */

namespace App\Service;

use App\Entity\Book;
use App\Entity\Reservation;
use App\Entity\User;
use App\Repository\BookRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class ReservationService.
 */
class ReservationService
{
    /**
     * Security.
     *
     * @var \Symfony\Component\Security\Core\Security
     */
    private $security;

    /**
     * Reservation repository.
     *
     * @var \App\Repository\ReservationRepository
     */
    private ReservationRepository $reservationRepository;

    /**
     * User repository.
     *
     * @var \App\Repository\UserRepository
     */
    private UserRepository $userRepository;

    /**
     * Book repository.
     *
     * @var \App\Repository\BookRepository
     */
    private BookRepository $bookRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private PaginatorInterface $paginator;

    /**
     * ReservationService constructor.
     *
     * @param \App\Repository\ReservationRepository   $reservationRepository Reservation repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator             Paginator
     */
    public function __construct(
        ReservationRepository $reservationRepository,
        BookRepository $bookRepository,
        UserRepository $userRepository,
        PaginatorInterface $paginator,
        Security $security
    ) {
        $this->reservationRepository = $reservationRepository;
        $this->userRepository = $userRepository;
        $this->bookRepository = $bookRepository;
        $this->paginator = $paginator;
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->reservationRepository->queryAll(),
            $page,
            ReservationRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
    /**
     * Delete reservation.
     *
     * @param \App\Entity\Reservation $reservation Reservation entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Reservation $reservation): void
    {
        $this->reservationRepository->delete($reservation);
    }
    /**
     * @param User $user User Entity
     *                   Create paginated list by User.
     *
     * @param int  $page Page number
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedListByUser(int $page, $user): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->reservationRepository->queryByAuthor($user),
            $page,
            ReservationRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save reservation.
     *
     * @param \App\Entity\Reservation $reservation Reservation entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Reservation $reservation): void
    {
        $this->reservationRepository->save($reservation);
    }




    /**
     * Create reservation.
     *
     * @param \App\Entity\Reservation $reservation Reservation
     *
     * @return bool
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function createReservation(Reservation $reservation)
    {
        $book = $reservation->getBook();
        $user = $this->security->getUser();
        $reservation->setUser($user);
        $reservation->setEndnDate(new \DateTime('+2 month'));
        $currentAvailability = $book->getAvailability();

        if ($currentAvailability > 0) {
            $currentAvailability = $currentAvailability - 1;
            $book->setAvailability($currentAvailability);
            $this->bookRepository->save($book);
            $this->reservationRepository->save($reservation);
        }
    }

    /**
     * Return reservation.
     *
     * @param \App\Entity\Reservation $reservation Reservation
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function returnReservation(Reservation $reservation): void
    {
        $book = $reservation->getBook();
        $currentAvailability = $book->getAvailability();
        $currentAvailability = $currentAvailability + 1;
        $book->setAvailability($currentAvailability);

        $this->bookRepository->save($book);
        $this->reservationRepository->delete($reservation);
    }
}
