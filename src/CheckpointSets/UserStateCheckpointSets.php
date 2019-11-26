<?php
namespace PoP\UserState\CheckpointSets;

use PoP\UserState\CheckpointProcessors\UserStateCheckpointProcessor;

class UserStateCheckpointSets
{
    const NOTLOGGEDIN = array(
        [UserStateCheckpointProcessor::class, UserStateCheckpointProcessor::USERNOTLOGGEDIN_SUBMIT],
    );
    const LOGGEDIN_STATIC = array(
        [UserStateCheckpointProcessor::class, UserStateCheckpointProcessor::USERLOGGEDIN_SUBMIT],
    );
    const LOGGEDIN_DATAFROMSERVER = array(
        [UserStateCheckpointProcessor::class, UserStateCheckpointProcessor::USERLOGGEDIN],
    );
}

