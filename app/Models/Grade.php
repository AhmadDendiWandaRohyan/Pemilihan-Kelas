<?php

namespace App\Models;

use App\Enums\Config as ConfigEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mtk',
        'fisika',
        'kimia',
        'biologi',
        'sosiologi',
        'ekonomi',
        'sejarah',
        'geografi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function($query, $find) {
            return $query
                ->where('nisn', 'LIKE', $find . '%');
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
    
    public function list(){
        return $this->hasOne(ModelType::class, 'id', 'user_id');
    }
    
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}