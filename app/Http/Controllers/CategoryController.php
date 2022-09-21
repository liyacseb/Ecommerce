<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    public $catRepo;
    public function __construct(CategoryRepository $catRepo)
    {
        $this->catRepo =$catRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category.categoryList');
    }
    public function categoryListing()
    {
        return $this->catRepo->getcategorylist();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function categorycreate()
    {
        return view('admin.category.categoryAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function categorystore(CategoryRequest $request)
    {
        $data = $this->catRepo->categorystore($request->all());
        if($data>0){
            return response()->json(['data'=>$data,'message'=>'Succesfully Created']);
        }else{
            return response()->json(['data'=>$data,'message'=>"Can't Create"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function categoryedit($id)
    {
        $curntdata = $this->catRepo->categoryfetch($id);
        return view('admin.category.categoryEdit',compact(['curntdata']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function categoryupdate(CategoryUpdateRequest $request, $id)
    {
        $data = $this->catRepo->categoryupdate($request->all(),$id);
        return response()->json(['data'=>$data,'message'=>'Succesfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function categorydestroy($id)
    {
        $catexist = $this->catRepo->checkcategoryused($id);
        if($catexist==0){
            $this->catRepo->categorydestroy($id);
            return redirect('category/category-list')->with('success','Succesfully deleted');
                
        }else{
            return redirect('category/category-list')->with('error',"Can't delete.Some products uses this category");
        }
    }

}
