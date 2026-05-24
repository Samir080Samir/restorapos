<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            /*
            |--------------------------------------------------
            | Filial
            |--------------------------------------------------
            */

            if (! Schema::hasColumn('products', 'branch_id')) {

                $table->foreignId('branch_id')
                    ->nullable()
                    ->after('restaurant_id')
                    ->constrained()
                    ->nullOnDelete();
            }

            /*
            |--------------------------------------------------
            | Kateqoriya
            |--------------------------------------------------
            */

            if (! Schema::hasColumn('products', 'menu_category_id')) {

                $table->foreignId('menu_category_id')
                    ->nullable()
                    ->after('branch_id')
                    ->constrained('menu_categories')
                    ->nullOnDelete();
            }

            /*
            |--------------------------------------------------
            | Şöbə
            |--------------------------------------------------
            */

            if (! Schema::hasColumn('products', 'menu_department_id')) {

                $table->foreignId('menu_department_id')
                    ->nullable()
                    ->after('menu_category_id')
                    ->constrained('menu_departments')
                    ->nullOnDelete();
            }

            /*
            |--------------------------------------------------
            | Barkod
            |--------------------------------------------------
            */

            if (! Schema::hasColumn('products', 'barcode')) {

                $table->string('barcode')
                    ->nullable()
                    ->after('slug');
            }

            /*
            |--------------------------------------------------
            | Açıqlama
            |--------------------------------------------------
            */

            if (! Schema::hasColumn('products', 'description')) {

                $table->text('description')
                    ->nullable()
                    ->after('barcode');
            }

            /*
            |--------------------------------------------------
            | Rəng
            |--------------------------------------------------
            */

            if (! Schema::hasColumn('products', 'color')) {

                $table->string('color')
                    ->nullable()
                    ->after('image');
            }

            /*
            |--------------------------------------------------
            | Maya dəyəri
            |--------------------------------------------------
            */

            if (! Schema::hasColumn('products', 'cost_price')) {

                $table->decimal('cost_price', 10, 2)
                    ->default(0)
                    ->after('color');
            }

            /*
            |--------------------------------------------------
            | Satış qiyməti
            |--------------------------------------------------
            */

            if (! Schema::hasColumn('products', 'sale_price')) {

                $table->decimal('sale_price', 10, 2)
                    ->default(0)
                    ->after('cost_price');
            }

            /*
            |--------------------------------------------------
            | POS seçimləri
            |--------------------------------------------------
            */

            if (! Schema::hasColumn('products', 'is_hidden')) {

                $table->boolean('is_hidden')
                    ->default(false)
                    ->after('sale_price');
            }

            if (! Schema::hasColumn('products', 'is_gift')) {

                $table->boolean('is_gift')
                    ->default(false)
                    ->after('is_hidden');
            }

            if (! Schema::hasColumn('products', 'allow_discount')) {

                $table->boolean('allow_discount')
                    ->default(true)
                    ->after('is_gift');
            }

            if (! Schema::hasColumn('products', 'sold_by_weight')) {

                $table->boolean('sold_by_weight')
                    ->default(false)
                    ->after('allow_discount');
            }

            if (! Schema::hasColumn('products', 'show_in_terminal')) {

                $table->boolean('show_in_terminal')
                    ->default(true)
                    ->after('sold_by_weight');
            }

            /*
            |--------------------------------------------------
            | Sıralama
            |--------------------------------------------------
            */

            if (! Schema::hasColumn('products', 'sort_order')) {

                $table->integer('sort_order')
                    ->default(0)
                    ->after('show_in_terminal');
            }

            /*
            |--------------------------------------------------
            | Aktivlik
            |--------------------------------------------------
            */

            if (! Schema::hasColumn('products', 'is_active')) {

                $table->boolean('is_active')
                    ->default(true)
                    ->after('sort_order');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $columns = [
                'branch_id',
                'menu_category_id',
                'menu_department_id',
                'barcode',
                'description',
                'color',
                'cost_price',
                'sale_price',
                'is_hidden',
                'is_gift',
                'allow_discount',
                'sold_by_weight',
                'show_in_terminal',
                'sort_order',
                'is_active',
            ];

            foreach ($columns as $column) {

                if (Schema::hasColumn('products', $column)) {

                    $table->dropColumn($column);
                }
            }
        });
    }
};
