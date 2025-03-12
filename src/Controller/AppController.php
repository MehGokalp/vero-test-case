<?php

namespace App\Controller;

use App\Domain\GeneratePDF\RequestDTO;
use App\Domain\GeneratePDF\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AppController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, Service $service): Response
    {
        $dto = RequestDTO::create($request);

        // if dto is not valid return response
        if ($response = $service->validate($dto)) {
            return $response;
        }

        return $service->handle($dto);
    }
}
