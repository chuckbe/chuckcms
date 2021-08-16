<?php

namespace Chuckbe\Chuckcms\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Chuckbe\Chuckcms\Models\Site;
use Chuckbe\Chuckcms\Chuck\SiteRepository;
use Chuckbe\Chuckcms\Models\User;
use ChuckSite;
use VisualAppeal\Matomo;
use Matomo\ReportingApi\QueryFactory;

class MatomoController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $site;
    private $siteRepository;
    private $user;
    private $siteId;
    private $authToken;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct(Site $site, SiteRepository $siteRepository, User $user)
    {
        $this->site = $site;
        $this->siteId = ChuckSite::getSetting('integrations.matomo-site-id');
        $this->authToken = ChuckSite::getSetting('integrations.matomo-auth-key');
        $this->siteRepository = $siteRepository;
        $this->user = $user;
    }

 
    /**
     * Show the dashboard -> pages.
     *
     * @return \Illuminate\View\View
     */
    // public function index()
    // {
    //     if($this->siteId == null || $this->authToken == null){
    //         return view('chuckcms::backend.matomo.index', ['matomoSiteId' => $this->siteId, 'matomoAuthToken' => $this->authToken]);
    //     }
    //     dd($this->siteId);
    //     return view('chuckcms::backend.matomo.index');
    // }
    public function ReportingApi(Request $request)
    {
        $data = $request->all();
        $matomoUrl = ChuckSite::getSetting('integrations.matomo-site-url') !== null ? ChuckSite::getSetting('integrations.matomo-site-url') : config('chuckcms.analytics.matomoURL');
        $query_factory = QueryFactory::create($matomoUrl);
        $query_factory
            ->set('idSite', $this->siteId)
            ->set('token_auth', $this->authToken);
        
        $date = 'today';
        $period = 'day';
        
        if($data["value"]["range"] !== "Today" || $data["value"]["range"] !== "Yesterday"){        
            if(isset($data["value"]["y2"],$data["value"]["m2"],$data["value"]["d2"])){
                $now = \Carbon\Carbon::now();
                $startdate = \Carbon\Carbon::createFromFormat('Y-m-d', $data["value"]["y2"].'-'.$data["value"]["m2"].'-'.$data["value"]["d2"]);
                $enddate = \Carbon\Carbon::createFromFormat('Y-m-d',$data["value"]["y1"].'-'.$data["value"]["m1"].'-'.$data["value"]["d1"]);
                $checkforrange = $now->diffInDays($enddate);
                $diff = $startdate->diffInDays($enddate);
                if($checkforrange !== 0){
                    $period = 'range';
                    $date = $data["value"]["y2"].'-'.$data["value"]["m2"].'-'.$data["value"]["d2"].','.$data["value"]["y1"].'-'.$data["value"]["m1"].'-'.$data["value"]["d1"];                    
                }else{
                    if($diff == 6){
                        $period = 'week';
                        $date = 'last7';
                    }
                    if($diff == 29){
                        $period = 'month';
                        $date = 'last30';
                    }
                }
            }      
        }
        if($data["value"]["range"] == "Today"){
            $date = 'today';
            $period = 'day';
        }
        if($data["value"]["range"] == "Yesterday"){
            $date = 'yesterday';
            $period = 'day';
        }
        
        // $visitsSummary = $query_factory->getQuery('VisitsSummary.get')
        // ->setParameter('date', $date)
        // ->setParameter('period', 'day')                
        // ->execute()
        // ->getResponse();

            
        $lastVisitsDetails = $query_factory->getQuery('Live.getLastVisitsDetails')
            ->setParameter('date', $date)
            ->setParameter('period', $period)
            ->setParameter('filter_limit', -1)
            ->execute()
            ->getResponse();
        
              
        // $heatMaps = $query_factory->getQuery('HeatmapSessionRecording.getHeatmaps')
        // ->execute()
        // ->getResponse();
        
        // $heatMap = array();
        // foreach($heatMaps as $key=>$value)
        // {
            
        //     $heatMap[] = $query_factory->getQuery('HeatmapSessionRecording.getHeatmap')
        //     ->setParameter('idSiteHsr', $value->idsitehsr)
        //     ->execute()
        //     ->getResponse();
            
        // }


        return response()->json([
            'success'=>'success',
            'lastVisitsDetails' => $lastVisitsDetails,
        ]);

    }

    // public function visitorsummary(Request $request)
    // {
    //     $data = $request->all();
    //     $query_factory = QueryFactory::create(config('chuckcms.analytics.matomoURL'));
    //     $query_factory
    //         ->set('idSite', $this->siteId)
    //         ->set('token_auth', $this->authToken);

    //     $visitorProfile = $query_factory->getQuery('Live.getVisitorProfile')
    //         ->setParameter('visitorId', $data['visitorid'])
    //         ->execute()
    //         ->getResponse();
        
    //     return response()->json([
    //         'success'=>'success',
    //         'visitorProfile' => $visitorProfile
    //     ]);
    // }

    // public function Livecounter(Request $request)
    // {
    //     $data = $request->all();
    //     $query_factory = QueryFactory::create(config('chuckcms.analytics.matomoURL'));
    //     $query_factory
    //         ->set('idSite', $this->siteId)
    //         ->set('token_auth', $this->authToken);

    //     $liveCounters = $query_factory->getQuery('Live.getCounters')
    //     ->setParameter('lastMinutes', 3)
    //     ->execute()
    //     ->getResponse();

    //     return response()->json([
    //         'success'=>'success',
    //         'liveCounter' => $liveCounters
    //     ]);
    // }
    // public function matomo(Request $request)
    // {
    //     $data = $request->all();
    //     $query_factory = QueryFactory::create(config('chuckcms.analytics.matomoURL'));
    //     $query_factory
    //         ->set('idSite', $this->siteId)
    //         ->set('token_auth', $this->authToken);
    //     $matomoVersion = $query_factory->getQuery('API.getMatomoVersion')->execute()->getResponse()->value;

    //     $matomo = new Matomo(config('chuckcms.analytics.matomoURL'), $this->authToken, $this->siteId, Matomo::FORMAT_JSON);
    //     // $matomoVersion = $matomo->getMatomoVersion();
    //     if($data["value"]["range"] == "Today"){
           
    //         $matomo->setPeriod(Matomo::PERIOD_DAY);
    //         $matomo->setDate(Matomo::DATE_TODAY);
    //         $matomoSummary = $matomo->getVisitsSummary();
    //         $matomoCountries = $matomo->getCountry();
    //         $matomoUniqueVisitors = $matomo->getUniqueVisitors();
    //         $getOSFamilies = $matomo->getOSFamilies();
    //         $getSearchEngines = $matomo->getSearchEngines();
    //     }else{
    //         $matomo->setRange(date('Y-m-d', mktime(0, 0, 0, $data["value"]["m2"], $data["value"]["d2"], $data["value"]["y2"])), date('Y-m-d', mktime(0, 0, 0, $data["value"]["m1"], $data["value"]["d1"], $data["value"]["y1"])));
    //         $matomoSummary = $matomo->setPeriod(Matomo::PERIOD_RANGE)->getVisitsSummary();
    //         $getOSFamilies = $matomo->getOSFamilies();
    //         $matomoCountries = $matomo->getCountry();
            
    //         $getSearchEngines = $matomo->getSearchEngines();
    //         $matomoUniqueVisitors = $matomo->setPeriod(Matomo::PERIOD_DAY)->getUniqueVisitors();
    //     }
       

    //     return response()->json([
    //         'success'=>'success',
    //         'matomoVersion' => $matomoVersion,
    //         'matomoSummary' => $matomoSummary,
    //         'matomoUniqueVisitors' => $matomoUniqueVisitors,
    //         'getSearchEngines' => $getSearchEngines,
    //         'matomoCountries' => $matomoCountries,
    //         'getOSFamilies' => $getOSFamilies
    //     ]);
    // }

    // public function counter(Request $request)
    // {
    //     $data = $request->all();
    //     $matomo = new Matomo(config('chuckcms.analytics.matomoURL'), $this->authToken, $this->siteId, Matomo::FORMAT_JSON);
    //     $liveCounter = $matomo->getCounters($lastMinutes = 3);
    //     return response()->json([
    //         'success'=>'success',
    //         'liveCounter' => $liveCounter
    //     ]);
    // }

    public function submit(Request $request)
    {
        $request->validate([
            'siteId' => 'required',
            'authtoken' => 'required'
        ]);
        $settings = [];
        $settings['id'] = ChuckSite::getSite('id');
        $settings['name'] = ChuckSite::getSite('name');
        $settings['slug'] = ChuckSite::getSite('slug');
        $settings['company'] =  ChuckSite::getSetting('company') ;
        $settings['socialmedia'] =  ChuckSite::getSetting('socialmedia');
        $settings['favicon'] = ChuckSite::getSetting('favicon');
        $settings['logo'] =  ChuckSite::getSetting('logo');
        $settings['lang'] = ChuckSite::getSetting('lang');
        $settings['domain'] = ChuckSite::getSetting('domain');
        $settings['integrations'] = [
            'matomo-site-id' => $request->siteId,
            'matomo-auth-key' => $request->authtoken
        ];
        // //update or create settings
        $this->siteRepository->updateIntegrations($settings);

        //redirect back
        return redirect()->route('dashboard.matomo')->with('notification', 'Instellingen opgeslagen!');
        
    }

}