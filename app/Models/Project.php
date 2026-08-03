<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $table = 'company_projects';

    protected $fillable = [
        'company_id',
        'project_name',
        'employer',
        'start_date',
        'end_date',
        'service_description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /**
     * شرکت صاحب پروژه
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
