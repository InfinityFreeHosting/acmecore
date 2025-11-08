<?php

/*
 * This file is part of the Acme PHP project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace InfinityFree\AcmeCore\Ssl\Generator\EcKey;

use InfinityFree\AcmeCore\Ssl\Generator\KeyOption;
use InfinityFree\AcmeCore\Ssl\Generator\OpensslPrivateKeyGeneratorTrait;
use InfinityFree\AcmeCore\Ssl\Generator\PrivateKeyGeneratorInterface;
use InfinityFree\AcmeCore\Ssl\PrivateKey;
use Webmozart\Assert\Assert;

/**
 * Generate random EC private key using OpenSSL.
 *
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
class EcKeyGenerator implements PrivateKeyGeneratorInterface
{
    use OpensslPrivateKeyGeneratorTrait;

    public function generatePrivateKey(KeyOption $keyOption): PrivateKey
    {
        Assert::isInstanceOf($keyOption, EcKeyOption::class);

        return $this->generatePrivateKeyFromOpensslOptions([
            'private_key_type' => OPENSSL_KEYTYPE_EC,
            'curve_name' => $keyOption->getCurveName(),
        ]);
    }

    public function supportsKeyOption(KeyOption $keyOption): bool
    {
        return $keyOption instanceof EcKeyOption;
    }
}
