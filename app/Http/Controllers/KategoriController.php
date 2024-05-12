<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Category List';
        $data['breadcumb'] = 'Category List';
        $data['kategori'] = Kategori::orderby('id', 'asc')->get();

        return view('kategori.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Category Create';
        $data['breadcumb'] = 'Category Create';

        return view('kategori.create', $data);
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
            'nama_kategori'   => 'required|string',
        ]);

        $data = new Kategori();
        $data->nama_kategori = $validateData['nama_kategori'];
        $data->save();

        return redirect()->route('kategori-list')->with(['success' => 'Added successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Category Edit';
        $data['breadcumb'] = 'Category Edit';
        $data['kategori'] = Kategori::find($id);

        return view('kategori.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'nama_kategori'   => 'required|string',
        ]);

        $data = Kategori::find($id);
        $data->nama_kategori = $validateData['nama_kategori'];
        $data->save();

        return redirect()->route('kategori-list')->with(['success' => 'Edited successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Kategori::find($id);
        $data->delete();

        return redirect()->route('kategori-list')->with(['success' => 'Deleted successfully!']);
    }
}
