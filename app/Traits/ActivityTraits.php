<?php
namespace App\Traits;
use App\Models\Activity;
use carbon\carbon;
use Illuminate\Support\Facades\Auth;

trait ActivityTraits
{
    public function logCreateActivity($data, $message)
    {
        $user = \auth()->user();
        $attributes = $this->unsetAttributes($data);
        $properties = [
            'attributes' => $attributes->toArray()
        ];
        $activity = activity()
            ->useLog('CREATE')
            ->causedBy($user)
            ->performedOn($data)
            ->withProperties($properties)
            ->log($user->name .' Create '. $message);

        return true;
    }

    public function logUpdateActivity($data, $message)
    {
        $user = \auth()->user();
        $attributes = $this->unsetAttributes($data);
        $properties = [
            'attributes' => $attributes->toArray()
        ];

        $activity = activity()
            ->useLog('UPDATE')
            ->causedBy(Auth::user())
            ->performedOn($data)
            ->withProperties($properties)
            ->log($user->name .' Update '. $message);

        return true;
    }

    public function logDeleteActivity($data, $message)
    {
        $user = \auth()->user();
        $attributes = $this->unsetAttributes($data);
        $properties = [
            'attributes' => $attributes->toArray()
        ];

        $activity = activity()
            ->useLog('DELETE')
            ->causedBy(Auth::user())
            ->performedOn($data)
            ->withProperties($properties)
            ->log($user->name .' Delete '. $message);

        return true;
    }

    public function logLoginDetails()
    {
        $user = \auth()->user();
        $updated_at = Carbon::now()->format('d/m/Y H:i:s');
        $properties = [
            'attributes' =>['name'=>$user->email,'description'=>'Login into the system by '.$updated_at]
        ];

        //$changes = 'User '.$user->email.' loged in into the system';

        $activity = activity()
            ->useLog('LOGIN')
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties($properties)
            ->log($user->name. ' has been logged in');

        return true;
    }

    public function logLogoutDetails()
    {
        $user = \auth()->user();
        $updated_at = Carbon::now()->format('d/m/Y H:i:s');
        $properties = [
            'attributes' =>['name'=>$user->email,'description'=>'Logout from system by '.$updated_at]
        ];

        $activity = activity()
            ->useLog('LOGOUT')
            ->causedBy($user)
            ->performedOn($user)
            ->withProperties($properties)
            ->log($user->name. ' has been logged out');

        return true;
    }

    public function logGeneral($data, $changes)
    {
        $updated_at = Carbon::now()->format('d/m/Y H:i:s');
        $properties = [
            'attributes' =>['data'=>$data,'description'=>$updated_at]
        ];

        $activity = activity()
            ->causedBy(\Auth::user())
            ->performedOn($data)
            ->withProperties($properties)
            ->log($changes);

        return true;
    }

    public function unsetAttributes($model){
        unset($model->created_at);
        unset($model->updated_at);
        return $model;
    }

}
