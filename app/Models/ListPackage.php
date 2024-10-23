<?php

namespace App\Models;

use App\Enums\Config as ConfigEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'nilai_mtk',
        'nilai_fisika',
        'nilai_kimia',
        'nilai_biologi',
        'nilai_sosiologi',
        'nilai_ekonomi',
        'nilai_sejarah',
        'nilai_geografi',
        'date_open',
        'time_open',
        'recommanded',
        'maximum',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function($query, $find) {
            return $query
                ->where('title', 'LIKE', $find . '%');
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
    
    public function studies()
    {
        return $this->belongsTo(PackagesStudy::class);
    }
}