<?php

declare(strict_types=1);

namespace PoPSchema\UserState\Hooks;

use PoP\Engine\Hooks\AbstractHookSet;
use PoP\Engine\FieldResolvers\OperatorGlobalFieldResolver;
use PoPSchema\UserState\Facades\UserStateTypeDataResolverFacade;

class VarsHooks extends AbstractHookSet
{
    protected function init()
    {
        $this->hooksAPI->addAction(
            'ApplicationState:addVars',
            array($this, 'addVars'),
            10,
            1
        );
        $this->hooksAPI->addAction(
            OperatorGlobalFieldResolver::HOOK_SAFEVARS,
            [$this, 'setSafeVars'],
            10,
            1
        );
    }

    /**
     * @param array<array> $vars_in_array
     */
    public function setSafeVars(array $vars_in_array): void
    {
        // Remove the current user object
        $safeVars = &$vars_in_array[0];
        unset($safeVars['global-userstate']['current-user']);
    }

    /**
     * Add the user's (non)logged-in state
     *
     * @param array<array> $vars_in_array
     */
    public function addVars(array $vars_in_array): void
    {
        $vars = &$vars_in_array[0];
        $vars['global-userstate'] = [];
        $userStateTypeDataResolver = UserStateTypeDataResolverFacade::getInstance();
        if ($userStateTypeDataResolver->isUserLoggedIn()) {
            $vars['global-userstate']['is-user-logged-in'] = true;
            $vars['global-userstate']['current-user'] = $userStateTypeDataResolver->getCurrentUser();
            $vars['global-userstate']['current-user-id'] = $userStateTypeDataResolver->getCurrentUserID();
        } else {
            $vars['global-userstate']['is-user-logged-in'] = false;
            $vars['global-userstate']['current-user'] = null;
            $vars['global-userstate']['current-user-id'] = null;
        }
    }
}
