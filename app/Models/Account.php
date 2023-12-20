<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'account_number', 'currency', 'balance', 'approved_by_agent_id', 'status'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Get the user that owns the account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the banking agent who approved the account.
     */
    public function approvedByAgent()
    {
        return $this->belongsTo(User::class, 'approved_by_agent_id');
    }

    /**
     * Get the transactions for the bank account.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Additional methods related to account logic can be added here
}