<?php

namespace App\Helpers;

use App\Models\Language;

function getAdminDefaultLang($onlyId = true)
{
    $language = Language::where('status', true)->where('default', true)->first();
    if ($onlyId) return $language->id;
    return $language;
}
