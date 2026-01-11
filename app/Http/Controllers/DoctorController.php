<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Models\User;

class DoctorController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            return DataTables::of(User::select('name', 'email', 'gender', 'identity')->orderBy('id', 'asc')->get())
                // ->addColumn('action', function (DocumentType $documentType) {
                //     return '
                //     <center>
                //         <button class="btn bg-gradient-success" style="margin-bottom:0px!important; padding:10px!important" onclick="showEdit(\'' . $documentType->identity . '\')" >
                //             <i class="fa-solid fa-pencil text-white"></i>
                //         </button>
                //         <button class="btn bg-gradient-danger" style="margin-bottom:0px!important; padding:10px!important" onclick="alertDelete(\'' . $documentType->name . '\',\'' . $documentType->identity . '\')" >
                //             <i class="fa-solid fa-trash text-white"></i>
                //         </button>
                //     </center>
                // ';
                // })
                ->addIndexColumn()
                ->make(true);
        }
        return view('doctors.index');
    }
}
