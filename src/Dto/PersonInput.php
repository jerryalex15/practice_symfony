<?php
namespace App\Dto;

final class PersonInput
{
    public ?string $firstName = null;
    public string $lastName;
    public ?\DateTime $birthDate = null;

    // On ne met pas $owner/User ici pour ne pas permettre au client de changer ça
}