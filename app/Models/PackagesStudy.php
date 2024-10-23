<?php

namespace App\Models;

use App\Enums\Config as ConfigEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagesStudy extends Model
{
    use HasFactory;
    // public $table = "packages_studies";

    protected $fillable = [
        'package_number',
        'type',
        'study',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function($query, $find) {
            return $query
                ->where('package_number', 'LIKE', $find . '%');
        });
    }

    public function scopeRender($query, $search)
    {
        return $query
            ->search($search)
            ->paginate(Config::getValueByCode(ConfigEnum::PAGE_SIZE))
            ->appends([
                'search' => $search,
            ]);
    }
    
    public function listpackage()
    {
        return $this->hasMany(ListPackage::class);
    }
}