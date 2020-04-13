<?php
namespace PoP\UserState\CheckpointSets;

use PoP\Engine\CheckpointProcessors\RequestCheckpointProcessor;
use PoP\UserState\CheckpointProcessors\UserStateCheckpointProcessor;

class UserStateCheckpointSets
{
    const NOTLOGGEDIN = array(
        [RequestCheckpointProcessor::class, RequestCheckpointProcessor::DOING_POST],
        [UserStateCheckpointProcessor::class, UserStateCheckpointProcessor::USERNOTLOGGEDIN],
    );
    const LOGGEDIN_STATIC = array(
        [RequestCheckpointProcessor::class, RequestCheckpointProcessor::DOING_POST],
        [UserStateCheckpointProcessor::class, UserStateCheckpointProcessor::USERLOGGEDIN],
    );
    const LOGGEDIN_DATAFROMSERVER = array(
        [UserStateCheckpointProcessor::class, UserStateCheckpointProcessor::USERLOGGEDIN],
    );
}
