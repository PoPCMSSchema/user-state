<?php
namespace PoP\UserState\FieldValueResolvers;

use PoP\UserState\Environment;
use PoP\ComponentModel\GeneralUtils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Facades\Engine\EngineFacade;
use PoP\UserState\CheckpointSets\UserStateCheckpointSets;
use PoP\ComponentModel\FieldResolvers\FieldResolverInterface;

trait UserStateFieldValueResolverTrait
{
    /**
     * If the user is not logged in, and environment variable `DISABLE_USER_STATE_FIELDS_IF_USER_NOT_LOGGED_IN` is true,
     * then do not register field names
     *
     * @return boolean
     */
    public static function registerFieldNames(): bool
    {
        if (Environment::disableUserStateFieldsIfUserNotLoggedIn()) {
            $engine = EngineFacade::getInstance();
            $validation = $engine->validateCheckpoints(UserStateCheckpointSets::LOGGEDIN_DATAFROMSERVER);
            // If the validation fails, then do not register the fields
            return !GeneralUtils::isError($validation);
        }
        return true;
    }

    protected function getValidationCheckpoints(FieldResolverInterface $fieldResolver, $resultItem, string $fieldName, array $fieldArgs = []): ?array
    {
        return UserStateCheckpointSets::LOGGEDIN_DATAFROMSERVER;
    }

    protected function getValidationCheckpointsErrorMessage(FieldResolverInterface $fieldResolver, $resultItem, string $fieldName, array $fieldArgs = []): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return sprintf(
            $translationAPI->__('You must be logged in to execute field \'%s\'', ''),
            $fieldName
        );
    }
}
