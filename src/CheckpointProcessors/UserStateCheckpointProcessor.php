<?php
namespace PoP\UserState\CheckpointProcessors;

use PoP\ComponentModel\CheckpointProcessorBase;
use PoP\ComponentModel\State\ApplicationState;
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
        $vars = ApplicationState::getVars();
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
