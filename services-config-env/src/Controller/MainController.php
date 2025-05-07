<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\StarshipRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class MainController extends AbstractController
{
  #[Route('/', name: 'app_homepage')]
  public function homepage(
    StarshipRepository $starshipRepository,
    HttpClientInterface $client,
    CacheInterface $cache,
    ): Response
  {

    $ships = $starshipRepository->findAll();
    $shipDetails = $ships[array_rand($ships)];
    $issData = $cache->get('iss_location_data', function (ItemInterface $item) use ($client): array {
      $item->expiresAfter(5);
      $response = $client->request('GET', 'https://api.wheretheiss.at/v1/satellites/25544');
      return $response->toArray();
    });

    return $this->render('main/homepage.html.twig', [
      'ships' => $ships,
      'myShip' => $shipDetails,
      'issData' => $issData,
    ]);
  }


  #[Route('/statPage')]
  public function statPage(): Response
  {
    return new Response("<h1>Stat Page</h1>");
  }

}