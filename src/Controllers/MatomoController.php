<?php

namespace Chuckbe\Chuckcms\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use ChuckSite;
use VisualAppeal\Matomo;

class MatomoController extends BaseController
{

    private $siteId;
    private $authToken;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
    {
        // $this->siteId = ChuckSite::getSetting('integrations.matomo-site-id');
        // $this->authToken = ChuckSite::getSetting('integrations.matomo-auth-key');
    }

 
    /**
     * Show the dashboard -> pages.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if($this->siteId == null || $this->siteId == null){
            return view('chuckcms::backend.matomo.index', ['matomo' => 'nokeys']);
        }
        return view('chuckcms::backend.matomo.index');
    }
    public function matomo(Request $request)
    {
        $data = $request->all();
        $matomo = new Matomo("https://analytics.chuck.be", $this->authToken, $this->siteId, Matomo::FORMAT_JSON);
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

    public function counter(Request $request)
    {
        $data = $request->all();
        $matomo = new Matomo("https://analytics.chuck.be", $this->authToken, $this->siteId, Matomo::FORMAT_JSON);
        $liveCounter = $matomo->getCounters($lastMinutes = 3);
        return response()->json([
            'success'=>'success',
            'liveCounter' => $liveCounter
        ]);
    }

}