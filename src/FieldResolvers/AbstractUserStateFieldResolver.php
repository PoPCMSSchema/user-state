<?php

declare(strict_types=1);

namespace PoP\UserState\FieldResolvers;

use PoP\UserState\FieldResolvers\UserStateFieldResolverTrait;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;

abstract class AbstractUserStateFieldResolver extends AbstractDBDataFieldResolver
{
    use UserStateFieldResolverTrait;
}
