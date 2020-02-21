<?php
namespace PoP\UserState\Conditional\CacheControl\TypeResolverDecorators;

use PoP\Users\TypeResolvers\UserTypeResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\ComponentModel\TypeResolverDecorators\AbstractTypeResolverDecorator;
use PoP\UserState\DirectiveResolvers\ValidateIsUserLoggedInDirectiveResolver;
use PoP\CacheControl\DirectiveResolvers\AbstractCacheControlDirectiveResolver;

class UserTypeResolverDecorator extends AbstractTypeResolverDecorator
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            UserTypeResolver::class,
        );
    }

    /**
     * If validating if the user is logged-in, then we can't cache the response
     *
     * @param TypeResolverInterface $typeResolver
     * @return array
     */
    public function getMandatoryDirectivesForDirectives(TypeResolverInterface $typeResolver): array
    {
        $fieldQueryInterpreter = FieldQueryInterpreterFacade::getInstance();
        return [
            ValidateIsUserLoggedInDirectiveResolver::getDirectiveName() => [
                $fieldQueryInterpreter->composeDirective(
                    AbstractCacheControlDirectiveResolver::getDirectiveName(),
                    $fieldQueryInterpreter->getFieldArgsAsString([
                        'maxAge' => 0,
                    ])
                )
            ]
        ];
    }
}
