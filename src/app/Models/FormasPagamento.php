<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class FormasPagamentos extends Model
{
    //
    protected $fillable = [
        'name',
        'total',
        'desconto',
        'liquido',
        'form_payment_code',
        'installment',
        'form_payment_code',
        'number_installments',
        'card_name',
        'card_number',
        'card_flag',
        'amount_transshipment',
        'need_transshipment',
        'get_transshipment',
        'transaction_id'
    ];

}
