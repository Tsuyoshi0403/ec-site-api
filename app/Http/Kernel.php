<?php

namespace App\Http;

use App\Http\Middleware\AccessTokenCheckMiddleware;
use App\Http\Middleware\AccountHolderMiddleware;
use App\Http\Middleware\AccountStopAdminMiddleware;
use App\Http\Middleware\AccountStopMemberMiddleware;
use App\Http\Middleware\AgentModeMiddleware;
use App\Http\Middleware\BeforeMiddleware;
use App\Http\Middleware\CheckForMaintenanceMode;
use App\Http\Middleware\CompanyLimitMiddleware;
use App\Http\Middleware\ExpenseManageMiddleware;
use App\Http\Middleware\ExpenseUsableMiddleware;
use App\Http\Middleware\LimitedAccessMiddleware;
use App\Http\Middleware\ProjectManageCheckMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        // \App\Http\Middleware\TrustProxies::class,
        // \Fruitcake\Cors\HandleCors::class,
        // CheckForMaintenanceMode::class,
        // BeforeMiddleware::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        // \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Illuminate\Http\Middleware\HandleCors::class
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            // \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'abilities' => \Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
        'ability' => \Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class,
        // 'auth.agent' => AgentModeMiddleware::class,
        // 'auth.company' => CompanyLimitMiddleware::class,
        // 'access-token.check' => AccessTokenCheckMiddleware::class,
        // 'account.check-member' => AccountStopMemberMiddleware::class,
        // 'account.check-admin' => AccountStopAdminMiddleware::class,
        // 'account-holder' => AccountHolderMiddleware::class,
        // 'project-manage-check' => ProjectManageCheckMiddleware::class,
        // 'option.expense' => ExpenseUsableMiddleware::class,
        // 'manage.expense' => ExpenseManageMiddleware::class,
        // 'auth.limited-access' => LimitedAccessMiddleware::class,
    ];
}
