<?php
namespace PoP\UserState\Hooks;

use PoP\API\Environment;
// use PoP\UserState\Environment;
use PoP\Engine\Hooks\AbstractCMSHookSet;
use PoP\ComponentModel\TypeResolvers\AbstractTypeResolver;
use PoP\UserState\Facades\UserStateTypeDataResolverFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldResolvers\FieldResolverInterface;

abstract class AbstractMaybeDisableUserStateFieldsIfUserNotLoggedInFieldResolverHooks extends AbstractCMSHookSet
{
    public function cmsInit(): void
    {
        /**
         * Check if to disable the user fields
         */
        if (Environment::usePrivateSchemaMode() && $this->disableUserStateFields()) {
            $this->hooksAPI->addFilter(
                AbstractTypeResolver::HOOK_RESOLVED_FIELD_NAMES,
                array($this, 'maybeFilterFieldNames'),
                10,
                4
            );
        }
    }

    protected function disableUserStateFields(): bool
    {
        /**
         * If the user is not logged in, then do not register field names
         */
        // if (Environment::disableUserStateFieldsIfUserNotLoggedIn()) {
        $userStateTypeDataResolverFacade = UserStateTypeDataResolverFacade::getInstance();
        return !$userStateTypeDataResolverFacade->isUserLoggedIn();
        // }
        // return false;
    }

    public function maybeFilterFieldNames(bool $include, TypeResolverInterface $typeResolver, FieldResolverInterface $fieldResolver, string $fieldName): bool
    {
        // Because there may be several hooks chained, if any of them has already rejected the field, then already return that response
        if (!$include) {
            return false;
        }
        // Check if to remove the field
        return !$this->removeFieldNames($typeResolver, $fieldResolver, $fieldName);
    }
    /**
     * Decide if to remove the fieldNames
     *
     * @param TypeResolverInterface $typeResolver
     * @param FieldResolverInterface $fieldResolver
     * @param string $fieldName
     * @return boolean
     */
    abstract protected function removeFieldNames(TypeResolverInterface $typeResolver, FieldResolverInterface $fieldResolver, string $fieldName): bool;
}
