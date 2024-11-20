<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * App\Models\Auth
 *
 * @method static BaseBuilder|Auth newModelQuery()
 * @method static BaseBuilder|Auth newQuery()
 * @method static BaseBuilder|Auth query()
 * @method static BaseBuilder|Auth count(string $columns = '*')
 * @method static BaseBuilder|Auth softDelete()
 * @mixin \Eloquent
 */
class Auth extends ModelBase implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use MustVerifyEmail;
}
