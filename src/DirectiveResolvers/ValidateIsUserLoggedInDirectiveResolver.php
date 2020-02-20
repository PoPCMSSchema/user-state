<?php
namespace PoP\UserState\DirectiveResolvers;

use PoP\ComponentModel\Feedback\Tokens;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Facades\Engine\EngineFacade;
use PoP\UserState\CheckpointSets\UserStateCheckpointSets;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\DirectiveResolvers\ValidateDirectiveResolver;
use PoP\ComponentModel\GeneralUtils;

class ValidateIsUserLoggedInDirectiveResolver extends ValidateDirectiveResolver
{
    const DIRECTIVE_NAME = 'validateIsUserLoggedIn';
    public static function getDirectiveName(): string {
        return self::DIRECTIVE_NAME;
    }

    /**
     * Check if the user is logged in
     *
     * @param TypeResolverInterface $typeResolver
     * @param array $dataFields
     * @param array $schemaErrors
     * @param array $schemaWarnings
     * @param array $schemaDeprecations
     * @param array $variables
     * @return void
     */
    protected function validateFields(TypeResolverInterface $typeResolver, array $dataFields, array &$schemaErrors, array &$schemaWarnings, array &$schemaDeprecations, array &$variables, array &$failedDataFields): void
    {
        $checkpointSet = UserStateCheckpointSets::LOGGEDIN_DATAFROMSERVER;
        $engine = EngineFacade::getInstance();
        $validation = $engine->validateCheckpoints($checkpointSet);
        if (GeneralUtils::isError($validation)) {
            $translationAPI = TranslationAPIFacade::getInstance();
            // All fields failed
            $failedDataFields = array_merge(
                $failedDataFields,
                $dataFields
            );
            $schemaErrors[] = [
                Tokens::PATH => $dataFields,
                Tokens::MESSAGE => sprintf(
                    $translationAPI->__('You must be logged in to access fields: \'%s\'', 'user-state'),
                    implode(
                        $translationAPI->__('\', \''),
                        $dataFields
                    )
                )
            ];
        }
    }
}
