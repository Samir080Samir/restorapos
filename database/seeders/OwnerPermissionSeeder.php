<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OwnerPermission;

class OwnerPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            /*
            |--------------------------------------------------------------------------
            | PANEL İCAZƏLƏRİ
            |--------------------------------------------------------------------------
            */

            ['type' => 'panel', 'group' => 'Statistikalar', 'name' => 'Statistikaları görə bilsin', 'slug' => 'panel.statistics.view'],

            ['type' => 'panel', 'group' => 'Satış', 'name' => 'Satış bölməsini görə bilsin', 'slug' => 'panel.sales.view'],
            ['type' => 'panel', 'group' => 'Satış', 'name' => 'Çekləri görə bilsin', 'slug' => 'panel.sales.receipts.view'],
            ['type' => 'panel', 'group' => 'Satış', 'name' => 'Geri qaytarmaları görə bilsin', 'slug' => 'panel.sales.refunds.view'],

            ['type' => 'panel', 'group' => 'Maliyyə', 'name' => 'Maliyyəni görə bilsin', 'slug' => 'panel.finance.view'],
            ['type' => 'panel', 'group' => 'Maliyyə', 'name' => 'Əməliyyatları idarə edə bilsin', 'slug' => 'panel.finance.transactions.manage'],
            ['type' => 'panel', 'group' => 'Maliyyə', 'name' => 'Əməkhaqqını idarə edə bilsin', 'slug' => 'panel.finance.payroll.manage'],
            ['type' => 'panel', 'group' => 'Maliyyə', 'name' => 'Mənfəət və zərəri görə bilsin', 'slug' => 'panel.finance.profit_loss.view'],

            ['type' => 'panel', 'group' => 'Menyu', 'name' => 'Menyunu görə bilsin', 'slug' => 'panel.menu.view'],
            ['type' => 'panel', 'group' => 'Menyu', 'name' => 'Məhsulları idarə edə bilsin', 'slug' => 'panel.menu.products.manage'],
            ['type' => 'panel', 'group' => 'Menyu', 'name' => 'Kateqoriyaları idarə edə bilsin', 'slug' => 'panel.menu.categories.manage'],
            ['type' => 'panel', 'group' => 'Menyu', 'name' => 'Modifikatorları idarə edə bilsin', 'slug' => 'panel.menu.modifiers.manage'],

            ['type' => 'panel', 'group' => 'İnventar', 'name' => 'İnventarı görə bilsin', 'slug' => 'panel.inventory.view'],
            ['type' => 'panel', 'group' => 'İnventar', 'name' => 'Tədarükləri idarə edə bilsin', 'slug' => 'panel.inventory.supplies.manage'],
            ['type' => 'panel', 'group' => 'İnventar', 'name' => 'Anbarı idarə edə bilsin', 'slug' => 'panel.inventory.warehouse.manage'],
            ['type' => 'panel', 'group' => 'İnventar', 'name' => 'İnventarlaşdırma edə bilsin', 'slug' => 'panel.inventory.stocktaking.manage'],

            ['type' => 'panel', 'group' => 'Filiallar', 'name' => 'Filialları görə bilsin', 'slug' => 'panel.branches.view'],
            ['type' => 'panel', 'group' => 'Filiallar', 'name' => 'Filialları redaktə edə bilsin', 'slug' => 'panel.branches.edit'],

            ['type' => 'panel', 'group' => 'Əməkdaşlar', 'name' => 'Əməkdaşları görə bilsin', 'slug' => 'panel.staff.view'],
            ['type' => 'panel', 'group' => 'Əməkdaşlar', 'name' => 'Əməkdaş yarada bilsin', 'slug' => 'panel.staff.create'],
            ['type' => 'panel', 'group' => 'Əməkdaşlar', 'name' => 'Əməkdaş redaktə edə bilsin', 'slug' => 'panel.staff.edit'],
            ['type' => 'panel', 'group' => 'Əməkdaşlar', 'name' => 'Vəzifə və icazələri idarə edə bilsin', 'slug' => 'panel.staff.roles.manage'],

            ['type' => 'panel', 'group' => 'Tənzimləmələr', 'name' => 'Tənzimləmələri görə bilsin', 'slug' => 'panel.settings.view'],
            ['type' => 'panel', 'group' => 'Tənzimləmələr', 'name' => 'Vergiləri idarə edə bilsin', 'slug' => 'panel.settings.taxes.manage'],
            ['type' => 'panel', 'group' => 'Tənzimləmələr', 'name' => 'Çek parametrlərini idarə edə bilsin', 'slug' => 'panel.settings.receipts.manage'],

            /*
            |--------------------------------------------------------------------------
            | POS İCAZƏLƏRİ
            |--------------------------------------------------------------------------
            */

            ['type' => 'pos', 'group' => 'Sifariş', 'name' => 'Sifariş yarada bilsin', 'slug' => 'pos.order.create'],
            ['type' => 'pos', 'group' => 'Sifariş', 'name' => 'Sifarişi redaktə edə bilsin', 'slug' => 'pos.order.edit'],
            ['type' => 'pos', 'group' => 'Sifariş', 'name' => 'Sifarişi ləğv edə bilsin', 'slug' => 'pos.order.cancel'],
            ['type' => 'pos', 'group' => 'Sifariş', 'name' => 'Məhsulu sifarişdən silə bilsin', 'slug' => 'pos.order.item_remove'],

            ['type' => 'pos', 'group' => 'Ödəniş', 'name' => 'Ödəniş qəbul edə bilsin', 'slug' => 'pos.payment.accept'],
            ['type' => 'pos', 'group' => 'Ödəniş', 'name' => 'Çek çap edə bilsin', 'slug' => 'pos.receipt.print'],
            ['type' => 'pos', 'group' => 'Ödəniş', 'name' => 'Geri qaytarma edə bilsin', 'slug' => 'pos.refund.create'],

            ['type' => 'pos', 'group' => 'Masa', 'name' => 'Masaları görə bilsin', 'slug' => 'pos.table.view'],
            ['type' => 'pos', 'group' => 'Masa', 'name' => 'Masa dəyişdirə bilsin', 'slug' => 'pos.table.change'],
            ['type' => 'pos', 'group' => 'Masa', 'name' => 'Masaları birləşdirə bilsin', 'slug' => 'pos.table.merge'],
            ['type' => 'pos', 'group' => 'Masa', 'name' => 'Masa bağlaya bilsin', 'slug' => 'pos.table.close'],

            ['type' => 'pos', 'group' => 'Endirim', 'name' => 'Endirim tətbiq edə bilsin', 'slug' => 'pos.discount.apply'],
            ['type' => 'pos', 'group' => 'Endirim', 'name' => 'Manual endirim edə bilsin', 'slug' => 'pos.discount.manual'],

            ['type' => 'pos', 'group' => 'Kassa', 'name' => 'Kassa növbəsini aça bilsin', 'slug' => 'pos.shift.open'],
            ['type' => 'pos', 'group' => 'Kassa', 'name' => 'Kassa növbəsini bağlaya bilsin', 'slug' => 'pos.shift.close'],
            ['type' => 'pos', 'group' => 'Kassa', 'name' => 'Kassa hesabatını görə bilsin', 'slug' => 'pos.shift.report'],
        ];

        foreach ($permissions as $permission) {
            OwnerPermission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
    }
}
