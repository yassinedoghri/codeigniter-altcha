<?php

declare(strict_types=1);

namespace CodeIgniterAltcha\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Security\Exceptions\SecurityException;
use CodeIgniterAltcha\Altcha;

class AltchaFilter implements FilterInterface
{
    /**
     * @param list<string>|null $arguments
     *
     * @return ResponseInterface|null
     *
     * @phpstan-ignore typeCoverage.paramTypeCoverage,typeCoverage.returnTypeCoverage
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! $request instanceof IncomingRequest) {
            return null;
        }

        /** @var Altcha $altcha */
        $altcha = service('altcha');

        try {
            $altcha->verifyRequest($request);
        } catch (SecurityException $e) {
            if ($altcha->shouldRedirect() && ! $request->isAJAX()) {
                return redirect()->back()
                    ->with('error', $e->getMessage());
            }

            throw $e;
        }

        return null;
    }

    /**
     * We don't have anything to do here.
     *
     * @param list<string>|null $arguments
     *
     * @phpstan-ignore typeCoverage.paramTypeCoverage,typeCoverage.returnTypeCoverage
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
