<?php
namespace PoP\UserState\Hooks;

use PoP\UserState\Facades\UserStateTypeDataResolverFacade;
use PoP\API\Hooks\AbstractMaybeDisableDirectivesInPrivateSchemaHookSet;

abstract class AbstractMaybeDisableDirectivesIfUserNotLoggedInPrivateSchemaHookSet extends AbstractMaybeDisableDirectivesInPrivateSchemaHookSet
{
    protected function enabled(): bool
    {
        // If it is not a private schema, then already do not enable
        if (!parent::enabled()) {
            return false;
        }

        /**
         * If the user is not logged in, then do not register directive names
         */
        $userStateTypeDataResolver = UserStateTypeDataResolverFacade::getInstance();
        return !$userStateTypeDataResolver->isUserLoggedIn();
    }
}
