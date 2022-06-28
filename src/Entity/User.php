<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[ORM\Column(type: 'string', length: 50, unique: true)]
    private $email;

    #[ORM\Column(type: 'float')]
    private $rememberToken;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Booking::class, orphanRemoval: true)]
    private $bookings;

    #[ORM\OneToOne(mappedBy: 'owner', targetEntity: DriverLicence::class, cascade: ['persist', 'remove'])]
    private $driverLicence;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRememberToken(): ?float
    {
        return $this->rememberToken;
    }

    public function setRememberToken(float $rememberToken): self
    {
        $this->rememberToken = $rememberToken;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setCustomer($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getCustomer() === $this) {
                $booking->setCustomer(null);
            }
        }

        return $this;
    }

    public function getDriverLicence(): ?DriverLicence
    {
        return $this->driverLicence;
    }

    public function setDriverLicence(DriverLicence $driverLicence): self
    {
        // set the owning side of the relation if necessary
        if ($driverLicence->getOwner() !== $this) {
            $driverLicence->setOwner($this);
        }

        $this->driverLicence = $driverLicence;

        return $this;
    }
}
