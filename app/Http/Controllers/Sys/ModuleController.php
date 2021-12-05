<?php

namespace App\Http\Controllers\Sys;

use App\Helpers\Upload;
use App\Traits\ActivityTraits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sys\Module as Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ModuleController extends Controller
{

    use ActivityTraits;

    public function validateRequest()
    {
        return Validator::make(request()->all(), [
            'name' => 'required|string|unique:sysmdls',
            'label' => 'required|string',
            'route' => 'required|string',
            'icon' => 'required|string',
            'order' => 'required|integer',
            'is_header' => 'required|boolean',
            'is_group' => 'required|boolean',
        ]);
    }

    public function filter(Request $request)
    {
        $query = Model::withTrashed()->with('children')->whereNull('parent_id');

        $advance = $request->advance;

        if ($request->search) {
            $search = strtolower(trim($request->search));
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('label', 'LIKE', '%' . $search . '%')
                ->orWhere('route', 'LIKE', '%' . $search . '%');
        }

        $data = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.desc') === 'true' ? 'DESC' : 'ASC')->get();

        return $this->successResponse($data);
    }

    public function show($id)
    {

        $data =  Model::withTrashed()->with('parent')->findOrFail($id);
        return $this->successResponse($data);
    }

    public function store(Request $request)
    {
        $validator = $this->validateRequest();
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        $data = Model::create($request->all());

        return $this->successResponse($data, 'Module Created', 201);
    }

    public function update(Request $request)
    {

        $data = Model::find($request->id);
        $dataUpdate = $request->all();
        $data->update($dataUpdate);

        return $this->successResponse($data);

    }

    public function destroy($id)
    {
        Model::destroy($id);
        return $this->successResponse(null, 'Module Deleted');
    }

    public function restore($id)
    {
        Model::withTrashed()->findOrFail($id)->restore();
        return $this->successResponse(null, 'Module Restored');
    }

    public function forceDestroy($id)
    {
        Model::withTrashed()->findOrFail($id)->forceDelete();
        return $this->successResponse(null, 'Module Force Deleted');
    }

    public function count()
    {

        $data = [
            'all' => Model::count(),
            'deleted' => Model::onlyTrashed()->count(),
        ];
        return $this->successResponse($data);
    }
}
