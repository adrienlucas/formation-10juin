<?php
declare(strict_types=1);

namespace App\Gateway;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsDecorator(OmdbGateway::class, priority: 20)]
class LoggableOmdbGateway extends OmdbGateway
{
    public function __construct(
        private OmdbGateway $actualGateway,
        private LoggerInterface $logger,
    )
    {}

    public function getMovieByTitle(string $title): array
    {
        $this->logger->notice('THe Omdb API has been requested.');
        return $this->actualGateway->getMovieByTitle($title);
    }
}