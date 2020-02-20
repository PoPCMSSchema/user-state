<?php
namespace PoP\UserState\FieldResolvers;

use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldResolvers\AbstractGlobalFieldResolver;
use PoP\ComponentModel\Engine_Vars;
use PoP\Users\TypeResolvers\UserTypeResolver;

class GlobalFieldResolver extends AbstractGlobalFieldResolver
{
    use UserStateFieldResolverTrait;

    public static function getFieldNamesToResolve(): array
    {
        if (!self::registerFieldNames()) {
            return [];
        }
        return [
            'me',
            'isUserLoggedIn',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
            'me' => SchemaDefinition::TYPE_ID,
            'isUserLoggedIn' => SchemaDefinition::TYPE_BOOL,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'me' => $translationAPI->__('The logged-in user', 'user-state'),
            'isUserLoggedIn' => $translationAPI->__('Is the user logged-in?', 'user-state'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        switch ($fieldName) {
            case 'me':
                $vars = Engine_Vars::getVars();
                return $vars['global-userstate']['current-user-id'];
            case 'isUserLoggedIn':
                $vars = Engine_Vars::getVars();
                return $vars['global-userstate']['is-user-logged-in'];
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }

    public function resolveFieldTypeResolverClass(TypeResolverInterface $typeResolver, string $fieldName, array $fieldArgs = []): ?string
    {
        switch ($fieldName) {
            case 'me':
                return UserTypeResolver::class;
        }

        return parent::resolveFieldTypeResolverClass($typeResolver, $fieldName, $fieldArgs);
    }
}
