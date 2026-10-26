<?php

namespace App\Filament\User\Resources\Campaigns\Pages;

use App\Filament\User\Resources\Campaigns\CampaignResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCampaign extends CreateRecord
{
    protected static string $resource = CampaignResource::class;

    protected  function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth('web')->id();
        return $data;
    }
}
