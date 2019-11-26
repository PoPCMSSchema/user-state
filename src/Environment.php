<?php
namespace PoP\UserState;

class Environment
{
    public static function showUserStateFieldsInSchemaIfUserNotLoggedIn(): bool
    {
        return isset($_ENV['SHOW_USER_STATE_FIELDS_IN_SCHEMA_IF_USER_NOT_LOGGED_IN']) ? strtolower($_ENV['SHOW_USER_STATE_FIELDS_IN_SCHEMA_IF_USER_NOT_LOGGED_IN']) == "true" : true;
    }
}

