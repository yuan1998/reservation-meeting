<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class MeetingRoom extends Model implements Sortable
{
    use HasFactory, HasDateTimeFormatter, SortableTrait;

    protected $sortable = [
        // 设置排序字段名称
        'order_column_name' => 'order',
        // 是否在创建时自动排序，此参数建议设置为true
        'sort_when_creating' => true,
    ];

    protected $casts = [
        'tools' => 'json'
    ];

    public static function toOptions() {
        return static::query()->select(['id' , 'title'])->get()->pluck('title' ,'id');
    }




}
