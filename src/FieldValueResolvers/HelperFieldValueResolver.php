<?php
namespace PoP\UserState\FieldValueResolvers;

use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\FieldResolvers\FieldResolverInterface;
use PoP\ComponentModel\FieldValueResolvers\AbstractOperatorOrHelperFieldValueResolver;
use PoP\Users\Dataloader_ConvertibleUserList;
use PoP\ComponentModel\Engine_Vars;

class HelperFieldValueResolver extends AbstractOperatorOrHelperFieldValueResolver
{
    use UserStateFieldValueResolverTrait;

    public static function getFieldNamesToResolve(): array
    {
        if (!self::registerFieldNames()) {
            return [];
        }
        return [
            'me',
        ];
    }

    public function getSchemaFieldType(FieldResolverInterface $fieldResolver, string $fieldName): ?string
    {
        $types = [
            'me' => SchemaDefinition::TYPE_ID,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($fieldResolver, $fieldName);
    }

    public function getSchemaFieldDescription(FieldResolverInterface $fieldResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'me' => $translationAPI->__('My user ID (user must be logged in)', 'user-state'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($fieldResolver, $fieldName);
    }

    public function resolveValue(FieldResolverInterface $fieldResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        switch ($fieldName) {
            case 'me':
                $vars = Engine_Vars::getVars();
                return $vars['global-userstate']['current-user-id'];
        }

        return parent::resolveValue($fieldResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }

    public function resolveFieldDefaultDataloaderClass(FieldResolverInterface $fieldResolver, string $fieldName, array $fieldArgs = []): ?string
    {
        switch ($fieldName) {
            case 'me':
                return Dataloader_ConvertibleUserList::class;
        }

        return parent::resolveFieldDefaultDataloaderClass($fieldResolver, $fieldName, $fieldArgs);
    }
}
