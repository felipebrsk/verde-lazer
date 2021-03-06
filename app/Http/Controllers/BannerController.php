<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BannerRequest;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::orderBy('id', 'DESC')->paginate(10);

        return view('backend.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BannerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {
        $data = $request->all();

        $slug = Str::slug($request->title);

        $count = Banner::where('slug', $slug)->count();

        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }

        $data['slug'] = $slug;

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('frontend/banners/' . $filename);
            \Image::make($image)->resize(1200, 809)->save($location);
            $data['photo'] = $filename;
        }

        $status = Banner::create($data);

        if ($status) {
            request()->session()->flash('success', 'Banner adicionado com sucesso.');

        } else {
            request()->session()->flash('error', 'Erro ao criar o banner. Por favor, tente novamente.');
        }

        return redirect()->route('banners.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);

        return view('backend.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BannerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('frontend/banners/' . $filename);
            \Image::make($image)->resize(1200, 809)->save($location);
            if ($banner->photo != null) {
                Storage::delete($banner->photo);
                unlink(public_path('frontend/banners/' . $banner->photo));
            }
            $data['photo'] = $filename;
        }

        $status = $banner->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Banner atualizado com sucesso.');
        } else {
            request()->session()->flash('error', 'Erro ao atualizar o banner. Por favor, tente novamente.');
        }
        return redirect()->route('banners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        $status = $banner->delete();

        if ($status) {
            Storage::delete($banner->photo);
            unlink(public_path('frontend/banners/' . $banner->photo));
            
            request()->session()->flash('success', 'Banner removido com sucesso.');
        } else {
            request()->session()->flash('error', 'Erro ao deletar o banner. Por favor, tente novamente.');
        }
        
        return redirect()->route('banners.index');
    }
}
