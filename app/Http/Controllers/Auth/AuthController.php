<?php

namespace App\Http\Controllers\Auth;

use App\Models\Sys\Module;
use App\Traits\ActivityTraits;
use App\Traits\CustomResponse;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

use JWTAuth;

class AuthController extends BaseController
{

    use ActivityTraits;
    use CustomResponse;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->nip = $this->findUsername();
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */

    public function findUsername()
    {
        $login = request()->input('emailOrUsername');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    /**
     * Get username property.
     *
     * @return string
     */
    public function nip()
    {
        return $this->nip;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emailOrUsername' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->errorResponseData('Validation', $validator->errors(), 422);
        }


        $credentials = request([$this->nip, 'password']);
        $token = auth('api')->attempt($credentials);
        if (!$token) {
            return $this->errorResponse('message.auth_invalid', 401);
        }
        $this->logLoginDetails();
        return $this->respondWithToken($token);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users',
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return $this->errorResponseData('Validation', $validator->errors()->toJson(), 422);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return $this->successResponse('message.user_registered');
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        $this->logLogoutDetails();
        auth()->invalidate();
        return $this->successResponse('message.user_logout');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {
        $user = auth()->user()->load('roles');

        $permissions =  $user->getAllPermissions()->pluck('name');
        $menus = Module::with(['children'])->whereNull('parent_id')->orderBy('order', 'asc')->get();
        $menuFiltered = array();

        foreach ($menus as $parent){
            $menuFiltered[] = $this->searchPermissions($parent);
        }

        return $this->successResponseData(null, [
            'user' => $user,
            'menu' => $menuFiltered,
            'permissions' => $permissions
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {

        $user = auth()->user()->load('roles');

        $permissions =  $user->getAllPermissions()->pluck('name');
        $menus = Module::with(['children'])->whereNull('parent_id')->orderBy('order', 'asc')->get();
        $menuFiltered = array();

        foreach ($menus as $parent){
            $menuFiltered[] = $this->searchPermissions($parent);
        }

        return $this->successResponseData(
            'message.user_login',
            [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'permissions' => $permissions,
            'menu' => $menuFiltered,
            ]
        );
    }

    private function searchPermissions($menu){
        $user = auth()->user();
        $permissions =  $user->getAllPermissions()->pluck('name');
        $permArray = [];
        foreach ($permissions as $perm){
            $permArray[] = $perm;
        }
        $menuName = $menu['name'];
        $menuPerm = "read-$menuName";
        if (in_array($menuPerm , $permArray)) {

            $menuChild= array();
            foreach ($menu['children'] as $children){
                $menuNameChild = $children['name'];
                $menuPermC = "read-$menuNameChild";
                if (in_array($menuPermC , $permArray)) {
                    $menuChild[] = (object) [
                        'permission' => $menuPermC,
                        'route' => $children['route'],
                        'order' => $children['order'],
                        'label' => $children['label'],
                        'icon' => $children['icon'],
                        'name' => $children['name'],
                        'is_header' => $children['is_header'],
                        'is_group' => $children['is_group'],
                        'children' => $children,
                    ];
                }
            }

            return (object) [
                'permission' => $menuPerm,
                'route' => $menu['route'],
                'order' => $menu['order'],
                'label' => $menu['label'],
                'icon' => $menu['icon'],
                'name' => $menu['name'],
                'is_header' => $menu['is_header'],
                'is_group' => $menu['is_group'],
                'children' => $menuChild,
            ];
        }
    }


}
