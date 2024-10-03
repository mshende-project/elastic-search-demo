<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;

class ResponseService
{
    public function createErrorResponse(string $message, int $statusCode): Response
    {
        return new Response($message, $statusCode);
    }

    public function createSuccessResponse(string $message, int $statusCode = Response::HTTP_OK): Response
    {
        return new Response($message, $statusCode);
    }
}
