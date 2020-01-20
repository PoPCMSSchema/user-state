<?php
namespace PoP\UserState\Hooks;

use PoP\Engine\Hooks\AbstractHookSet;
use PoP\UserState\FieldResolvers\GlobalFieldResolver;

class DBEntriesHooks extends AbstractHookSet
{
    protected function init()
    {
        $this->hooksAPI->addFilter(
            'PoP\ComponentModel\Engine:moveEntriesUnderDBName:dbName-dataFields',
            array($this, 'moveEntriesUnderDBName'),
            10,
            2
        );
    }

    public function moveEntriesUnderDBName($dbname_datafields, $typeResolver)
    {
        $dbname_datafields['userstate'] = $this->hooksAPI->applyFilters(
            'PoP\UserState\DataloaderHooks:metaFields',
            GlobalFieldResolver::getFieldNamesToResolve()
        );
        return $dbname_datafields;
    }
}