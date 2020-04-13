<?php

declare(strict_types=1);

namespace PoP\UserState\Facades;

use PoP\Root\Container\ContainerBuilderFactory;
use PoP\UserState\TypeDataResolvers\UserStateTypeDataResolverInterface;

class UserStateTypeDataResolverFacade
{
    public static function getInstance(): UserStateTypeDataResolverInterface
    {
        return ContainerBuilderFactory::getInstance()->get('user_state_type_data_resolver');
    }
}
