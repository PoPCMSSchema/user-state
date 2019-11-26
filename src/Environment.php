<?php
namespace PoP\UserState;

class Environment
{
    public static function disableUserStateFieldsIfUserNotLoggedIn(): bool
    {
        return isset($_ENV['DISABLE_USER_STATE_FIELDS_IF_USER_NOT_LOGGED_IN']) ? strtolower($_ENV['DISABLE_USER_STATE_FIELDS_IF_USER_NOT_LOGGED_IN']) == "true" : false;
    }
}

