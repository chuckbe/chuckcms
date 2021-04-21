<?php

namespace Chuckbe\Chuckcms\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use VisualAppeal\Matomo;

class MatomoController extends BaseController
{
    /**
     * Show the dashboard -> pages.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('chuckcms::backend.matomo.index');
    }
    public function matomo(Request $request)
    {
        $data = $request->all();

        $matomo = new Matomo("https://analytics.chuck.be", "d6fdc36dc7f4c0c88fa58d189a88ae4b", 6, Matomo::FORMAT_JSON);
        $matomoVersion = $matomo->getMatomoVersion();
        if($data["value"]["range"] == "Today"){
            $matomo->setPeriod(Matomo::PERIOD_DAY);
            $matomo->setDate(Matomo::DATE_TODAY);
        }else{
            $matomo->setDate(date('Y-m-d'), date('Y-m-d', mktime(0, 0, 0, $data["value"]["m1"], $data["value"]["d1"], $data["value"]["y1"])));
            $matomo->setPeriod(Matomo::PERIOD_RANGE);
            $matomo->setRange(date('Y-m-d', mktime(0, 0, 0, $data["value"]["m2"], $data["value"]["d2"], $data["value"]["y2"])), date('Y-m-d', mktime(0, 0, 0, $data["value"]["m1"], $data["value"]["d1"], $data["value"]["y1"])));
        }
        $matomoSummary = $matomo->getVisitsSummary();
        $matomoCountries = $matomo->getCountry();
        $matomoUniqueVisitors = $matomo->setPeriod(Matomo::PERIOD_WEEK)->setDate('last7')->setFormat(Matomo::FORMAT_JSON)->getUniqueVisitors();
        // nb_uniq_visitors not available when using range
        return response()->json([
            'success'=>'success',
            'matomoVersion' => $matomoVersion,
            'matomoSummary' => $matomoSummary,
            'matomoUniqueVisitors' => $matomoUniqueVisitors,
            'matomoCountries' => $matomoCountries,

        ]);
    }

}