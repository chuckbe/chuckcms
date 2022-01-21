<?php

namespace Chuckbe\Chuckcms\Controllers;

use Carbon\Carbon;
use Chuckbe\Chuckcms\Chuck\Matomo\QueryFactory;
use Chuckbe\Chuckcms\Chuck\SiteRepository;
use Chuckbe\Chuckcms\Models\Site;
use Chuckbe\Chuckcms\Models\User;
use ChuckSite;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class MatomoController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    private $site;
    private $siteRepository;
    private $user;
    private $siteId;
    private $authToken;
    private $matomoUrl;

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
        $this->matomoUrl = ChuckSite::getSetting('integrations.matomo-site-url');
    }

    public function reportingApi(Request $request)
    {
        $query_factory = QueryFactory::create($this->matomoUrl);
        $query_factory
            ->set('idSite', $this->siteId)
            ->set('token_auth', $this->authToken);

        $date = $this->getDateOrPeriodFromRequest($request);
        $period = $this->getDateOrPeriodFromRequest($request, true);

        $lastVisitsDetails = $query_factory->getQuery('Live.getLastVisitsDetails')
            ->setParameter('date', $date)
            ->setParameter('period', $period)
            ->setParameter('filter_limit', -1)
            ->execute()
            ->getResponse();

        $view = view('chuckcms::backend.dashboard.blocks.logs')->render();

        return response()->json(
            [
                'lastVisitsDetails' => $lastVisitsDetails,
                'htmlData'          => $view,
            ]
        );
    }

    public function visitorSummary(Request $request)
    {
        $query_factory = QueryFactory::create($this->matomoUrl);
        $query_factory
            ->set('idSite', $this->siteId)
            ->set('token_auth', $this->authToken);

        $visitorProfile = $query_factory->getQuery('Live.getVisitorProfile')
            ->setParameter('visitorId', $request->all()['visitorid'])
            ->execute()
            ->getResponse();

        $view = view('chuckcms::backend.dashboard.blocks.visitor_modal')->render();

        return response()->json(
            [
                'visitorProfile' => $visitorProfile,
                'visitorModal'   => $view,
            ]
        );
    }

    public function getLiveCounter()
    {
        $query_factory = QueryFactory::create($this->matomoUrl);
        $query_factory
            ->set('idSite', $this->siteId)
            ->set('token_auth', $this->authToken);

        $liveCounter = $query_factory->getQuery('Live.getCounters')
            ->setParameter('lastMinutes', 3)
            ->execute()
            ->getResponse();

        return response()->json(
            [
                'liveCounter' => $liveCounter,
            ]
        );
    }

    public function getVisitsData(Request $request)
    {
        $date = $this->getDateOrPeriodFromRequest($request);
        $period = $this->getDateOrPeriodFromRequest($request, true);

        $imgDate = '';

        switch ($period) {
            case 'range':
                $imgDate = $date;
                break;

            case 'week':
            case 'month':
                $value = $request->all()['value'];
                $range = [
                    'start' => $value['y2'].'-'.$value['m2'].'-'.$value['d2'],
                    'end'   => $value['y1'].'-'.$value['m1'].'-'.$value['d1'],
                ];
                $imgDate = $range['start'].','.$range['end'];
                break;

            case 'day':
                if ($date == 'today') {
                    $imgDate = date('Y-m-d').','.date('Y-m-d', strtotime(date('Y-m-d').' 2 day'));
                }
                if ($date == 'yesterday') {
                    $imgDate = date('Y-m-d').','.date('Y-m-d', strtotime(date('Y-m-d').' 2 day'));
                }
                break;
        }

        $matomoUrl = $this->matomoUrl;
        $query_factory = QueryFactory::create($matomoUrl);

        $query_factory
            ->set('idSite', $this->siteId)
            ->set('token_auth', $this->authToken);

        $data = $query_factory->getQuery('API.get ')
            ->setParameter('date', $date)
            ->setParameter('period', $period)
            ->execute()
            ->getResponse();

        return response()->json(
            [
                'visitimg'               => $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&segment=&showtitle=1&random=6179&columns=nb_visits%2Cnb_uniq_visitors&token_auth='.$this->authToken,
                'avgvisitimg'            => $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&showtitle=1&random=6179&columns=avg_time_on_site&token_auth='.$this->authToken,
                'bouncerateimg'          => $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&columns=bounce_rate&token_auth='.$this->authToken,
                'actions_per_visit_img'  => $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&columns=nb_actions_per_visit&token_auth='.$this->authToken,
                'pageviewimg'            => $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&columns=nb_pageviews%2Cnb_uniq_pageviews&token_auth='.$this->authToken,
                'searchesandkeywordsimg' => $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&columns=nb_searches%2Cnb_keywords&token_auth='.$this->authToken,
                'downloadsimg'           => $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&columns=nb_downloads%2Cnb_uniq_downloads&token_auth='.$this->authToken,
                'outlinksimg'            => $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&columns=nb_outlinks%2Cnb_uniq_outlinks&token_auth='.$this->authToken,
                'maxactionsimg'          => $matomoUrl.'/index.php?forceView=1&viewDataTable=sparkline&module=API&action=get&idSite='.$this->siteId.'&period='.$period.'&date='.$imgDate.'&columns=max_actions&token_auth='.$this->authToken,
                'data'                   => $data,
            ]
        );
    }

    public function getReferrers(Request $request)
    {
        $query_factory = QueryFactory::create($this->matomoUrl);

        $query_factory
            ->set('idSite', $this->siteId)
            ->set('token_auth', $this->authToken);

        $date = $this->getDateOrPeriodFromRequest($request);
        $period = $this->getDateOrPeriodFromRequest($request, true);

        $referrers = $query_factory->getQuery('Referrers.getAll')
            ->setParameter('date', $date)
            ->setParameter('period', $period)
            ->execute()
            ->getResponse();

        return response()->json(
            [
                'data' => $referrers,
            ]
        );
    }

    private function getDateOrPeriodFromRequest(Request $request, $periodCheck = false)
    {
        $data = $request->all()['value'];
        $date = strtolower($data['range']);
        $period = 'day';

        if (!isset($data['y2'], $data['m2'], $data['d2'])) {
            return $periodCheck ? $period : $date;
        }

        $range = [
            'start' => $data['y2'].'-'.$data['m2'].'-'.$data['d2'],
            'end'   => $data['y1'].'-'.$data['m1'].'-'.$data['d1'],
        ];

        $now = Carbon::now();
        $start = Carbon::createFromFormat('Y-m-d', $range['start']);
        $end = Carbon::createFromFormat('Y-m-d', $range['end']);

        $difference = $now->diffInDays($end); // difference in days between end date and now
        $diffStartToEnd = $start->diffInDays($end); //difference in days between start date and end date

        if ($diffStartToEnd == 6) {
            $period = 'week';
            $date = 'last7';
        }

        if ($diffStartToEnd == 29) {
            $period = 'month';
            $date = 'last30';
        }

        if ($difference > 0) {
            $period = 'range';
            $date = $range['start'].','.$range['end'];
        }

        return $periodCheck ? $period : $date;
    }
}
