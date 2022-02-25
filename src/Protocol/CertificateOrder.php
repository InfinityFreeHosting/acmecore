<?php

/*
 * This file is part of the Acme PHP project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace InfinityFree\AcmeCore\Protocol;

use InfinityFree\AcmeCore\Exception\AcmeCoreClientException;

/**
 * Represent an ACME order.
 */
class CertificateOrder
{
    /** @var AuthorizationChallenge[][] */
    private $authorizationsChallenges;

    /** @var string */
    private $orderEndpoint;

    /** @var string */
    private $status;

    /** @var array */
    private $error;

    public function __construct(array $authorizationsChallenges, string $orderEndpoint = null, string $status = null, array $error = [])
    {
        foreach ($authorizationsChallenges as &$authorizationChallenges) {
            foreach ($authorizationChallenges as &$authorizationChallenge) {
                if (\is_array($authorizationChallenge)) {
                    $authorizationChallenge = AuthorizationChallenge::fromArray($authorizationChallenge);
                }
            }
        }

        $this->authorizationsChallenges = $authorizationsChallenges;
        $this->orderEndpoint = $orderEndpoint;
        $this->status = $status;
        $this->error = $error;
    }

    public function toArray(): array
    {
        return [
            'authorizationsChallenges' => array_map(function (array $authorizationChallenges) {
                return array_map(function (AuthorizationChallenge $authorizationChallenge) {
                    return $authorizationChallenge->toArray();
                }, $authorizationChallenges);
            }, $this->getAuthorizationsChallenges()),
            'orderEndpoint' => $this->getOrderEndpoint(),
            'status' => $this->getStatus(),
            'error' => $this->getError(),
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self($data['authorizationsChallenges'], $data['orderEndpoint']);
    }

    /**
     * @return AuthorizationChallenge[][]
     */
    public function getAuthorizationsChallenges()
    {
        return $this->authorizationsChallenges;
    }

    /**
     * @return AuthorizationChallenge[]
     */
    public function getAuthorizationChallenges(string $domain): array
    {
        if (!isset($this->authorizationsChallenges[$domain])) {
            throw new AcmeCoreClientException('The order does not contains any authorization challenge for the domain '.$domain);
        }

        return $this->authorizationsChallenges[$domain];
    }

    public function getOrderEndpoint(): string
    {
        return $this->orderEndpoint;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getError(): array
    {
        return $this->error;
    }

    public function getErrorType(): string
    {
        return $this->error['type'] ?? '';
    }

    public function getErrorDetail(): string
    {
        return $this->error['detail'] ?? '';
    }

    public function getErrorStatus(): int
    {
        return $this->error['status'] ?? 0;
    }
}
