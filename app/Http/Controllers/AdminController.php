<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\SettingsUpdateRequest;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     *  Take all users created early 6 days.
     * 
     *  @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::select(DB::raw("COUNT(*) as count"), DB::raw("DAYNAME(created_at) as day_name"), DB::raw("DAY(created_at) as day"))
            ->where('created_at', '>', Carbon::today()->subDay(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }

        return view('backend.index')->with('users', json_encode($array));
    }

    /**
     *  Get the data of user profile.
     *  
     *  @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $profile = Auth::user();

        return view('backend.users.profile')->with('profile', $profile);
    }

    /**
     *  Update user profile.
     *  
     *  @param \Illuminate\Http\Request $request
     *  @param int $id
     *  @return \Illuminate\Http\Response
     */
    public function profileUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id != Auth::id()) {
            abort(404);
        }

        $data = $request->except('email');

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('/profiles/' . $filename);
            \Image::make($image)->resize(80, 80)->save($location);
            if ($user->photo != null) {
                Storage::delete($user->photo);
                unlink(public_path('/profiles/' . $user->photo));
            }
            $data['photo'] = $filename;
        }

        $status = $user->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Perfil atualizado com sucesso.');
        } else {
            request()->session()->flash('error', 'Erro ao atualizar o perfil. Por favor, tente novamente.');
        }

        return redirect()->back();
    }

    /**
     *  Change user password.
     * 
     *  @param \App\Http\Requests\PasswordUpdateRequest $request
     *  @return \Illuminate\Http\Response
     */
    public function changePassword(PasswordUpdateRequest $request)
    {
        User::findOrFail(Auth::id())->update(['password' => Hash::make($request->password)]);

        return redirect()->route('admin')->with('success', 'Senha atualizada com sucesso!');
    }

    /**
     *  See settings of website.
     * 
     *  @return \Illuminate\Http\Response
     */
    public function settings()
    {
        $data = Settings::first();

        return view('backend.settings')->with('data', $data);
    }

    /**
     *  Change settings of website.
     *  
     *  @param \App\Http\Requests\SettingsUpdateRequest $request
     *  @return \Illuminate\Http\Response
     */
    public function settingsUpdate(SettingsUpdateRequest $request)
    {
        $data = $request->all();

        $settings = Settings::first();

        if ($settings == null){
            Settings::create($data);
        }

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('frontend/img/' . $filename);
            \Image::make($image)->resize(2250, 1500)->save($location);
            if ($settings->logo != null) {
                Storage::delete($settings->logo);
                unlink(public_path('frontend/img/' . $settings->logo));
            }
            $data['logo'] = $filename;
        }

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('frontend/img/' . $filename);
            \Image::make($image)->resize(2250, 1500)->save($location);
            if ($settings->photo != null) {
                Storage::delete($settings->photo);
                unlink(public_path('frontend/img/' . $settings->photo));
            }
            $data['photo'] = $filename;
        }

        $status = $settings->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Configura????es alteradas com sucesso.');
        } else {
            request()->session()->flash('error', 'Erro ao alterar as configura????es. Por favor, tente novamente.');
        }

        return redirect()->route('admin');
    }
}
