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

 
    public function reportingApi(Request $request)
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
            
        $lastVisitsDetails = $query_factory->getQuery('Live.getLastVisitsDetails')
            ->setParameter('date', $date)
            ->setParameter('period', $period)
            ->setParameter('filter_limit', -1)
            ->execute()
            ->getResponse();
        


        return response()->json([
            'success'=>'success',
            'lastVisitsDetails' => $lastVisitsDetails,
            'matomoUrl' => $matomoUrl
        ]);

    }

    public function visitorSummary(Request $request)
    {
        $data = $request->all();
        $matomoUrl = ChuckSite::getSetting('integrations.matomo-site-url') !== null ? ChuckSite::getSetting('integrations.matomo-site-url') : config('chuckcms.analytics.matomoURL');
        $query_factory = QueryFactory::create($matomoUrl);
        $query_factory
            ->set('idSite', $this->siteId)
            ->set('token_auth', $this->authToken);

        $visitorProfile = $query_factory->getQuery('Live.getVisitorProfile')
            ->setParameter('visitorId', $data['visitorid'])
            ->execute()
            ->getResponse();
        return response()->json([
            'success'=>'success',
            'visitorProfile' => $visitorProfile,
            'matomoUrl' => $matomoUrl
        ]);
    }

    public function getHeatMaps(Request $request)
    {
        $data = $request->all();
        $matomoUrl = ChuckSite::getSetting('integrations.matomo-site-url') !== null ? ChuckSite::getSetting('integrations.matomo-site-url') : config('chuckcms.analytics.matomoURL');
        $query_factory = QueryFactory::create($matomoUrl);
        $query_factory
            ->set('idSite', $this->siteId)
            ->set('token_auth', $this->authToken);
        
        $heatMaps = $query_factory->getQuery('HeatmapSessionRecording.getHeatmaps')
        ->execute()
        ->getResponse();
        
        // $heatmapTypes = $query_factory->getQuery('HeatmapSessionRecording.getAvailableHeatmapTypes')
        // ->execute()
        // ->getResponse();

        // $heatMap = $query_factory->getQuery('HeatmapSessionRecording.getRecordedHeatmap')
        // ->setParameter('idSiteHsr', get_object_vars($heatMaps[0])['idsitehsr'])
        // ->setParameter('heatmapType', "Scroll")
        // ->setParameter('deviceType', 'Desktop')
        // ->setParameter('date', 'yesterday')
        // ->setParameter('period', 'day')
        // ->execute()
        // ->getResponse();



        return response()->json([
            'success'=>'success',
            'matomoUrl' => $matomoUrl,
            'heatMaps' => $heatMaps
        ]);
        
    }

    public function getSessionRecordings(Request $request)
    {
        $data = $request->all();
        $matomoUrl = ChuckSite::getSetting('integrations.matomo-site-url') !== null ? ChuckSite::getSetting('integrations.matomo-site-url') : config('chuckcms.analytics.matomoURL');
        if($data["value"]["range"] !== "Today" || $data["value"]["range"] !== "Yesterday"){
            if(isset($data["value"]["y2"]) && isset($data["value"]["y1"])){
                $now = \Carbon\Carbon::now();
                $startdate = \Carbon\Carbon::createFromFormat('Y-m-d', $data["value"]["y2"].'-'.$data["value"]["m2"].'-'.$data["value"]["d2"]);
                $enddate = \Carbon\Carbon::createFromFormat('Y-m-d',$data["value"]["y1"].'-'.$data["value"]["m1"].'-'.$data["value"]["d1"]);
                $checkforrange = $now->diffInDays($enddate);
          
                if($checkforrange !== 0){
                    $period = 'range';
                    $date = date('Y-m-d', strtotime($startdate)).",".date('Y-m-d', strtotime($enddate));
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
        
        
        
        $query_factory = QueryFactory::create($matomoUrl);
        $query_factory
            ->set('idSite', $this->siteId)
            ->set('token_auth', $this->authToken);

        $sessionRecordings = $query_factory->getQuery('HeatmapSessionRecording.getSessionRecordings')
            ->execute()
            ->getResponse();  
        
        
        if (!empty($sessionRecordings)) {
            $recordedSessions = $query_factory->getQuery('HeatmapSessionRecording.getRecordedSessions')
            ->setParameter('idSiteHsr', get_object_vars($sessionRecordings[0])['idsitehsr'])
            ->setParameter('date', $date)
            ->setParameter('period', $period)
            ->setParameter('filter_limit', -1)
            ->execute()
            ->getResponse();
        }else{
            $recordedSessions = [];
        }
        

        
        return response()->json([
            'success'=>'success',
            'matomoUrl' => $matomoUrl,
            'sessionRecordings' => $sessionRecordings,
            'recordedSessions'=> $recordedSessions,
            'sitehrs' => empty($sessionRecordings) ? null :get_object_vars($sessionRecordings[0])['idsitehsr']
        ]);

    }

    public function getRecordedSession(Request $request)
    {
        $data = $request->all();
        $matomoUrl = ChuckSite::getSetting('integrations.matomo-site-url') !== null ? ChuckSite::getSetting('integrations.matomo-site-url') : config('chuckcms.analytics.matomoURL');
        $query_factory = QueryFactory::create($matomoUrl);
        $query_factory
            ->set('idSite', $this->siteId)
            ->set('token_auth', $this->authToken);
    
        $recordedSessions = $query_factory->getQuery('HeatmapSessionRecording.getRecordedSession')
            ->setParameter('idSiteHsr', $data["idSiteHsr"])
            ->setParameter('idLogHsr', $data["idLogHsr"])
            ->setParameter('filter_limit', -1)
            ->execute()
            ->getResponse();

        return response()->json([
            'success'=>'success',
            'matomoUrl' => $matomoUrl,
            'recordedSession' => $recordedSessions
        ]);
        
    }

    public function getLiveCounter(Request $request)
    {
        $data = $request->all();
        $matomoUrl = ChuckSite::getSetting('integrations.matomo-site-url') !== null ? ChuckSite::getSetting('integrations.matomo-site-url') : config('chuckcms.analytics.matomoURL');
        $query_factory = QueryFactory::create($matomoUrl);
        $query_factory
            ->set('idSite', $this->siteId)
            ->set('token_auth', $this->authToken);
        
        $liveCounter = $query_factory->getQuery('Live.getCounters')
            ->setParameter('lastMinutes', 3)
            ->execute()
            ->getResponse();

        return response()->json([
            'success'=>'success',
            'liveCounter' => $liveCounter
        ]);
    }

    public function getVisitsData(Request $request)
    {
        $data = $request->all();
        $imgDate = '';
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
                    $imgDate = $date;
                }else{
                    $imgDate = $data["value"]["y2"].'-'.$data["value"]["m2"].'-'.$data["value"]["d2"].','.$data["value"]["y1"].'-'.$data["value"]["m1"].'-'.$data["value"]["d1"];
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
            $imgDate = date('Y-m-d').",".date('Y-m-d', strtotime(date('Y-m-d')." +2 day"));
        }
        if($data["value"]["range"] == "Yesterday"){
            $date = 'yesterday';
            $period = 'day';
            $imgDate = date('Y-m-d', strtotime(date('Y-m-d')." -1 day")).",".date('Y-m-d', strtotime(date('Y-m-d')." +1 day"));
        }
        $matomoUrl = ChuckSite::getSetting('integrations.matomo-site-url') !== null ? ChuckSite::getSetting('integrations.matomo-site-url') : config('chuckcms.analytics.matomoURL');
        $query_factory = QueryFactory::create($matomoUrl);
        $query_factory
            ->set('idSite', $this->siteId)
            ->set('token_auth', $this->authToken);
        
        $data = $query_factory->getQuery('API.get ')
            ->setParameter('date', $date)
            ->setParameter('period', $period)
            ->execute()
            ->getResponse();
        
            
        return response()->json([
                'success'=>'success',
                'visitimg'=> $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&segment=&showtitle=1&random=6179&columns=nb_visits%2Cnb_uniq_visitors&token_auth='.$this->authToken,
                'avgvisitimg'=> $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&showtitle=1&random=6179&columns=avg_time_on_site&token_auth='.$this->authToken,
                'bouncerateimg'=> $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&columns=bounce_rate&token_auth='.$this->authToken,
                'actions_per_visit_img'=> $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&columns=nb_actions_per_visit&token_auth='.$this->authToken,
                'pageviewimg' =>  $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&columns=nb_pageviews%2Cnb_uniq_pageviews&token_auth='.$this->authToken,
                'searchesandkeywordsimg' => $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&columns=nb_searches%2Cnb_keywords&token_auth='.$this->authToken,
                'downloadsimg' => $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&columns=nb_downloads%2Cnb_uniq_downloads&token_auth='.$this->authToken,
                'outlinksimg' => $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&columns=nb_outlinks%2Cnb_uniq_outlinks&token_auth='.$this->authToken,
                'maxactionsimg' => $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&columns=max_actions&token_auth='.$this->authToken,
                'data'=> $data
            ]);
    }

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