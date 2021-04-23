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
            $matomoSummary = $matomo->getVisitsSummary();
            $matomoCountries = $matomo->getCountry();
            $matomoUniqueVisitors = $matomo->getUniqueVisitors();
            $getOSFamilies = $matomo->getOSFamilies();
            $getSearchEngines = $matomo->getSearchEngines();
        }else{
            $matomo->setRange(date('Y-m-d', mktime(0, 0, 0, $data["value"]["m2"], $data["value"]["d2"], $data["value"]["y2"])), date('Y-m-d', mktime(0, 0, 0, $data["value"]["m1"], $data["value"]["d1"], $data["value"]["y1"])));
            $matomoSummary = $matomo->setPeriod(Matomo::PERIOD_RANGE)->getVisitsSummary();
            $getOSFamilies = $matomo->getOSFamilies();
            $matomoCountries = $matomo->getCountry();
            $getSearchEngines = $matomo->getSearchEngines();
            $matomoUniqueVisitors = $matomo->setPeriod(Matomo::PERIOD_DAY)->getUniqueVisitors();
        }
        
        // $matomoApi = $matomo->getApi();
        // $pageUrls = $matomo->getPageUrls();
        // $getDeviceType = $matomo->getDeviceType();
        // $getDeviceBrand = $matomo->getDeviceBrand();
        // $getDeviceModel = $matomo->getDeviceModel();
        // $getOSFamilies = $matomo->getOSFamilies();
        // $getBrowsers = $matomo->getBrowsers();
        // $getMoversAndShakersOverview = $matomo->getMoversAndShakersOverview('countryCode==be');

        // nb_uniq_visitors not available when using range
        return response()->json([
            'success'=>'success',
            'matomoVersion' => $matomoVersion,
            'matomoSummary' => $matomoSummary,
            'matomoUniqueVisitors' => $matomoUniqueVisitors,
            'getSearchEngines' => $getSearchEngines,
            'matomoCountries' => $matomoCountries,
            'getOSFamilies' => $getOSFamilies
        ]);
    }

}