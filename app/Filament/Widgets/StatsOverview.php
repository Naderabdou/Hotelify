<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\Contact;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\LanguageStudy;
use App\Models\CustomerReview;
use App\Models\Partner;
use App\Models\Project;
use App\Models\RegulationCategory;
use App\Models\Regulations;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\StudyDestination;
use App\Models\TouristDestination;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('Total Services'), Service::count())
                ,
            Stat::make(__('Total Projects'), Project::count()),
            Stat::make(__('Total Blogs'), Blog::count()),
            Stat::make(__('Total Partners'), Partner::count()),
        //    Stat::make(__('Total Sliders'), Slider::count()),
        //    Stat::make(__('Total regulations'), Regulations::count()),
          //  Stat::make(__('Total Regulation Category'), RegulationCategory::count()),
        //    Stat::make(__('Total Orders Services'), ServiceOrder::count()),
            Stat::make(__('Total Contacts Us'), Contact::count()),
            Stat::make(__('Total Settings'), Setting::count()),



        ];
    }
}
