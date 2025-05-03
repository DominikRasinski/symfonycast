<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
  #[Route('/')]
  public function homepage(): Response
  {

    $starshipCount = 799;

    $shipDetails = [
      "name" => "SSR Galaxy",
      "class" => "Destroyer",
      "captain" => "Luck",
      "status" => "repairing",
    ];

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