<?php

namespace App\Providers;

use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\IBrandRepository;
use App\Repositories\ICategoryRepository;
use App\Repositories\ICustomerRepository;
use App\Repositories\IOrderRepository;
use App\Repositories\IProductRepository;
use App\Repositories\ISeederRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SeederRepository;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\CustomerService;
use App\Services\FirebaseStorageService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\StorageService;
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
        $this->app->singleton(StorageService::class, function () {
            return new StorageService();
        });
        $this->app->singleton(FirebaseStorageService::class, function () {
            return new FirebaseStorageService();
        });

        $this->app->bind(ISeederRepository::class, SeederRepository::class);

        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->instance(
            CategoryService::class,
            new CategoryService(
                $this->app->make(ICategoryRepository::class),
                $this->app->make(StorageService::class),
                $this->app->make(FirebaseStorageService::class)
            )
        );

        $this->app->bind(IBrandRepository::class, BrandRepository::class);
        $this->app->instance(
            BrandService::class,
            new BrandService(
                $this->app->make(IBrandRepository::class),
                $this->app->make(StorageService::class),
                $this->app->make(FirebaseStorageService::class)
            )
        );

        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->instance(
            ProductService::class,
            new ProductService(
                $this->app->make(IProductRepository::class),
                $this->app->make(StorageService::class),
                $this->app->make(FirebaseStorageService::class)
            )
        );

        $this->app->bind(ICustomerRepository::class, CustomerRepository::class);
        $this->app->instance(
            CustomerService::class,
            new CustomerService(
                $this->app->make(ICustomerRepository::class)
            )
        );

        $this->app->bind(IOrderRepository::class, OrderRepository::class);
        $this->app->instance(
            OrderService::class,
            new OrderService(
                $this->app->make(IOrderRepository::class)
            )
        );
    }
}
