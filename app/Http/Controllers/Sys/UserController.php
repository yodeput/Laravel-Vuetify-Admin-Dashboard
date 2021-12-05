<?php

namespace App\Http\Controllers\Sys;


use App\Exports\UserExport;
use App\Helpers\Upload;
use App\Models\User as Model;

use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;

use App\Traits\ActivityTraits;
use App\Traits\CustomResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use PDF;
use Excel;

class UserController extends Controller
{
    use ActivityTraits;

    public function validateSave()
    {
        return Validator::make(request()->all(), [
            'name' => 'required|string',
            'nip' => 'required|string|unique:syssr',
            'email' => 'required|email|unique:syssr',
            //'password' => 'required|string|min:6',
        ]);
    }

    public function validateUpdate($request)
    {
        return Validator::make(request()->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:syssr,email,' . $request->id,
            'nip' => 'required|string|unique:syssr,nip,' . $request->id,
            //'password' => 'required|string|min:6',
        ]);
    }

    public function filter(Request $request)
    {
        $query = Model::withTrashed()->with(['roles']);

        $advance = $request->advance;

        if ($request->search) {
            $search = strtolower(trim($request->search));
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('username', 'LIKE', '%' . $search . '%');
        }

        $data = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.desc') === 'true' ? 'DESC' : 'ASC')
            ->paginate($request->input('per_page'));

        return response()->json($data)->header('TotalActive',Model::count())->header('TotalDeleted',Model::onlyTrashed()->count());
    }

    public function show($id)
    {

        $data =  Model::withTrashed()->with(['roles'])->findOrFail($id);
        return $this->successResponseData(null, $data);
    }

    public function store(Request $request)
    {
        $validator = $this->validateSave();
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        $user = Model::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'address' => $request->address,
            'office_id' => $request->office_id,
            'phone' => $request->phone,
            'password' => Hash::make($request->password ? $request->password : 'pass@word1'),
        ]);

        $role = Arr::pluck($request->roles, ['id']);
        $user->assignRole($role);

        $user->image = (new Upload())->uploadPicture('avatar', $user, $request->image);
        $user->save();
        $this->logCreateActivity($user, 'User: ' . $user->name);
        return $this->successResponse('message.data_created', 200);
    }

    public function update(Request $request)
    {

        $validator = $this->validateUpdate($request);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        $user = Model::find($request->id);
        $userUpdate = $request->except('image');
        $user->update($userUpdate);
        $user->image = (new Upload())->uploadPicture('avatar', $user, $request->image);
        $user->save();
        $role = Arr::pluck($request->roles, ['id']);
        $user->syncRoles([$role]);

        $this->logUpdateActivity($user, 'User: ' . $user->name);
        if($user->email_verified_at === null){
            event(new Registered($user));
        }
        return $this->successResponse('message.data_updated', 200);

    }

    public function destroy($id)
    {
        Model::destroy($id);
        return $this->successResponse('message.data_deleted', 200);
    }

    public function restore($id)
    {
        Model::withTrashed()->findOrFail($id)->restore();
        return $this->successResponse('message.data_restored', 200);
    }

    public function forceDestroy($id)
    {
        Model::withTrashed()->findOrFail($id)->forceDelete();
        return $this->successResponse('message.data_delete_permanently', 200);
    }


    public function getUserRoles($user)
    {
        $user = Model::findOrFail($user);
        $user->getRoleNames();
        return $this->successResponse($user);
    }

    public function getUserMe()
    {
        return $this->successResponse(auth()->user());
    }


    public function exportPdf()
    {
        $user = Model::with('office')->get();
        $pdf = PDF::loadview('pdf.user',['user'=>$user]);
        $now = date('YmdHis');
        return $pdf->stream();
    }

    public function exportExcel()
    {
        $now = date('YmdHis');
        return Excel::download(new UserExport, "idface_user_data_$now.xlsx");
    }
}
