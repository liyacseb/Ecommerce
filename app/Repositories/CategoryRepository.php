<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;


class CategoryRepository 
{
    public function getcategorylist(){
        // return Exam::all();
        $data = Category::get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $otheraction = '';
                    $actionBtn = '<a class="btn btn-info btn-sm actionedit" title="edit category" href="'.route('categoryedit',$row['id']).'" >
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a class="btn btn-danger btn-sm actionDelete" data-href="'.route('categorydestroy',$row['id']).'">
                        <i class="fas fa-trash"></i>
                    </a>';
                return $actionBtn;
            })
            ->addColumn('status', function($row){
                $statusAry = (config('options'));
                foreach($statusAry['status'] as $key=>$val){
                    if($key==$row['category_status']){
                        return $val;
                    }
                }
            })
             ->rawColumns(['action'])
            ->make(true);
    }

    public function categorystore($data){
        $category = new Category() ;
        $category->category_name = $data['category_name'];
        $category->description = $data['description'];
        $category->icon = $data['icon'];
        $category->category_status = $data['category_status'];
        $category->save();
        return $category->id;
    }
    public function checkcategoryused($id){
        return Product::where('cat_id',$id)->count();
    }
    public function categorydestroy($id){
        $category = Category::find($id);
        $category->delete();
        return $category;
    }
    public function categoryfetch($id){
        return Category::find($id);
    }
    public function categoryupdate($data,$id){
        $category = Category::find($id);
        $category->category_name = $data['category_name'];
        $category->description = $data['description'];
        $category->icon = $data['icon'];
        $category->category_status = $data['category_status'];
        $category->save();
        return $category;
    }
}