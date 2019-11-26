<?php
namespace PoP\UserState\CheckpointProcessors;

use PoP\ComponentModel\CheckpointProcessorBase;
use PoP\ComponentModel\Engine_Vars;
use PoP\ComponentModel\Error;

class UserStateCheckpointProcessor extends CheckpointProcessorBase
{
    public const USERLOGGEDIN = 'userloggedin';
    public const USERNOTLOGGEDIN = 'usernotloggedin';

    public function getCheckpointsToProcess()
    {
        return array(
            [self::class, self::USERLOGGEDIN],
            [self::class, self::USERNOTLOGGEDIN],
        );
    }

    public function process(array $checkpoint)
    {
        $vars = Engine_Vars::getVars();
        switch ($checkpoint[1]) {
            case self::USERLOGGEDIN:
                if (!$vars['global-userstate']['is-user-logged-in']) {
                    return new Error('usernotloggedin');
                }
                break;

            case self::USERNOTLOGGEDIN:
                if ($vars['global-userstate']['is-user-logged-in']) {
                    return new Error('userloggedin');
                }
                break;
        }

        return parent::process($checkpoint);
    }
}

