<?php
namespace PoP\UserState\Conditional\API;

use PoP\UserState\Environment;
use PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups;
use PoP\API\DirectiveResolvers\ConditionalOnEnvironment\SchemaNoCacheCacheControlDirectiveResolver;

/**
 * Initialize component
 */
class ComponentBoot
{
    /**
     * Boot component
     *
     * @return void
     */
    public static function boot()
    {
        // Initialize classes
        self::attachDynamicDirectiveResolvers();
    }

    /**
     * Attach directive resolvers based on environment variables
     *
     * @return void
     */
    protected static function attachDynamicDirectiveResolvers()
    {
        /**
         * If `DISABLE_USER_STATE_FIELDS_IF_USER_NOT_LOGGED_IN` is true, then the "__schema" field is dynamic: Fields will be available or not depending on the user being logged in or not
         * Then, the CacheControl for field "__schema" must be set to "no-cache"
         */
        if (Environment::disableUserStateFieldsIfUserNotLoggedIn()) {
            SchemaNoCacheCacheControlDirectiveResolver::attach(AttachableExtensionGroups::DIRECTIVERESOLVERS);
        }
    }
}
