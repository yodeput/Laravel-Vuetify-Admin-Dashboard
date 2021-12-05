<?php

namespace App\Observers;

use App\Events\DataTracker;
use Illuminate\Support\Facades\Auth;

class SignatureObserver
{
    public function creating($model)
    {
        $model->created_by = $this->getId();
        $model->updated_by = $this->getId();
    }

    public function updating($model)
    {
        $model->updated_by = $this->getId();
    }

    public function deleting($model)
    {
        $model->deleted_by = $this->getId();
    }

    public function created($model)
    {
        $this->sendNotification($model);
    }

    public function updated($model)
    {
        $this->sendNotification($model);
    }

    public function deleted($model)
    {
        $this->sendNotification($model);
    }

    public function getId(){
        return Auth::id() ?: 0;
    }

    public function sendNotification($model){
        event(new DataTracker(get_class($model)));
    }
}
