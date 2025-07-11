<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\{
    EquipmentRepository,
    RepairRequestRepository,
    UserRepository
};
use App\Repositories\Contracts\{
    EquipmentRepositoryInterface,
    RepairRequestRepositoryInterface,
    UserRepositoryInterface
};

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            EquipmentRepositoryInterface::class,
            EquipmentRepository::class
        );

        $this->app->bind(
            RepairRequestRepositoryInterface::class,
            RepairRequestRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}