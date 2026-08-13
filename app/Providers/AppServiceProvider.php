<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use App\Observers\ProductObserver;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Product::observe(ProductObserver::class);

        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('d-m-Y H:i'); ?>";
        });

        Gate::before(function (User $user, $ability) {
            if($user->isAdmin()) {
                return true;
            }
        });

        View::composer ('posts.index', function ($view) {
            $view->with('latestPost', Post::latest()->first());
        });

        Collection::macro('toUpper', function () {
            return $this->map(function ($item) {
                return strtoupper($item);
            });
        });
    }
}
