<?php
namespace PoP\UserState\CheckpointProcessors;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\CheckpointProcessorBase;
use PoP\ComponentModel\Engine_Vars;
use PoP\ComponentModel\Error;

class UserStateCheckpointProcessor extends CheckpointProcessorBase
{
    public const USERLOGGEDIN = 'userloggedin';
    public const USERLOGGEDIN_SUBMIT = 'userloggedin-submit';
    public const USERNOTLOGGEDIN_SUBMIT = 'usernotloggedin-submit';

    public function getCheckpointsToProcess()
    {
        return array(
            [self::class, self::USERLOGGEDIN],
            [self::class, self::USERLOGGEDIN_SUBMIT],
            [self::class, self::USERNOTLOGGEDIN_SUBMIT],
        );
    }

    public function process(array $checkpoint)
    {
        $vars = Engine_Vars::getVars();
        $translationAPI = TranslationAPIFacade::getInstance();
        switch ($checkpoint[1]) {
            case self::USERLOGGEDIN:
                if (!$vars['global-userstate']['is-user-logged-in']) {
                    return new \PoP\ComponentModel\Error(
                        'usernotloggedin',
                        $translationAPI->__('The user must be logged in', '')
                    );
                }
                break;

            case self::USERLOGGEDIN_SUBMIT:
                if (!doingPost()) {
                    return new Error('notdoingpost');
                }

                if (!$vars['global-userstate']['is-user-logged-in']) {
                    return new Error('usernotloggedin');
                }
                break;

            case self::USERNOTLOGGEDIN_SUBMIT:
                if (!doingPost()) {
                    return new Error('notdoingpost');
                }

                if ($vars['global-userstate']['is-user-logged-in']) {
                    return new Error('userloggedin');
                }
                break;
        }

        return parent::process($checkpoint);
    }
}

