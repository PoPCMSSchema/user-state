<?php
namespace PoP\UserState\Hooks;

use PoP\UserState\Facades\UserStateTypeDataResolverFacade;
use PoP\API\Hooks\AbstractMaybeDisableDirectivesInPrivateSchemaHookSet;

abstract class AbstractMaybeDisableDirectivesIfUserNotLoggedInHookSet extends AbstractMaybeDisableDirectivesInPrivateSchemaHookSet
{
    protected function disableDirectivesInPrivateSchemaMode(): bool
    {
        /**
         * If the user is not logged in, then do not register directive names
         */
        $userStateTypeDataResolverFacade = UserStateTypeDataResolverFacade::getInstance();
        return !$userStateTypeDataResolverFacade->isUserLoggedIn();
    }
}
