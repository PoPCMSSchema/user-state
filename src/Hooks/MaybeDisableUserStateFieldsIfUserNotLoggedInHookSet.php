<?php
namespace PoP\UserState\Hooks;

use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldResolvers\FieldResolverInterface;
use PoP\UserState\FieldResolvers\AbstractUserStateFieldResolver;
use PoP\UserState\Hooks\AbstractMaybeDisableFieldsIfUserNotLoggedInHookSet;

class MaybeDisableUserStateFieldsIfUserNotLoggedInHookSet extends AbstractMaybeDisableFieldsIfUserNotLoggedInHookSet
{
    /**
     * Apply to all fields
     *
     * @return array
     */
    protected function getFieldNames(): array
    {
        return [];
    }
    /**
     * Remove the fieldNames if the fieldResolver is an instance of the "user state" one
     *
     * @param boolean $include
     * @param TypeResolverInterface $typeResolver
     * @param FieldResolverInterface $fieldResolver
     * @param string $fieldName
     * @return boolean
     */
    protected function removeFieldNames(TypeResolverInterface $typeResolver, FieldResolverInterface $fieldResolver, string $fieldName): bool
    {
        return ($fieldResolver instanceof AbstractUserStateFieldResolver);
    }
}
