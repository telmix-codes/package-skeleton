<?php

namespace ProcessMaker\Package\PackageSkeleton\Http\Controllers;

use ProcessMaker\Http\Controllers\Controller;
use ProcessMaker\Http\Resources\ApiCollection;
use ProcessMaker\Package\PackageSkeleton\Models\Sample;
use ProcessMaker\Package\PackageSkeleton\Models\PackageSkeleton;
use RBAC;
use Illuminate\Http\Request;
use URL;

class PackageSkeletonController extends Controller
{
    public function index()
    {
        return view('package-skeleton::index');
    }

    public function fetch(Request $request)
    {
        $query = PackageSkeleton::query();

        $filter = $request->input('filter', '');
        if (!empty($filter)) {
            $filter = '%' . $filter . '%';
            $query->where(function ($query) use ($filter) {
                $query->Where('name', 'like', $filter);
            });
        }

        $order_by = $request->has('order_by') ? $order_by = $request->get('order_by') : 'name';
        $order_direction = $request->has('order_direction') ? $request->get('order_direction') : 'ASC';

        $response =
            $query->orderBy(
                $request->input('order_by', $order_by),
                $request->input('order_direction', $order_direction)
            )->paginate($request->input('per_page', 10));

        return new ApiCollection($response);
    }

    public function store(Request $request)
    {
        $sample = new PackageSkeleton();
        $sample->fill($request->json()->all());
        $sample->saveOrFail();
        return $sample;
    }

    public function update(Request $request, $id)
    {
        PackageSkeleton::where('id', $id)->update([
            'uuid' => $request->get("uuid"),
            'name' => $request->get("name"),
            'description' => $request->get("description"),
            'code' => $request->get("code"),
            'status' => $request->get("status")
        ]);
        return response([], 204);
    }

    public function destroy($id)
    {
        PackageSkeleton::find($id)->delete();
        return response([], 204);
    }

    public function generate($license_generator)
    {
    }
}
