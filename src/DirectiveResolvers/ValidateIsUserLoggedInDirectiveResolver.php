<?php
namespace PoP\UserState\DirectiveResolvers;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\UserState\CheckpointSets\UserStateCheckpointSets;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\DirectiveResolvers\AbstractValidateCheckpointDirectiveResolver;

class ValidateIsUserLoggedInDirectiveResolver extends AbstractValidateCheckpointDirectiveResolver
{
    const DIRECTIVE_NAME = 'validateIsUserLoggedIn';
    public static function getDirectiveName(): string {
        return self::DIRECTIVE_NAME;
    }

    protected function getValidationCheckpointSet(TypeResolverInterface $typeResolver): array
    {
        return UserStateCheckpointSets::LOGGEDIN_DATAFROMSERVER;
    }

    protected function getValidationCheckpointErrorMessage(TypeResolverInterface $typeResolver, array $failedDataFields): string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return sprintf(
            $translationAPI->__('You must be logged in to access fields \'%s\'', 'user-state'),
            implode(
                $translationAPI->__('\', \''),
                $failedDataFields
            )
        );
    }
}
