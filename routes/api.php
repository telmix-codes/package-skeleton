<?php

use ProcessMaker\Package\PackageSkeleton\Http\Controllers\PackageSkeletonController;

Route::group(['middleware' => ['auth:api', 'bindings']], function () {
    Route::get('admin/package-skeleton/fetch', [PackageSkeletonController::class, 'fetch'])->name('package.skeleton.fetch');
    // Route::apiResource('admin/package-skeleton', PackageSkeletonController::class);
    Route::post(
        'admin/package-skeleton',
        [PackageSkeletonController::class, 'store']
    )->name('package.skeleton.store');
    Route::patch('admin/package-skeleton/{id}', [PackageSkeletonController::class, 'update'])->name('package.skeleton.update');
});
