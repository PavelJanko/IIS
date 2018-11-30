<?php

namespace App;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['keeper_id', 'room_id', 'serial_number', 'name', 'type', 'manufacturer'];

    /**
     * Gets the person who owns or takes care of the device.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function keeper()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Gets all the information about repairs performed on the device.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

    /**
     * Gets the room which the device is located in.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        /**
         * If the device doesn't have a room assigned (therefore it isn't in CVT),
         * then we simply return the keeper's assigned room.
         */
        if ($this->room_id !== NULL)
            return $this->belongsTo(Room::class);
        else
            return $this->keeper->belongsTo(Room::class);
    }
}
