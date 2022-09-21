<?php

namespace App\Http\Controllers;

use App\Repositories\AdminUserRepository;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public $adminUserRepo;
    public function __construct(AdminUserRepository $adminUserRepo)
    {
        $this->adminUserRepo =$adminUserRepo;
    }
    public function index()
    {
        return view('admin.user.userList');
    }
    public function userListing()
    {
        return $this->adminUserRepo->getUsers();
    }
    public function userView($id)
    {
        $basicdetail = $this->adminUserRepo->getUserDetail($id);
        if($basicdetail!=null){
            $addressdetail = $this->adminUserRepo->getUserAddressDetail($id);
            return view('admin.user.userView',compact(['basicdetail','addressdetail']));
        }else{
            return redirect('admin/user/user-list');
        }
    }
    public function individualorderListing($id)
    {
        return $this->adminUserRepo->getUserOrders($id);
    }
    public function walletTransaction($id)
    {
        return $this->adminUserRepo->getWalletTransactions($id);
    }
}
