<?php

namespace App\Repositories;

use App\Models\Banner;
use Yajra\DataTables\Facades\DataTables;


class BannerRepository 
{
    public function getbannerlist(){
        $data = Banner::orderBy('id','desc')->get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $actionBtn = '
                    <a class="btn btn-secondary btn-sm " title="edit banner" href="'.route('banneredit',$row['id']).'" >
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a class="btn btn-danger btn-sm actionDelete" title="delete banner" data-href="'.route('bannerdestroy',$row['id']).'" >
                        <i class="fas fa-trash"></i>
                    </a>';
                return $actionBtn;
            })
            ->addColumn('bannerimg', function($row){
                $imgUrl = asset('storage/banner/'.$row['banner_img']);
                return '<img width="10%" src="'.$imgUrl.'" alt="img-'.$row['banner_img'].'">';
            })
            ->addColumn('bannerstatus', function($row){
                $statusAry = (config('options'));
                foreach($statusAry['status'] as $key=>$val){
                    if($key==$row['status']){
                        return $val;
                    }
                }
            })
            ->addColumn('date', function($row){
                $date=date_create($row['created_at']);
                return date_format($date,'d-m-Y');
            })
             ->rawColumns(['action','date','bannerstatus','bannerimg'])
            ->make(true);
    }
    public function bannerstore($data){
        $banner = new Banner();
        if(isset($data['banner_upload'])){
            $image_1 = $data['banner_upload'];
            $imgarr = explode(',', $image_1);
            if(!isset($imgarr[1])){
                $this->response['message'] = 'Error on post data image. String is not the expected string.';
                dd($this->response);
            }
            $this->image = base64_decode($imgarr[1]);
            $destinationPath = 'storage/banner';
            if(!is_null($this->image)){
                $cover_image =date('Ymdms').uniqid().'.png';
                $file = $destinationPath .'/'.$cover_image;
                if(file_exists($file)){
                    $this->response['message'] = 'Image already exists on server.';
                    // dd($this->response);
                }
                if(file_put_contents($file, $this->image) !== false){
                    $this->response['error'] = 1;
                    $this->response['message'] = 'Image saved to server';
                    // dd($this->response);
                    $banner->banner_img = $cover_image;
                }
                else{
                    $this->response['message'] = 'Error writing file to disk';
                    // dd($this->response);
                }
            }
            else{
                $this->response['message'] = 'Error decoding base64 string.';
                // dd($this->response);
            }
        }
        $banner->status = $data['status'];
        $banner->save();
        return $banner->id;
    }
    public function bannerfetch($id){
        return Banner::find($id);
    }
    public function bannerupate($data,$id){
        $banner = Banner::find($id);
        if(isset($data['banner_upload'])){
            $image_1 = $data['banner_upload'];
            $imgarr = explode(',', $image_1);
            if(!isset($imgarr[1])){
                $this->response['message'] = 'Error on post data image. String is not the expected string.';
                dd($this->response);
            }
            $this->image = base64_decode($imgarr[1]);
            $destinationPath = 'storage/banner';
            if(!is_null($this->image)){
                $cover_image =date('Ymdms').uniqid().'.png';
                $file = $destinationPath .'/'.$cover_image;
                if(file_exists($file)){
                    $this->response['message'] = 'Image already exists on server.';
                    // dd($this->response);
                }
                if(file_put_contents($file, $this->image) !== false){
                    $this->response['error'] = 1;
                    $this->response['message'] = 'Image saved to server';
                    // dd($this->response);
                    $banner->banner_img = $cover_image;
                }
                else{
                    $this->response['message'] = 'Error writing file to disk';
                    // dd($this->response);
                }
            }
            else{
                $this->response['message'] = 'Error decoding base64 string.';
                // dd($this->response);
            }
        }
        $banner->status = $data['status'];
        $banner->save();
        return $banner->id;
    }
    public function bannercount(){
        return Banner::where('status',1)->count();
    }
    public function bannerdestroy($id){
        $banner = Banner::find($id);
        $banner->delete();
        return $banner;
    }
}