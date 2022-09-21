<?php

namespace App\Repositories;

use App\Models\Size;
use App\Models\Stock;
use Yajra\DataTables\Facades\DataTables;


class SizeRepository 
{
    public function getsizelist(){
        // return Exam::all();
        $data = Size::get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-info btn-sm actionedit" title="edit size" href="'.route('sizeedit',$row['id']).'" >
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a class="btn btn-danger btn-sm actionDelete" data-href="'.route('sizedestroy',$row['id']).'">
                        <i class="fas fa-trash"></i>
                    </a>';
                return $actionBtn;
            })
             ->rawColumns(['action'])
            ->make(true);
    }

    public function sizestore($data){
        $size = new Size() ;
        $size->size = $data['size'];
        $size->save();
        return $size->id;
    }
    public function sizedestroy($id){
        $size = Size::find($id);
        $size->delete();
        return $size;
    }
    public function sizeexist($id){
        return Stock::where('size_id',$id)->count();
    }
    public function sizefetch($id){
        return Size::find($id);
    }
    public function sizeupdate($data,$id){
        $size = Size::find($id);
        $size->size = $data['size'];
        $size->save();
        return $size;
    }
}