<?php

namespace App\Http\Controllers;

use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        return Setting::all(['key', 'value', 'value_json', 'type'])
            ->mapWithKeys(function (Setting $setting) {
                $value = $setting->type === 'translatable_text'
                    ? $setting->value_json
                    : $setting->value;

                return [$setting->key => $value];
            });
    }
}
