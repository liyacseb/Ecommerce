<?php

namespace App\Repositories;

use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class StockRepository 
{
    public function getProducts(){
       $data= DB::table('products')->select('*')
            ->whereNotIn('id',Stock::pluck('prod_id')) 
            ->where('deleted_at',null)           
            ->get();
        return $data;
        // return Product::get();
    }
    public function getAllProducts(){
        return Product::get();
    }
    public function getstocklist(){
        // return Exam::all();
        $data = Stock::with('getProduct')
                ->groupBy('stocks.prod_id')
                ->orderBy('id','desc')
                ->get();
                
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $action = '<a class="btn btn-info btn-sm actionedit" title="edit tax" href="'.route('stockedit',$row['prod_id']).'" >
                        <i class="fas fa-pencil-alt"></i>
                    </a>';
                    // $action .= ' <a class="btn btn-danger btn-sm actionDelete" data-href="'.route('stockdestroy',$row['prod_id']).'">
                    //     <i class="fas fa-trash"></i>
                    // </a>';
                return $action;
            })
            ->addColumn('stockcount', function($row){
                if($row['getProduct']!=null){
                    $color_id= Product::select('color_id')->where('id',$row['prod_id'])->get();
                    if(count($color_id)>0){
                        $ary =explode(',',$color_id[0]['color_id']);
                        $count=  Stock::selectRaw('SUM(stock) as stockcount')
                            ->where('prod_id',$row['prod_id'])
                            ->whereIn('color_id',$ary)
                            ->get();
                            // dd($count[0]['stockcount']);
                        $stockcount= $count[0]['stockcount'];
                        return $stockcount;
                    }else{
                            return 0;
                    }
                }
            })
            ->rawColumns(['action','stockcount'])
            ->make(true);
    }

    public function stockstore($data){
        $stkNames = explode(',',$data['stkNames']);
        // dd($stkNames);
        for($i=0;$i<count($stkNames);$i++){
            $name = explode('_',$stkNames[$i]);
            $color_id = $name[1];
            $size_id = $name[2];
            $stockcount = $data[$stkNames[$i]];
            // @dd($stock);
            $stock = new Stock() ;
            $stock->prod_id = $data['product'];
            $stock->color_id = $color_id;
            $stock->size_id = $size_id;
            $stock->stock = $stockcount;
            $stock->save();
        }
       
        return $stock->id;
    }
    public function stockdestroy($prod_id){
        $stock = Stock::where('prod_id',$prod_id);
        $stock->delete();
        return $stock;
    }
    public function stockfetch($prod_id){
        return Stock::where('prod_id',$prod_id)->get();
    }
    public function fetchproductstock($data){
        return Stock::select('stock')
        ->where('prod_id',$data['proID'])
        ->where('color_id',$data['colorID'])
        ->where('size_id',$data['sizeID'])
        ->get();
    }
    public function stockupdate($data,$prod_id){
        $stkNames = explode(',',$data['stkNames']);
        // dd($prod_id);
        for($i=0;$i<count($stkNames);$i++){
            $name = explode('_',$stkNames[$i]);
            $color_id = $name[1];
            $size_id = $name[2];
            $stockcount = $data[$stkNames[$i]];
            // @dd($stock);
            $stockdata = Stock::where('prod_id',$prod_id)->where('color_id',$color_id)->where('size_id',$size_id)->first() ;
            // dd($stock->id);
            if($stockdata){
                $stock = Stock::find($stockdata->id) ;
                $stock->stock = $stockcount;
                $stock->save();
            }else{
                $stock = new Stock() ;
                $stock->prod_id = $prod_id;
                $stock->color_id = $color_id;
                $stock->size_id = $size_id;
                $stock->stock = $stockcount;
                $stock->save();
            }
        }
       
        return $stock;
    }
    public function getprodcolorsize($data){
        $details = Product::find($data['proID']);
        $colorAry = explode(',',$details['color_id']);
        $sizeAry = explode(',',$details['size_id']);
        $color = Color::whereIn('id',$colorAry )->get();
        $size = Size::whereIn('id',$sizeAry )->get();
        return $ary = ['color'=>$color,'size'=>$size];
        
    }
}