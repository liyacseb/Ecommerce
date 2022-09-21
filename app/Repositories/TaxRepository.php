<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Tax;
use Yajra\DataTables\Facades\DataTables;


class TaxRepository 
{
    public function gettaxlist(){
        // return Exam::all();
        $data = Tax::get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-info btn-sm actionedit" title="edit tax" href="'.route('taxedit',$row['id']).'" >
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a class="btn btn-danger btn-sm actionDelete" data-href="'.route('taxdestroy',$row['id']).'">
                        <i class="fas fa-trash"></i>
                    </a>';
                return $actionBtn;
            })
             ->rawColumns(['action'])
            ->make(true);
    }

    public function taxstore($data){
        $tax = new Tax() ;
        $tax->name = $data['name'];
        $tax->tax = $data['tax'];
        $tax->save();
        return $tax->id;
    }
    public function taxexist($id){
        return Product::where('tax_id',$id)->count();
    }
    public function taxdestroy($id){
        $tax = Tax::find($id);
        $tax->delete();
        return $tax;
    }
    public function taxfetch($id){
        return Tax::find($id);
    }
    public function taxupdate($data,$id){
        $tax = Tax::find($id);
        $tax->name = $data['name'];
        $tax->tax = $data['tax'];
        $tax->save();
        return $tax;
    }
}