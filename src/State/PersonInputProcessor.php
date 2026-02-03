<?php
namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\PersonInput;
use App\Entity\Person;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\SecurityBundle\Security;

final class PersonInputProcessor implements ProcessorInterface
{
    public function __construct(
        private Security $security,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!$data instanceof PersonInput) {
            return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        }

        $person = new Person();
        $person->setFirstName($data->firstName);
        $person->setLastName($data->lastName);
        $person->setBirthDate($data->birthDate);
        $person->setOwner($this->security->getUser());

        return $this->persistProcessor->process($person, $operation, $uriVariables, $context);
    }
}
