<?php
declare(strict_types=1);

namespace StepTheFkUp\EasyApiToken\Decoders;

use Psr\Http\Message\ServerRequestInterface;
use StepTheFkUp\EasyApiToken\Interfaces\EasyApiTokenDecoderInterface;
use StepTheFkUp\EasyApiToken\Interfaces\EasyApiTokenInterface;
use StepTheFkUp\EasyApiToken\Interfaces\Tokens\Factories\JwtEasyApiTokenFactoryInterface;
use StepTheFkUp\EasyApiToken\Traits\EasyApiTokenDecoderTrait;

final class JwtTokenDecoder implements EasyApiTokenDecoderInterface
{
    use EasyApiTokenDecoderTrait;

    /**
     * @var \StepTheFkUp\EasyApiToken\Interfaces\Tokens\Factories\JwtEasyApiTokenFactoryInterface
     */
    private $jwtApiTokenFactory;

    /**
     * JwtTokenDecoder constructor.
     *
     * @param \StepTheFkUp\EasyApiToken\Interfaces\Tokens\Factories\JwtEasyApiTokenFactoryInterface $jwtApiTokenFactory
     */
    public function __construct(JwtEasyApiTokenFactoryInterface $jwtApiTokenFactory)
    {
        $this->jwtApiTokenFactory = $jwtApiTokenFactory;
    }

    /**
     * Decode API token for given request.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return null|\StepTheFkUp\EasyApiToken\Interfaces\EasyApiTokenInterface
     *
     * @throws \StepTheFkUp\EasyApiToken\Exceptions\InvalidEasyApiTokenFromRequestException
     */
    public function decode(ServerRequestInterface $request): ?EasyApiTokenInterface
    {
        $authorization = $this->getHeaderWithoutPrefix('Authorization', 'Bearer', $request);

        if ($authorization === null) {
            return null; // If Authorization doesn't start with Basic, return null
        }

        return $this->jwtApiTokenFactory->createFromString($authorization);
    }
}

\class_alias(
    JwtTokenDecoder::class,
    'LoyaltyCorp\EasyApiToken\Decoders\JwtTokenDecoder',
    false
);