<?php

namespace App\Views;

use App\Services\RegionService;
use App\Services\ThemeService;
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
        $themes = $this->themeService->getThemes();
        $regions = $this->regionService->getRegions();

        $view->with('themes', $themes);
        $view->with('regions', $regions);
    }

}
