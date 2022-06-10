<?php
declare(strict_types=1);

namespace App\Gateway;

use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsDecorator(decorates: OmdbGateway::class, priority: 10)]
class CacheableOmdbGateway extends OmdbGateway
{
    public function __construct(
        private CacheInterface $cache,
    ) {}

    public function getMovieByTitle(string $title): array
    {
        return $this->cache->get(
            sprintf('omdb_data_%s', md5($title)),
            function(ItemInterface $item) use($title): array {
                $item->expiresAfter(20);
                return $this->actualGateway->getMovieByTitle($title);
            }
        );
    }
}