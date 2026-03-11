<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceAlert extends Model
{
	protected $fillable = [
		'user_id',
		'symbol',
		'condition',
		'target_price',
		'triggered'
	];
}
