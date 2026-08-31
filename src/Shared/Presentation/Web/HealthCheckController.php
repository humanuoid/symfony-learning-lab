<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Web;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/health', methods: ['GET'])]
final class HealthCheckController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['status' => 'ok']);
    }
}
