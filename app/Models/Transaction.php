<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = "transactions";
    protected $fillable = [
        'trasaction_id', 'time', 'payment_channel', 'amount', 'currency', 'signature', 'time_expired', 'shopper_first_name', 'shopper_last_name', 'type_doc_identi', 'Num_doc_identi', 'email', 'country_code', 'Phone', 'transaction_status'
    ];
}
