<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $notification = Auth::user()->notifications()->where('id', $request->id)->firstOrFail();

        $notification->markAsRead();
        
        return redirect($notification->data['actionURL']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);

        $status = $notification->delete();

        if ($status) {
            request()->session()->flash('success', 'Notificação deletada com sucesso.');
            return back();
        } else {
            request()->session()->flash('error', 'Algo errado aconteceu... Tente novamente.');
            return back();
        }
    }
}
