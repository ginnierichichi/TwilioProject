<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['body', 'status'];

    public function getStatusColourAttribute()
    {
        return [
            'queued' => 'gray',
            'delivered' => 'green',
            'sent' => 'green',
            'failed' => 'red',
        ][$this->status ?? 'gray'];
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addressBook()
    {
        return $this->belongsTo(AddressBook::class);
    }
}
