<?php
namespace App\Dto;

use App\Entity\Person;

final class PersonOutput
{
    public ?int $id = null;
    public ?string $firstName = null;
    public string $lastName;
    public ?string $fullName = null; // Nouveau champ pour le nom complet
    public ?\DateTime $birthDate = null;
    public ?\DateTimeImmutable $createdAt = null;

    public function __construct(Person $person)
    {
        $this->id = $person->getId();
        $this->firstName = $person->getFirstName();
        $this->lastName = $person->getLastName();
        $this->birthDate = $person->getBirthDate();
        $this->createdAt = $person->getCreatedAt();
        $this->fullName = trim(($this->firstName ?? '') . ' ' . $this->lastName); // Initialisation du nom complet
    }
}