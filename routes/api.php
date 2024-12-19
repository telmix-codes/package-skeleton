<?php

use ProcessMaker\Package\PackageSkeleton\Http\Controllers\PackageSkeletonController;

Route::group(['middleware' => ['auth:api', 'bindings']], function () {
    Route::get('admin/package-skeleton/fetch', [PackageSkeletonController::class, 'fetch'])->name('package.skeleton.fetch');
    Route::post(
        'admin/package-skeleton',
        [PackageSkeletonController::class, 'store']
    )->name('package.skeleton.store');
    Route::patch('admin/package-skeleton/{id}', [PackageSkeletonController::class, 'update'])->name('package.skeleton.update');
    Route::delete('admin/package-skeleton/{id}', [PackageSkeletonController::class, 'destroy'])->name('package.skeleton.destroy');
});
