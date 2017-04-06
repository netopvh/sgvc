<?php
/**
 * Created by PhpStorm.
 * User: angelo.neto
 * Date: 29/03/2017
 * Time: 16:29
 */

namespace App\Scopes;


use Adldap\Laravel\Scopes\ScopeInterface;
use Adldap\Query\Builder;

class AccountingScope implements ScopeInterface
{

    /**
     * Apply the scope to a given LDAP query builder.
     *
     * @param Builder $query
     *
     * @return void
     */
    public function apply(Builder $query)
    {
        $accounting = 'CN=Gestores,OU=SGVC,OU=ADINF,OU=Livre,DC=fiero,DC=org';

        $query->whereMemberOf($accounting);
    }

}