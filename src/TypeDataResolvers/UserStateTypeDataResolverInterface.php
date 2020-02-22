<?php
namespace PoP\UserState\TypeDataResolvers;

interface UserStateTypeDataResolverInterface {

    public function isUserLoggedIn(): bool;
    public function getCurrentUser();
    public function getCurrentUserID();
}
