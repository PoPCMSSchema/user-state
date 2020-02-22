<?php
namespace PoP\UserState\FieldResolvers;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\UserState\CheckpointSets\UserStateCheckpointSets;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;

trait UserStateFieldResolverTrait
{
    protected function getValidationCheckpoints(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = []): ?array
    {
        return UserStateCheckpointSets::LOGGEDIN_DATAFROMSERVER;
    }

    protected function getValidationCheckpointsErrorMessage(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = []): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return sprintf(
            $translationAPI->__('You must be logged in to access field \'%s\'', ''),
            $fieldName
        );
    }
}
