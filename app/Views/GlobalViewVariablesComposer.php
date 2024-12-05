<?php

namespace App\Views;

use App\Services\RegionService;
use App\Services\ThemeService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class GlobalViewVariablesComposer
{
    private ThemeService $themeService;
    private RegionService $regionService;

    public function __construct(ThemeService $themeService, RegionService $regionService)
    {
        $this->themeService = $themeService;
        $this->regionService = $regionService;
    }

    public function compose(View $view)
    {
//        $themes = $this->themeService->getThemes();
//        $view->with('themes', $themes);
        $regions = $this->regionService->getRegions();
        $view->with('regions', $regions);

        $userData = json_decode(Cookie::get('userData'), true);
        $view->with('userData', $userData);
    }

}
