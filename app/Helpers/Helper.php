<?php


use App\Models\Language;

function getAdminDefaultLang($onlyId = true)
{
    $language = Language::where('status', true)->where('default', true)->first();
    if ($onlyId) return $language->id;
    return $language;
}

function getLanguages($columns = ['id','name'])
{
    return Language::where('status', true)->get($columns);
}
?>