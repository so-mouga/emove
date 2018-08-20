<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 * @Serializer\ExclusionPolicy("ALL")
 */
class User implements UserInterface
{
    // Group api for nelmio and jms
    const API_GET  = 'api_method_get_user';
    const API_POST = 'api_method_post_user';
    const API_PUT  = 'api_method_put_user';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_GET})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_GET, User::API_POST, User::API_PUT})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_GET, User::API_POST, User::API_PUT})
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Email()
     * @Assert\Length(max="255")
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_GET, User::API_POST, User::API_PUT})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_POST})
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\DateTime()
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_GET, User::API_POST, User::API_PUT})
     *
     * @SWG\Property(example="13/06/2018")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_GET, User::API_POST, User::API_PUT})
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=10)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max="10")
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_GET, User::API_POST, User::API_PUT})
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=14)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max="15")
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_GET, User::API_POST, User::API_PUT})
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\DateTime()
     *
     * @Serializer\Expose
     * @Serializer\Groups({User::API_GET, User::API_POST, User::API_PUT})
     *
     * @SWG\Property(example="13/06/2018")
     */
    private $permis;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = array();

    /**
     * @ORM\OneToMany(targetEntity=Rental::class, cascade={"persist", "remove"}, mappedBy="user")
     */
    private $rentals;

    /**
     * @ORM\ManyToOne(targetEntity=Agency::class, inversedBy="users")
     */
    private $agency;

    public function __construct()
    {
        $this->rentals = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPermis(): ?\DateTimeInterface
    {
        return $this->permis;
    }

    public function setPermis(\DateTimeInterface $permis): self
    {
        $this->permis = $permis;

        return $this;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        return;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getRentals()
    {
        return $this->rentals;
    }

    /**
     * @param mixed $rentals
     */
    public function setRentals(Rental $rentals): void
    {
        $this->rentals = $rentals;
    }

    /**
     * @return mixed
     */
    public function getAgency(): Agency
    {
        return $this->agency;
    }

    /**
     * @param mixed $agency
     */
    public function setAgency($agency): void
    {
        if (!in_array('ROLE_SELLER', $this->getRoles())) {
            return;
        }

        $this->agency = $agency;
    }

    public function addRentals(Rental $rental)
    {
        $this->rentals->add($rental);
        $rental->setAgency($this);
    }


}
