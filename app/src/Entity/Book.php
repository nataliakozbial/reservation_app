<?php
/**
 * Book entity.
 */
namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 * @ORM\Table(name="books")
 */
class Book
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
     * Created at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * Updated at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * Title.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     * )
     */
    private $title;
    /**
     * Availability.
     *
     * @ORM\Column(
     *     type="smallint"
     * )
     *
     * @Assert\Type(type="integer")
     * @Assert\Positive
     * @Assert\NotBlank
     */
    private int $availability;
    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="book")
     */
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }





    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * Getter for Created At.
     *
     * @return \DateTimeInterface|null Created at
     */

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    /**
     * Setter for Created at.
     *
     * @param \DateTimeInterface $createdAt Created at
     */

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    /**
     * Getter for Updated at.
     *
     * @return \DateTimeInterface|null Updated at
     */

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
    /**
     * Setter for Updated at.
     *
     * @param \DateTimeInterface $updatedAt Updated at
     */

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    /**
     * Getter for Title.
     *
     * @return string|null Title
     */

    public function getTitle(): ?string
    {
        return $this->title;
    }
    /**
     * Setter for Title.
     *
     * @param string $title Title
     */

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
    /**
     * Getter for Availability.
     *
     * @return int|null Availability
     */
    public function getAvailability(): ?int
    {
        return $this->availability;
    }

    /**
     * Setter for Availability.
     *
     * @param int $availability Availability
     */
    public function setAvailability(int $availability): void
    {
        $this->availability = $availability;
    }
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setBook($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getBook() === $this) {
                $reservation->setBook(null);
            }
        }

        return $this;
    }
}
