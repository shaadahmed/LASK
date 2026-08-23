<?php

namespace App\Services;

use App\Models\Navigation;
use Illuminate\Database\Eloquent\Collection;

class NavigationService
{
    public function getActiveNavigations(): Collection
    {
        return Navigation::query()
            ->active()
            ->orderBy('order')
            ->get();
    }
}
