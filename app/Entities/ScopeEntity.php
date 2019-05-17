<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 17.05.19
 * Time: 15:57
 */

namespace App\Entities;


use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\ScopeTrait;

class ScopeEntity implements ScopeEntityInterface
{
    use EntityTrait, ScopeTrait;
}