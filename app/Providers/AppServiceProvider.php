<?php

namespace App\Providers;

use App\Repositories\Concretes\BrandRepository;
use App\Repositories\Concretes\CategoryRepository;
use App\Repositories\Concretes\CustomerRepository;
use App\Repositories\Concretes\DashboardRepository;
use App\Repositories\Concretes\MonthlyReportRepository;
use App\Repositories\Concretes\OrderRepository;
use App\Repositories\Concretes\ProductRepository;
use App\Repositories\Concretes\SeederRepository;
use App\Repositories\IBrandRepository;
use App\Repositories\ICategoryRepository;
use App\Repositories\ICustomerRepository;
use App\Repositories\IDashboardRepository;
use App\Repositories\IMonthlyReportRepository;
use App\Repositories\IOrderRepository;
use App\Repositories\IProductRepository;
use App\Repositories\ISeederRepository;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\CustomerService;
use App\Services\DashboardService;
use App\Services\Exports\MonthlyReportExportExcelService;
use App\Services\FirebaseStorageService;
use App\Services\MonthlyReportService;
use App\Services\OrderExportCsvService;
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
        $this->app->bind(ISeederRepository::class, SeederRepository::class);

        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(IBrandRepository::class, BrandRepository::class);
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(ICustomerRepository::class, CustomerRepository::class);
        $this->app->bind(IOrderRepository::class, OrderRepository::class);
        $this->app->bind(IMonthlyReportRepository::class, MonthlyReportRepository::class);
        $this->app->bind(IDashboardRepository::class, DashboardRepository::class);

        $this->app->singleton(StorageService::class, function () {
            return new StorageService();
        });
        $this->app->singleton(FirebaseStorageService::class, function () {
            return new FirebaseStorageService();
        });

        $this->app->instance(
            CategoryService::class,
            new CategoryService(
                $this->app->make(ICategoryRepository::class),
                $this->app->make(StorageService::class),
                $this->app->make(FirebaseStorageService::class)
            )
        );

        $this->app->instance(
            BrandService::class,
            new BrandService(
                $this->app->make(IBrandRepository::class),
                $this->app->make(StorageService::class),
                $this->app->make(FirebaseStorageService::class)
            )
        );

        $this->app->instance(
            ProductService::class,
            new ProductService(
                $this->app->make(IProductRepository::class),
                $this->app->make(StorageService::class),
                $this->app->make(FirebaseStorageService::class)
            )
        );

        $this->app->instance(
            CustomerService::class,
            new CustomerService(
                $this->app->make(ICustomerRepository::class)
            )
        );

        $this->app->instance(
            OrderService::class,
            new OrderService(
                $this->app->make(IOrderRepository::class)
            )
        );
        $this->app->instance(
            OrderExportCsvService::class,
            new OrderExportCsvService(
                $this->app->make(IOrderRepository::class)
            )
        );

        $this->app->instance(
            MonthlyReportService::class,
            new MonthlyReportService(
                $this->app->make(IMonthlyReportRepository::class)
            )
        );
        $this->app->instance(
            MonthlyReportExportExcelService::class,
            new MonthlyReportExportExcelService(
                $this->app->make(IMonthlyReportRepository::class)
            )
        );

        $this->app->instance(
            DashboardService::class,
            new DashboardService(
                $this->app->make(IDashboardRepository::class)
            )
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
