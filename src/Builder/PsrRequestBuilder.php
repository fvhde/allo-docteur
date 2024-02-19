<?php

declare(strict_types=1);

namespace App\Builder;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Request;

final class PsrRequestBuilder
{
    public static function build(Request $request): ServerRequestInterface
    {
        $psr = new Psr17Factory();
        $psrFactory = new PsrHttpFactory($psr, $psr, $psr, $psr);

        return $psrFactory->createRequest($request);
    }
}
