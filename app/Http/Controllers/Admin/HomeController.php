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
        $arrayInfoChart = [];

        $dateLimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $listVisitors = Visitor::select('ip')->where('access_date', '>=', $dateLimit)->groupBy('ip')->get();
        $online = count($listVisitors);

        $allVisits = Visitor::selectRaw('page, count(page) as qtPaginas')->groupBy('page')->get();

        foreach ($allVisits as $visit) {
            $arrayInfoChart[$visit['page']] = $visit['qtPaginas'];
        }

        $pageLabel = json_encode( array_keys($arrayInfoChart) );
        $pageValues = json_encode( array_values($arrayInfoChart) );

        $infos = [
            'visitCount' => visitor::count(),
            'onlineCount' => $online,
            'pageCount' => Page::count(),
            'userCount' => User::count(), 
            'pageLabels' => $pageLabel,
            'pageValues' =>  $pageValues
        ];

        return view('admin.home', $infos);
    }
}
