<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

//     public function shownavbar()
// {
//     $notificationCount = Auth::user()->unreadNotifications->count();
//     return view('navbar.nav', compact(var_name: 'notificationCount'));
// }

    public function markNotificationAsRead($notificationId)
    {
        $notification = Auth::user()->notifications->find($notificationId);
        $notification->markAsRead();
        return redirect()->back();
    }
}
