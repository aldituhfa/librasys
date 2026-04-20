<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {

            $pendingCount = Transaction::where('status', 'pending')->count();

            $approvedCount = 0;

            if (Auth::check()) {
                $approvedCount = Transaction::where('user_id', Auth::id())
                    ->where('status', 'approved')
                    ->count();
            }

            $view->with([
                'pendingCount' => $pendingCount,
                'approvedCount' => $approvedCount
            ]);
        });
    }
}
