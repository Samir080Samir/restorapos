<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Mass assignable columns
     */
    protected $fillable = [

        /*
        |--------------------------------------------------
        | Əlaqələr
        |--------------------------------------------------
        */

        'restaurant_id',
        'branch_id',
        'menu_category_id',
        'menu_department_id',

        /*
        |--------------------------------------------------
        | Məhsul məlumatları
        |--------------------------------------------------
        */

        'name',
        'slug',
        'barcode',
        'description',

        /*
        |--------------------------------------------------
        | Şəkil və rəng
        |--------------------------------------------------
        */

        'image',
        'color',

        /*
        |--------------------------------------------------
        | Qiymətlər
        |--------------------------------------------------
        */

        'cost_price',
        'sale_price',

        /*
        |--------------------------------------------------
        | POS seçimləri
        |--------------------------------------------------
        */

        'is_hidden',
        'is_gift',
        'allow_discount',
        'sold_by_weight',
        'show_in_terminal',

        /*
        |--------------------------------------------------
        | Status
        |--------------------------------------------------
        */

        'sort_order',
        'is_active',
    ];

    /**
     * Restaurant relation
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Branch relation
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Menu category relation
     */
    public function menuCategory()
    {
        return $this->belongsTo(MenuCategory::class);
    }

    /**
     * Menu department relation
     */
    public function menuDepartment()
    {
        return $this->belongsTo(MenuDepartment::class);
    }

    /**
     * Məhsul aktivdir?
     */
    public function isAvailable()
    {
        return $this->is_active == true;
    }

    /**
     * Terminalda görünür?
     */
    public function isVisibleInPos()
    {
        return $this->show_in_terminal == true;
    }
}
