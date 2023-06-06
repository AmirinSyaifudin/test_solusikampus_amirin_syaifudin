<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Instansi;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use DataTables;
use Illuminate\Support\Facades\DB;

class InstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $instansi = Instansi::orderBy('created_at', 'DESC');

        if ($request->ajax() ) 
        {
            $data = Instansi::latest()->get();

            return datatables::of($instansi)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  
                        data-id="' . $row->instansi_id . '" 
                        data-title="' . $row->nama_instansi . '"  
                        data-deskripsi="' . $row->deskripsi . '" 
                        data-original-title="Edit" 
                        class="edit btn btn-primary btn-sm editInstansi">EDIT</a>';

                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '&nbsp;&nbsp;';
                    
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-instansi_id="'.$row->instansi_id .'" 
                                        data-original-title="Delete" class="btn btn-danger btn-sm deleteInstansi">Delete
                                 </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.instansi.index', compact('instansi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Instansi::updateOrCreate(
            [
                'instansi_id'   => $request->instansi_id
            ],
            [
                'nama_instansi'  => $request->nama_instansi,
                'deskripsi'      => $request->deskripsi
            ]
        );

        return response()->json(['success' => 'Instansi Berhasil Di tambahkan !!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($instansi_id)
    {
        $instansi = Instansi::find($instansi_id);

        return response()->json($instansi);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $edit = DB::table('instansi')
            ->where('instansi_id', $request->id)
            ->update([
                'nama_instansi'          => $request->nama_instansi,
                'deskripsi'             => $request->deskripsi,
            ]);

        return response()->json(['success' => 'Instansi Berhasil Di Update !!!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Instansi::where('instansi_id', $request->id)->delete();

        return response()->json(['success' => 'Instansi deleted successfully.']);
    }
}
