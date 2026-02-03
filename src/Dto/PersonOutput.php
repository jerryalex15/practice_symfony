<?php
namespace App\Dto;

use App\Entity\Person;
use Symfony\Component\ObjectMapper\Attribute\Map;

final class PersonOutput
{
    public ?int $id = null;
    public ?string $firstName = null;
    public string $lastName;
    #[Map(source: 'lastName', transform: [self::class, 'buildFullName'])]
    public ?string $fullName = null; // Nouveau champ pour le nom complet
    public ?\DateTime $birthDate = null;
    public ?\DateTimeImmutable $createdAt = null;

    public static function buildFullName(mixed $value, object $source, ?object $target): ?string
    {
        if (!$source instanceof Person) {
            return null;
        }

        return trim(($source->getFirstName() ?? '') . ' ' . $source->getLastName());
    }
}
