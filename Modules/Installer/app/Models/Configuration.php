<?php

namespace Modules\Installer\app\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Configuration extends Model
{
    use HasFactory;

    public $fillable = [
        'config',
        'value',
    ];

    public static function setupStepCheck($step)
    {
        try {
            $data = Configuration::where('config', 'setup_stage')->first();
            if ($step == $data['value']) {
                return true;
            }

            return false;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public static function stepExists()
    {
        try {
            if ($data = Configuration::where('config', 'setup_stage')->first()) {
                return $data['value'];
            }

            return false;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public static function updateStep($step)
    {
        try {
            if (Configuration::where('config', 'setup_stage')->firstOrFail()->update(['value' => $step])) {
                return true;
            }

            return false;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public static function updateCompeteStatus($step)
    {
        try {
            if (Configuration::where('config', 'setup_complete')->firstOrFail()->update(['value' => $step])) {
                return true;
            }

            return false;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
