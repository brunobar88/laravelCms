<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Page;
use App\User;
use App\visitor;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $dateLimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $listVisitors = Visitor::select('ip')->where('access_date', '>=', $dateLimit)->groupBy('ip')->get();
        $online = count($listVisitors);

        $infos = [
            'visitCount' => visitor::count(),
            'onlineCount' => $online,
            'pageCount' => Page::count(),
            'userCount' => User::count(), 
        ];

        return view('admin.home', $infos);
    }
}
