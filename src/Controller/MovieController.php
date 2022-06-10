<?php

namespace App\Controller;

use App\Gateway\OmdbGateway;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class MovieController
{
    public function __construct(
        private readonly OmdbGateway $omdbGateway,
        private readonly Environment $twig,
    )
    {}

    #[Route('/movie/{title}', name: 'app_movie')]
    #[Route('/blog/{page<\d+>?1}', name: 'blog_list')]
    #[Route('/blog/{page}',
        name: 'blog_list',
        requirements: ['page'=>'\d+'],
        defaults: ['page' => 1])
    ]
    public function __invoke(string $title)
    {
        $movieData = $this->omdbGateway->getMovieByTitle($title);

        return new Response($this->twig->render(name: 'movie/index.html.twig', context: [
            'movie' => $movieData,
        ]));
    }
}
