<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\StarshipRepository;

class MainController extends AbstractController
{
  #[Route('/')]
  public function homepage(StarshipRepository $starshipRepository): Response
  {

    $ships = $starshipRepository->findAll();
    $starshipCount = count($ships);

    $shipDetails = $ships[array_rand($ships)];

    return $this->render('main/homepage.html.twig', [
      'numberofstarships' => $starshipCount,
      'shipDetails' => $shipDetails,
    ]);
  }


  #[Route('/statPage')]
  public function statPage(): Response
  {
    return new Response("<h1>Stat Page</h1>");
  }

}