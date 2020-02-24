<?php
namespace PoP\UserState\TypeResolverDecorators;

use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\ComponentModel\TypeResolverDecorators\AbstractTypeResolverDecorator;
use PoP\UserState\DirectiveResolvers\ValidateIsUserLoggedInDirectiveResolver;

abstract class AbstractValidateIsUserLoggedInForDirectivesTypeResolverDecorator extends AbstractTypeResolverDecorator
{
    /**
     * Verify that the user is logged in before checking the roles/capabilities
     *
     * @param TypeResolverInterface $typeResolver
     * @return array
     */
    public function getMandatoryDirectivesForDirectives(TypeResolverInterface $typeResolver): array
    {
        $mandatoryDirectivesForDirectives = [];
        $fieldQueryInterpreter = FieldQueryInterpreterFacade::getInstance();
        // This is the required "validateIsUserLoggedIn" directive
        $validateIsUserLoggedInDirective = $fieldQueryInterpreter->getDirective(
            ValidateIsUserLoggedInDirectiveResolver::getDirectiveName()
        );
        // Add the mapping
        foreach ($this->getDirectiveResolverClasses() as $needValidateIsUserLoggedInDirective) {
            $mandatoryDirectivesForDirectives[$needValidateIsUserLoggedInDirective::getDirectiveName()] = [
                $validateIsUserLoggedInDirective,
            ];
        }
        return $mandatoryDirectivesForDirectives;
    }
    /**
     * Provide the classes for all the directiveResolverClasses that need the "validateIsUserLoggedIn" directive
     *
     * @return array
     */
    abstract protected function getDirectiveResolverClasses(): array;
}
