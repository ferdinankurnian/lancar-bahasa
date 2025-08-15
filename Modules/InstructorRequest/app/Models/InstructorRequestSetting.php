<?php

namespace Modules\InstructorRequest\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InstructorRequestSetting extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id', 'need_certificate', 'need_identity_scan', 'bank_information'];
    public function getInstructionsAttribute(): ?string {
        return $this?->translation?->instructions;
    }
    public function translation(): ?HasOne {
        return $this->hasOne(InstructorRequestSettingTranslation::class)->where('lang_code', getSessionLanguage());
    }

    public function getTranslation($code): ?InstructorRequestSettingTranslation {
        return $this->hasOne(InstructorRequestSettingTranslation::class)->where('lang_code', $code)->first();
    }

    public function translations(): ?HasMany {
        return $this->hasMany(InstructorRequestSettingTranslation::class, 'instructor_request_setting_id');
    }

}
