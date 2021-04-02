<?php

namespace Chuckbe\Chuckcms\ViewComposers;

use Illuminate\View\View;
use VisualAppeal\Matomo;


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
        // MATOMO_URL="https://analytics.chuck.be"
        // MATOMO_SITE_ID=6
        // MATOMO_AUTH_TOKEN="d6fdc36dc7f4c0c88fa58d189a88ae4b"

        //$matomo = new Matomo(env('MATOMO_URL'), env('MATOMO_AUTH_TOKEN'), env('MATOMO_SITE_ID'));
        $matomo = new Matomo("https://analytics.chuck.be", "d6fdc36dc7f4c0c88fa58d189a88ae4b", 6);
        $matomoUniqueVisitorsToday = $matomo->setPeriod(Matomo::PERIOD_DAY)->setDate(Matomo::DATE_YESTERDAY)->setFormat(Matomo::FORMAT_JSON)->getUniqueVisitors();
        $matomoVisitsToday = $matomo->setPeriod(Matomo::PERIOD_DAY)->setDate(Matomo::DATE_YESTERDAY)->setFormat(Matomo::FORMAT_JSON)->getVisits();
        $matomoData = $matomo->getSumVisitsLengthPretty();

        $view->with([
            'matomoUniqueVisitorsToday'=> $matomoUniqueVisitorsToday,
            'matomoVisitsToday' => $matomoVisitsToday,
            'matomoData' => $matomoData
        ]);
    }
}