<?php
namespace PoP\UserState\FieldResolvers;

use PoP\API\TypeResolvers\RootTypeResolver;
use PoP\UserState\FieldResolvers\AbstractUserStateFieldResolver;

class RootMeFieldResolver extends AbstractUserStateFieldResolver
{
    use MeFieldResolverTrait;

    public static function getClassesToAttachTo(): array
    {
        return array(RootTypeResolver::class);
    }
}
