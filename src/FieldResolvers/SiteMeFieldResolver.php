<?php
namespace PoP\UserState\FieldResolvers;

use PoP\API\TypeResolvers\SiteTypeResolver;
use PoP\Engine\FieldResolvers\SiteFieldResolverTrait;
use PoP\UserState\FieldResolvers\MeFieldResolverTrait;
use PoP\UserState\FieldResolvers\AbstractUserStateFieldResolver;

class SiteMeFieldResolver extends AbstractUserStateFieldResolver
{
    use MeFieldResolverTrait, SiteFieldResolverTrait;

    public static function getClassesToAttachTo(): array
    {
        return array(SiteTypeResolver::class);
    }
}
