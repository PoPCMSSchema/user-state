<?php
namespace PoP\UserState\Hooks;

use PoP\ComponentModel\FieldResolvers\FieldResolverInterface;
use PoP\ComponentModel\TypeResolvers\AbstractTypeResolver;
use PoP\Engine\Hooks\AbstractHookSet;
use PoP\UserState\FieldResolvers\AbstractUserStateFieldResolver;
use PoP\UserState\Environment;
use PoP\ComponentModel\GeneralUtils;
use PoP\ComponentModel\Facades\Engine\EngineFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\UserState\CheckpointSets\UserStateCheckpointSets;

class FieldResolverHooks extends AbstractHookSet
{
    protected function init()
    {
        /**
         * Filter out fieldNames requiring user state when the user is not logged-in
         */
        $this->hooksAPI->addAction(
            AbstractTypeResolver::HOOK_RESOLVED_FIELD_NAMES,
            array($this, 'maybeFilterFieldNames'),
            10,
            3
        );
    }

    public function maybeFilterFieldNames(bool $include, TypeResolverInterface $typeResolver, FieldResolverInterface $fieldResolver)
    {
        // Check if the typeResolver is an instance of the "user state" class...
        if ($fieldResolver instanceof AbstractUserStateFieldResolver) {
            /**
             * If the user is not logged in, and environment variable `DISABLE_USER_STATE_FIELDS_IF_USER_NOT_LOGGED_IN` is true,
             * then do not register field names
             */
            if (Environment::disableUserStateFieldsIfUserNotLoggedIn()) {
                $engine = EngineFacade::getInstance();
                $validation = $engine->validateCheckpoints(UserStateCheckpointSets::LOGGEDIN_DATAFROMSERVER);
                // If the validation fails, then do not register the fields
                return !GeneralUtils::isError($validation);
            }
        }
        return $include;
    }
}
