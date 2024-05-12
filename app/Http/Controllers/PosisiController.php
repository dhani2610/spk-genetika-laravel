<?php

namespace App\Http\Controllers;

use App\Models\Posisi;
use Illuminate\Http\Request;

class PosisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Posisi List';
        $data['breadcumb'] = 'Posisi List';
        $data['posisi'] = Posisi::orderby('id', 'asc')->get();

        return view('posisi.index', $data);
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Posisi Create';
        $data['breadcumb'] = 'Posisi Create';
        $data['posisi'] = Posisi::orderby('id', 'asc')->get();

        return view('posisi.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'posisi'   => 'required|string',
        ]);

        $data = new Posisi();
        $data->posisi = $validateData['posisi'];
        $data->save();

        return redirect()->route('posisi-list')->with(['success' => 'Added successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Posisi  $posisi
     * @return \Illuminate\Http\Response
     */
    public function show(Posisi $posisi)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Posisi  $posisi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Posisi Edit';
        $data['breadcumb'] = 'Posisi Edit';
        $data['posisi'] = Posisi::find($id);

        return view('posisi.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Posisi  $posisi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'posisi'   => 'required|string',
        ]);

        $data = Posisi::find($id);
        $data->posisi = $validateData['posisi'];
        $data->save();

        return redirect()->route('posisi-list')->with(['success' => 'Edited successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Posisi  $posisi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posisi $posisi)
    {
        $data = Posisi::find($id);
        $data->delete();

        return redirect()->route('posisi-list')->with(['success' => 'Deleted successfully!']);
    }
}
