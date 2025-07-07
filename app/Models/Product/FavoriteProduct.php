<?php

namespace App\Models\Product;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    protected $fillable = ['api_id', 'user_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'api_id' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * Get the user that owns the favorite product.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
