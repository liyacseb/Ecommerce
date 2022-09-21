<?php

namespace App\Repositories;

use App\Models\Color;
use App\Models\Stock;
use Yajra\DataTables\Facades\DataTables;


class ColorRepository 
{
    public function getcolorlist(){
        // return Exam::all();
        $data = Color::get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-info btn-sm actionedit" title="edit color" href="'.route('coloredit',$row['id']).'" >
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a class="btn btn-danger btn-sm actionDelete" data-href="'.route('colordestroy',$row['id']).'">
                        <i class="fas fa-trash"></i>
                    </a>';
                return $actionBtn;
            })
             ->rawColumns(['action'])
            ->make(true);
    }

    public function colorstore($data){
        $color = new Color() ;
        $color->color = $data['color'];
        $color->save();
        return $color->id;
    }
    public function colorexist($id){
        return Stock::where('color_id',$id)->count();
    }
    public function colordestroy($id){
        $color = Color::find($id);
        $color->delete();
        return $color;
    }
    public function colorfetch($id){
        return Color::find($id);
    }
    public function colorupdate($data,$id){
        $color = Color::find($id);
        $color->color = $data['color'];
        $color->save();
        return $color;
    }
}