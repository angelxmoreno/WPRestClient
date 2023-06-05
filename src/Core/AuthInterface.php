<?php

declare(strict_types=1);

namespace WPRestClient\Core;

use Psr\Http\Message\RequestInterface;

interface AuthInterface
{
    public function withAuth(RequestInterface $request): RequestInterface;
}
