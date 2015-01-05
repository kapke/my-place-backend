<?php
namespace Kapke\Provider\Clients;

use Kapke\Provider\Clients\Entity\Client;

class ClientManager
{
    private $doctrine;
    private $entityManager;
    private $clientRepo;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $doctrine->getManager();
        $this->clientRepo = $this->entityManager->getRepository('ClientsProviderBundle:Client');
    }

    public function getClients()
    {
        return $this->clientRepo->findAll();
    }

    public function saveClient(Client $client)
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }

    public function createClient($name, $surname)
    {
        return new Client($name, $surname);
    }
}
