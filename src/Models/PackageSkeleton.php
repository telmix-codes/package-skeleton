<?php

namespace ProcessMaker\Package\PackageSkeleton\Models;

use ProcessMaker\Models\ProcessMakerModel;

class PackageSkeleton extends ProcessMakerModel
{
    protected $table = 'package_skeleton';

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'description',
        'code',
        'status'
    ];
}
