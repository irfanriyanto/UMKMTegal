<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductView extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'ip_address',
        'viewed_date',
    ];

    protected function casts(): array
    {
        return [
            'viewed_date' => 'date',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function recordView(int $productId, string $ipAddress): void
    {
        static::firstOrCreate([
            'product_id' => $productId,
            'ip_address' => $ipAddress,
            'viewed_date' => now()->toDateString(),
        ]);
    }
}
