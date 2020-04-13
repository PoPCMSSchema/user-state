<?php

declare(strict_types=1);

namespace PoP\UserState\FieldResolvers;

use PoP\ComponentModel\FieldResolvers\GlobalFieldResolverTrait;
use PoP\UserState\FieldResolvers\AbstractUserStateFieldResolver;

abstract class AbstractGlobalUserStateFieldResolver extends AbstractUserStateFieldResolver
{
    use GlobalFieldResolverTrait;
}
