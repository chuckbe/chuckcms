<?php

namespace Chuckbe\Chuckcms\ViewComposers;

use Illuminate\View\View;
use VisualAppeal\Matomo;
use MatomoTracker;

class MatomoComposer
{
    /**
     * Create a new sidebar composer.
     *
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
       
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {



        $matomo = new Matomo("https://analytics.chuck.be", "d6fdc36dc7f4c0c88fa58d189a88ae4b", 6);
        $matomoUniqueVisitorsWeek = $matomo->setPeriod(Matomo::PERIOD_WEEK)->setDate('last7')->setFormat(Matomo::FORMAT_JSON)->getUniqueVisitors();
        $matomoContries = $matomo->setPeriod(Matomo::PERIOD_DAY)->setDate(Matomo::DATE_TODAY)->setFormat(Matomo::FORMAT_JSON)->getCountry();
        $matomoSummaryToday = $matomo->setPeriod(Matomo::PERIOD_DAY)->setDate(Matomo::DATE_TODAY)->setFormat(Matomo::FORMAT_JSON)->getVisitsSummary();
        $matomoSummaryWeek = $matomo->setPeriod(Matomo::PERIOD_WEEK)->setDate(Matomo::DATE_TODAY)->setFormat(Matomo::FORMAT_JSON)->getVisitsSummary();
        $matomoSummaryMonth = $matomo->setPeriod(Matomo::PERIOD_MONTH)->setDate(Matomo::DATE_TODAY)->setFormat(Matomo::FORMAT_JSON)->getVisitsSummary();
        $matomoSummaryYear = $matomo->setPeriod(Matomo::PERIOD_YEAR)->setDate(Matomo::DATE_TODAY)->setFormat(Matomo::FORMAT_JSON)->getVisitsSummary();
        $matomoApi = $matomo->setFormat(Matomo::FORMAT_JSON)->getApi();
       
        $view->with([
            'matomoUniqueVisitorsWeek'=> $matomoUniqueVisitorsWeek,
            'matomoContries' => $matomoContries,
            'matomoSummaryToday' => $matomoSummaryToday,
            'matomoSummaryWeek' => $matomoSummaryWeek,
            'matomoSummaryMonth' => $matomoSummaryMonth,
            'matomoSummaryYear' => $matomoSummaryYear,
            'matomoApi' => $matomoApi
        ]);
    }
}