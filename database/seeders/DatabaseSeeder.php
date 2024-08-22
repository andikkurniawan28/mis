<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use App\Models\Setup;
use App\Models\Feature;
use App\Models\Permission;
use App\Models\AccountGroup;
use Illuminate\Database\Seeder;
use App\Models\FinancialStatement;
use App\Models\NormalBalance;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $setup = [
            'app_name' => ucwords(str_replace('_', ' ', 'MIS')),
            'company_name' => ucwords(str_replace('_', ' ', 'PG Kebon Agung')),
            'company_logo' => 'setups/1718631326.png',
        ];
        Setup::insert($setup);

        $roles = [
            ['name' => ucwords(str_replace('_', ' ', 'CEO'))],
        ];
        Role::insert($roles);

        $users = [
            [
                'name' => ucwords(str_replace('_', ' ', 'master')),
                'username' => 'master',
                'password' => bcrypt('master'),
                'role_id' => 1,
                'is_active' => 1,
            ],
        ];
        User::insert($users);

        $features = [
            ['name' => ucfirst(str_replace('_', ' ', 'setup')), 'route' => 'setup.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_setup')), 'route' => 'setup.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_role')), 'route' => 'role.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_role')), 'route' => 'role.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_role')), 'route' => 'role.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_role')), 'route' => 'role.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_role')), 'route' => 'role.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_role')), 'route' => 'role.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_user')), 'route' => 'user.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_user')), 'route' => 'user.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_user')), 'route' => 'user.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_user')), 'route' => 'user.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_user')), 'route' => 'user.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_user')), 'route' => 'user.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'activity_log')), 'route' => 'activity_log'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_financial_statement')), 'route' => 'financial_statement.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_financial_statement')), 'route' => 'financial_statement.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_financial_statement')), 'route' => 'financial_statement.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_financial_statement')), 'route' => 'financial_statement.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_financial_statement')), 'route' => 'financial_statement.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_financial_statement')), 'route' => 'financial_statement.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_normal_balance')), 'route' => 'normal_balance.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_normal_balance')), 'route' => 'normal_balance.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_normal_balance')), 'route' => 'normal_balance.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_normal_balance')), 'route' => 'normal_balance.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_normal_balance')), 'route' => 'normal_balance.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_normal_balance')), 'route' => 'normal_balance.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_account_group')), 'route' => 'account_group.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_account_group')), 'route' => 'account_group.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_account_group')), 'route' => 'account_group.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_account_group')), 'route' => 'account_group.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_account_group')), 'route' => 'account_group.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_account_group')), 'route' => 'account_group.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_main_account')), 'route' => 'main_account.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_main_account')), 'route' => 'main_account.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_main_account')), 'route' => 'main_account.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_main_account')), 'route' => 'main_account.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_main_account')), 'route' => 'main_account.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_main_account')), 'route' => 'main_account.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_sub_account')), 'route' => 'sub_account.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_sub_account')), 'route' => 'sub_account.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_sub_account')), 'route' => 'sub_account.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_sub_account')), 'route' => 'sub_account.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_sub_account')), 'route' => 'sub_account.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_sub_account')), 'route' => 'sub_account.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_account')), 'route' => 'account.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_account')), 'route' => 'account.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_account')), 'route' => 'account.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_account')), 'route' => 'account.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_account')), 'route' => 'account.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_account')), 'route' => 'account.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_tax_rate')), 'route' => 'tax_rate.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_tax_rate')), 'route' => 'tax_rate.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_tax_rate')), 'route' => 'tax_rate.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_tax_rate')), 'route' => 'tax_rate.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_tax_rate')), 'route' => 'tax_rate.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_tax_rate')), 'route' => 'tax_rate.destroy'],
        ];
        Feature::insert($features);

        foreach (Feature::select('id')->orderBy('id')->get() as $feature) {
            Permission::insert([
                "feature_id" => $feature->id,
                "role_id" => 1,
            ]);
        }

        FinancialStatement::insert([
            ["id" => "B", "name" => "Balance Sheet"],
            ["id" => "I", "name" => "Income Statement"],
        ]);

        NormalBalance::insert([
            ["id" => "D", "name" => "Debit"],
            ["id" => "C", "name" => "Credit"],
        ]);

        AccountGroup::insert([
            ["id" => "10", "financial_statement_id" => "B", "name" => "Aktiva Lancar"],
            ["id" => "11", "financial_statement_id" => "B", "name" => "Aktiva Tetap"],
            ["id" => "12", "financial_statement_id" => "B", "name" => "Aktiva Lain-lain"],
            ["id" => "20", "financial_statement_id" => "B", "name" => "Kewajiban Lancar"],
            ["id" => "21", "financial_statement_id" => "B", "name" => "Kewajiban Jangka Panjang"],
            ["id" => "30", "financial_statement_id" => "B", "name" => "Modal"],
            ["id" => "40", "financial_statement_id" => "I", "name" => "Pendapatan Penjualan"],
            ["id" => "50", "financial_statement_id" => "I", "name" => "Harga Pokok Penjualan"],
            ["id" => "60", "financial_statement_id" => "I", "name" => "Beban Operasional"],
            ["id" => "70", "financial_statement_id" => "I", "name" => "Pendapatan Lain-lain"],
            ["id" => "80", "financial_statement_id" => "I", "name" => "Beban Lain-lain"],
        ]);

    }
}
