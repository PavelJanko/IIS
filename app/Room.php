<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['department_id', 'label', 'description', 'is_in_cvt'];

    /**
     * Gets the information whether the device is in CVT or not.
     *
     * @return boolean
     */
    public function isInCVT()
    {
        return $this->is_in_cvt;
    }

    /**
     * Gets the department which the room is part of.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
