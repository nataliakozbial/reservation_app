<?php

/**
 * Reservation entity.
 */

namespace App\Entity;

use App\Repository\ReservationRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Reservation.
 *
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 * @ORM\Table(name="reservations")
 */
class Reservation
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(
     *     type="integer"
     * )
     */
    private int $id;

    /**
     * End date.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(
     *     type="date"
     * )
     *
     * @Assert\Type(type="\DateTimeInterface")
     */
    private DateTimeInterface $endDate;

    /**
     * Start date.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(
     *     type="date"
     * )
     *
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private DateTimeInterface $startDate;

    /**
     * Book entity.
     *
     * @ORM\ManyToOne(
     *     targetEntity=Book::class, inversedBy="reservations"
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private Book $book;

    /**
     * User.
     *
     * @ORM\ManyToOne(
     *     targetEntity=User::class, inversedBy="reservations"
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * Comment.
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="255"
     * )
     */
    private string $comment;

    /**
     * Getter for Id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for ends date.
     *
     * @return DateTimeInterface|null
     */
    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * Setter for end date.
     *
     * @param DateTimeInterface $endDate
     */
    public function setEndnDate(DateTimeInterface $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * Getter for start date.
     *
     * @return DateTimeInterface|null
     */
    public function getStartDate(): ?DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * Setter for start date.
     *
     * @param DateTimeInterface $startDate
     */
    public function setStartDate(DateTimeInterface $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * Getter for Book.
     *
     * @return Book |null Book
     */
    public function getBook(): ?Book
    {
        return $this->book;
    }

    /**
     * Setter for Book.
     *
     * @param Book $book Book
     */
    public function setBook(Book $book): void
    {
        $this->book = $book;
    }

    /**
     * Getter for User.
     *
     * @return User|null User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Setter for User
     *
     * @param User $user User
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * Getter for comment.
     *
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * Setter for comment.
     *
     * @param string $comment Comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }
}
