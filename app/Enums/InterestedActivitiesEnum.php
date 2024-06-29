<?php

namespace App\Enums;

use App\Attributes\Description;
use App\Models\Traits\AttributableEnum;

enum InterestedActivitiesEnum : string
{
    use AttributableEnum;
    
    #[Description('Farm Tours')]
    case FarmTours = 'farm_tours';

    #[Description('Harvesting Experiences')]
    case HarvestingExperiences = 'harvesting_experiences';

    #[Description('Interactive Workshops')]
    case InteractiveWorkshops = 'interactive_workshops';

    #[Description('Cultural Events')]
    case CulturalEvents = 'cultural_events';

    #[Description('Farm Stays')]
    case FarmStays = 'farm_stays';
}
