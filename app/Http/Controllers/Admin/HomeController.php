<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Page;
use App\User;
use App\visitor;
use Illuminate\Http\Request;

class HomeController extends Controller 
{  
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $arrayInfoChart = [];
        $dataSelect = $request->only(['datePeriod']);
        $currentDate = date('Y-m-d H:i:s');
        if($dataSelect['datePeriod'] > 120) $dataSelect['datePeriod'] = 120;
        $datePeriod = date('Y-m-d H:i:s', strtotime("-".intval($dataSelect['datePeriod'])." days"));

        $visitsPeriodCount = Visitor::whereBetween('access_date', array($datePeriod, $currentDate))->count();

        $dateLimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $listVisitors = Visitor::select('ip')->where('access_date', '>=', $dateLimit)->groupBy('ip')->get();
        $online = count($listVisitors);

        $allVisits = Visitor::selectRaw('page, count(page) as qtPaginas')->whereBetween('access_date', array($datePeriod, $currentDate))->groupBy('page')->get();

        foreach ($allVisits as $visit) {
            $arrayInfoChart[$visit['page']] = $visit['qtPaginas'];
        }

        $pageLabel = json_encode( array_keys($arrayInfoChart) );
        $pageValues = json_encode( array_values($arrayInfoChart) );

        $infos = [
            'visitCount' => $visitsPeriodCount,
            'onlineCount' => $online,
            'pageCount' => Page::count(),
            'userCount' => User::count(), 
            'pageLabels' => $pageLabel,
            'pageValues' =>  $pageValues,
            'selected' => intVal($dataSelect['datePeriod'])
        ];

        return view('admin.home', $infos);
    }
}
