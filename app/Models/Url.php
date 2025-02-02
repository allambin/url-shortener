<?php

namespace App\Models;

use Database\Factories\UrlFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $url
 * @property string $short_url
 * @property string $alias
 */
class Url extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'alias'];

    protected static function newFactory()
    {
        return UrlFactory::new();
    }

    protected function shortUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => rtrim(config('app.url'), '/') . '/' . $this->alias,
        );
    }
}
