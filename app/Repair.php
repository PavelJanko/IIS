<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['device_id', 'claimant_id', 'claimed_at', 'repairer_id', 'repaired_at', 'state'];

    /**
     * Gets the employee that claimed the repair.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function claimant()
    {
        return $this->belongsTo(Employee::class, 'claimant_id');
    }

    /**
     * Gets the device associated with the repair.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * Gets the employee that performed the repair.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function repairer()
    {
        return $this->belongsTo(Employee::class, 'repairer_id');
    }
}
