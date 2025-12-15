<?php

declare(strict_types=1);

namespace CodeIgniterAltcha;

use AltchaOrg\Altcha\Altcha as AltchaLib;
use AltchaOrg\Altcha\Challenge;
use AltchaOrg\Altcha\ChallengeOptions;
use AltchaOrg\Altcha\Hasher\Algorithm;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\I18n\Time;
use CodeIgniter\Security\Exceptions\SecurityException;
use CodeIgniterAltcha\Config\Altcha as ConfigAltcha;
use Exception;

class Altcha extends AltchaLib
{
    public function __construct(
        private readonly ConfigAltcha $config
    ) {
        $hmacKey = $this->getHmacKey();

        if ($hmacKey === '') {
            throw new Exception('ALTCHA HMAC secret key is empty.');
        }

        parent::__construct($hmacKey);
    }

    public function generateChallenge(): Challenge
    {
        $options = new ChallengeOptions(
            algorithm: $this->config->challengeAlgorithm ? Algorithm::from(
                $this->config->challengeAlgorithm
            ) : Algorithm::SHA256,
            maxNumber: $this->config->challengeMaxNumber ?? ChallengeOptions::DEFAULT_MAX_NUMBER,
            expires: (Time::now())->addSeconds($this->config->challengeExpires),
        );

        return parent::createChallenge($options);
    }

    /**
     * Altcha verification.
     */
    public function verifyRequest(IncomingRequest $request): self
    {
        // Verification during POST only
        if ($request->getMethod() !== 'POST') {
            return $this;
        }

        $altchaPayload = $request->getPost('altcha') ?? null;

        if ($altchaPayload === null || ! is_string($altchaPayload)) {

            // Altcha payload invalid.
            throw SecurityException::forDisallowedAction();
        }

        $decodedPayload = base64_decode($altchaPayload, true);

        if (! $decodedPayload) {
            // Failure to decode Altcha payload.
            throw SecurityException::forDisallowedAction();
        }

        $altchaPayload = json_decode($decodedPayload, true);

        if (! is_array($altchaPayload)) {

            // Malformed Altcha payload.
            throw SecurityException::forDisallowedAction();
        }

        $verified = $this->verifySolution($altchaPayload, true);

        if (! $verified) {
            throw SecurityException::forDisallowedAction();
        }

        log_message('info', 'Altcha payload verified.');

        return $this;
    }

    public function shouldRedirect(): bool
    {
        return $this->config->redirect;
    }

    private function getHmacKey(): string
    {
        if (! $this->config->autoGenerateHMAC || cache()->getCacheInfo() === null) {
            return $this->config->hmacKey;
        }

        $cacheName = 'altcha-hmac-key';
        if (! ($found = cache($cacheName))) {
            // Generate a cryptographically secure random part (32 bytes)
            $randomPart = random_bytes(32);

            $found = hash('sha256', $randomPart);

            cache()
                ->save($cacheName, $found, $this->config->hmacKeyTTL);
        }

        /** @var string $found */
        return $found;
    }
}
