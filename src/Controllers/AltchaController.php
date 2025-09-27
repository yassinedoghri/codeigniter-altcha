<?php

declare(strict_types=1);

namespace CodeIgniterAltcha\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniterAltcha\Altcha;
use Exception;

/**
 * @property IncomingRequest $request
 */
class AltchaController extends Controller
{
    use ResponseTrait;

    public function index(): ResponseInterface
    {
        try {
            /** @var Altcha $altcha */
            $altcha = service('altcha');

            $challenge = $altcha->generateChallenge();

            // @phpstan-ignore argument.type
            return $this->respond($challenge);
        } catch (Exception $e) {
            return $this->failServerError('Failed to create challenge: ' . $e->getMessage());
        }
    }
}
