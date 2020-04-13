<?php

declare(strict_types=1);

namespace PoP\UserState\Hooks;

use PoP\Engine\Hooks\AbstractHookSet;
use PoP\Engine\FieldResolvers\OperatorGlobalFieldResolver;
use PoP\UserState\Facades\UserStateTypeDataResolverFacade;

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

    public function setSafeVars($vars_in_array)
    {
        // Remove the current user object
        $safeVars = &$vars_in_array[0];
        unset($safeVars['global-userstate']['current-user']);
    }

    /**
     * Add the user's (non)logged-in state
     */
    public function addVars($vars_in_array)
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
