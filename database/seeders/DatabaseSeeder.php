<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\Setup;
use App\Models\Account;
use App\Models\Feature;
use App\Models\TaxRate;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Material;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Permission;
use App\Models\SubAccount;
use App\Models\MainAccount;
use App\Models\PaymentTerm;
use App\Models\AccountGroup;
use App\Models\NormalBalance;
use Illuminate\Database\Seeder;
use App\Models\CashFlowCategory;
use App\Models\MaterialCategory;
use App\Models\FinancialStatement;
use Illuminate\Support\Facades\DB;
use App\Models\MaterialSubCategory;
use App\Models\TransactionCategory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_cash_flow_category')), 'route' => 'cash_flow_category.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_cash_flow_category')), 'route' => 'cash_flow_category.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_cash_flow_category')), 'route' => 'cash_flow_category.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_cash_flow_category')), 'route' => 'cash_flow_category.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_cash_flow_category')), 'route' => 'cash_flow_category.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_cash_flow_category')), 'route' => 'cash_flow_category.destroy'],
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
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_transaction_category')), 'route' => 'transaction_category.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_transaction_category')), 'route' => 'transaction_category.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_transaction_category')), 'route' => 'transaction_category.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_transaction_category')), 'route' => 'transaction_category.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_transaction_category')), 'route' => 'transaction_category.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_transaction_category')), 'route' => 'transaction_category.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_transaction_category')), 'route' => 'transaction_category.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_journal')), 'route' => 'journal.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_journal')), 'route' => 'journal.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_journal')), 'route' => 'journal.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_journal')), 'route' => 'journal.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_journal')), 'route' => 'journal.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_journal')), 'route' => 'journal.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_journal')), 'route' => 'journal.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_budget')), 'route' => 'budget.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_budget')), 'route' => 'budget.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_budget')), 'route' => 'budget.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_budget')), 'route' => 'budget.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_budget')), 'route' => 'budget.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_budget')), 'route' => 'budget.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_budget')), 'route' => 'budget.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'refresh_budget')), 'route' => 'budget.refresh'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_ledger')), 'route' => 'ledger.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'balance_sheet')), 'route' => 'balance_sheet.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'income_statement')), 'route' => 'income_statement.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'cash_flow')), 'route' => 'cash_flow.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_warehouse')), 'route' => 'warehouse.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_warehouse')), 'route' => 'warehouse.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_warehouse')), 'route' => 'warehouse.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_warehouse')), 'route' => 'warehouse.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_warehouse')), 'route' => 'warehouse.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_warehouse')), 'route' => 'warehouse.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_warehouse')), 'route' => 'warehouse.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_unit')), 'route' => 'unit.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_unit')), 'route' => 'unit.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_unit')), 'route' => 'unit.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_unit')), 'route' => 'unit.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_unit')), 'route' => 'unit.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_unit')), 'route' => 'unit.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_unit')), 'route' => 'unit.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_material_category')), 'route' => 'material_category.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_material_category')), 'route' => 'material_category.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_material_category')), 'route' => 'material_category.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_material_category')), 'route' => 'material_category.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_material_category')), 'route' => 'material_category.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_material_category')), 'route' => 'material_category.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_material_category')), 'route' => 'material_category.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_material_sub_category')), 'route' => 'material_sub_category.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_material_sub_category')), 'route' => 'material_sub_category.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_material_sub_category')), 'route' => 'material_sub_category.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_material_sub_category')), 'route' => 'material_sub_category.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_material_sub_category')), 'route' => 'material_sub_category.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_material_sub_category')), 'route' => 'material_sub_category.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_material_sub_category')), 'route' => 'material_sub_category.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_material')), 'route' => 'material.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_material')), 'route' => 'material.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_material')), 'route' => 'material.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_material')), 'route' => 'material.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_material')), 'route' => 'material.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_material')), 'route' => 'material.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_material')), 'route' => 'material.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_payment_term')), 'route' => 'payment_term.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_payment_term')), 'route' => 'payment_term.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_payment_term')), 'route' => 'payment_term.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_payment_term')), 'route' => 'payment_term.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_payment_term')), 'route' => 'payment_term.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_payment_term')), 'route' => 'payment_term.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_payment_term')), 'route' => 'payment_term.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_region')), 'route' => 'region.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_region')), 'route' => 'region.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_region')), 'route' => 'region.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_region')), 'route' => 'region.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_region')), 'route' => 'region.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_region')), 'route' => 'region.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_region')), 'route' => 'region.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_business')), 'route' => 'business.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_business')), 'route' => 'business.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_business')), 'route' => 'business.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_business')), 'route' => 'business.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_business')), 'route' => 'business.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_business')), 'route' => 'business.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_business')), 'route' => 'business.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_supplier')), 'route' => 'supplier.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_supplier')), 'route' => 'supplier.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_supplier')), 'route' => 'supplier.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_supplier')), 'route' => 'supplier.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_supplier')), 'route' => 'supplier.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_supplier')), 'route' => 'supplier.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_supplier')), 'route' => 'supplier.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_customer')), 'route' => 'customer.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_customer')), 'route' => 'customer.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_customer')), 'route' => 'customer.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_customer')), 'route' => 'customer.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_customer')), 'route' => 'customer.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_customer')), 'route' => 'customer.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_customer')), 'route' => 'customer.destroy'],
        ];
        Feature::insert($features);

        foreach (Feature::select('id')->orderBy('id')->get() as $feature) {
            Permission::insert([
                "feature_id" => $feature->id,
                "role_id" => 1,
            ]);
        }

        CashFlowCategory::insert([
            ["name" => "Aktifitas Operasional"],
            ["name" => "Aktifitas Investasi"],
            ["name" => "Aktifitas Pendanaan"],
        ]);

        FinancialStatement::insert([
            ["id" => "B", "name" => "Balance Sheet"],
            ["id" => "I", "name" => "Income Statement"],
        ]);

        NormalBalance::insert([
            ["id" => "D", "name" => "Debit"],
            ["id" => "C", "name" => "Credit"],
        ]);

        // Menambahkan Account Groups
        AccountGroup::insert([
            ["id" => "10", "financial_statement_id" => "B", "name" => "Aktiva Lancar", "normal_balance_id" => "D"],
            ["id" => "11", "financial_statement_id" => "B", "name" => "Aktiva Tetap", "normal_balance_id" => "D"],
            ["id" => "12", "financial_statement_id" => "B", "name" => "Aktiva Lain-lain", "normal_balance_id" => "D"],
            ["id" => "20", "financial_statement_id" => "B", "name" => "Kewajiban Lancar", "normal_balance_id" => "C"],
            ["id" => "21", "financial_statement_id" => "B", "name" => "Kewajiban Jangka Panjang", "normal_balance_id" => "C"],
            ["id" => "30", "financial_statement_id" => "B", "name" => "Modal", "normal_balance_id" => "C"],
            ["id" => "40", "financial_statement_id" => "I", "name" => "Pendapatan Penjualan", "normal_balance_id" => "C"],
            ["id" => "50", "financial_statement_id" => "I", "name" => "Harga Pokok Penjualan", "normal_balance_id" => "D"],
            ["id" => "60", "financial_statement_id" => "I", "name" => "Beban Operasional", "normal_balance_id" => "D"],
            ["id" => "70", "financial_statement_id" => "I", "name" => "Pendapatan Lain-lain", "normal_balance_id" => "C"],
            ["id" => "80", "financial_statement_id" => "I", "name" => "Beban Lain-lain", "normal_balance_id" => "D"],
        ]);

        // Menambahkan Main Accounts
        MainAccount::insert([
            ["id" => "101", "account_group_id" => "10", "name" => "Kas"],
            ["id" => "102", "account_group_id" => "10", "name" => "Piutang Dagang"],
            ["id" => "107", "account_group_id" => "10", "name" => "Persediaan"],
            ["id" => "103", "account_group_id" => "11", "name" => "Tanah"],
            ["id" => "104", "account_group_id" => "11", "name" => "Bangunan"],
            ["id" => "105", "account_group_id" => "11", "name" => "Peralatan"],
            ["id" => "106", "account_group_id" => "12", "name" => "Inventaris Lainnya"],
            ["id" => "201", "account_group_id" => "20", "name" => "Hutang Usaha"],
            ["id" => "202", "account_group_id" => "20", "name" => "Hutang Bank"],
            ["id" => "301", "account_group_id" => "30", "name" => "Modal Disetor"],
            ["id" => "302", "account_group_id" => "30", "name" => "Laba Ditahan"],
            ["id" => "401", "account_group_id" => "40", "name" => "Penjualan"],
            ["id" => "402", "account_group_id" => "40", "name" => "Pendapatan Jasa"],
            ["id" => "501", "account_group_id" => "50", "name" => "Harga Pokok Penjualan"],
            ["id" => "502", "account_group_id" => "50", "name" => "Beban Bahan Baku"],
            ["id" => "503", "account_group_id" => "50", "name" => "Beban Pengiriman"],
            ["id" => "601", "account_group_id" => "60", "name" => "Beban Gaji"],
            ["id" => "602", "account_group_id" => "60", "name" => "Beban Sewa"],
            ["id" => "603", "account_group_id" => "60", "name" => "Beban Pajak"],
            ["id" => "701", "account_group_id" => "70", "name" => "Pendapatan Bunga"],
            ["id" => "702", "account_group_id" => "70", "name" => "Pendapatan Dividen"],
            ["id" => "703", "account_group_id" => "70", "name" => "Pendapatan Potongan"],
            ["id" => "801", "account_group_id" => "80", "name" => "Beban Listrik"],
            ["id" => "802", "account_group_id" => "80", "name" => "Beban Telepon"],
            ["id" => "803", "account_group_id" => "80", "name" => "Beban Lain-lain"],
        ]);

        // Menambahkan Sub Accounts
        SubAccount::insert([
            ["id" => "1011", "main_account_id" => "101", "name" => "Kas di Bank"],
            ["id" => "1012", "main_account_id" => "101", "name" => "Kas di Tangan"],
            ["id" => "1021", "main_account_id" => "102", "name" => "Piutang Dagang Lokal"],
            ["id" => "1022", "main_account_id" => "102", "name" => "Piutang Dagang Ekspor"],
            ["id" => "1071", "main_account_id" => "102", "name" => "Persediaan Barang"],
            ["id" => "1031", "main_account_id" => "103", "name" => "Tanah Perusahaan"],
            ["id" => "1041", "main_account_id" => "104", "name" => "Bangunan Pabrik"],
            ["id" => "1051", "main_account_id" => "105", "name" => "Peralatan Produksi"],
            ["id" => "1061", "main_account_id" => "106", "name" => "Inventaris Kantor"],
            ["id" => "2011", "main_account_id" => "201", "name" => "Hutang Usaha Lokal"],
            ["id" => "2021", "main_account_id" => "202", "name" => "Hutang Bank Jangka Pendek"],
            ["id" => "3011", "main_account_id" => "301", "name" => "Modal Disetor Pemilik"],
            ["id" => "3021", "main_account_id" => "302", "name" => "Laba Ditahan Tahun Berjalan"],
            ["id" => "4011", "main_account_id" => "401", "name" => "Penjualan Produk A"],
            ["id" => "4021", "main_account_id" => "402", "name" => "Pendapatan Jasa Konsultasi"],
            ["id" => "5011", "main_account_id" => "501", "name" => "Beban Bahan Baku Utama"],
            ["id" => "5021", "main_account_id" => "502", "name" => "Beban Bahan Baku Sekunder"],
            ["id" => "5031", "main_account_id" => "503", "name" => "Beban Pengiriman"],
            ["id" => "6011", "main_account_id" => "601", "name" => "Beban Gaji Karyawan"],
            ["id" => "6021", "main_account_id" => "602", "name" => "Beban Sewa Gedung"],
            ["id" => "6031", "main_account_id" => "603", "name" => "Beban Pajak"],
            ["id" => "7011", "main_account_id" => "701", "name" => "Pendapatan Bunga Bank"],
            ["id" => "7021", "main_account_id" => "702", "name" => "Pendapatan Dividen Saham"],
            ["id" => "7031", "main_account_id" => "703", "name" => "Pendapatan Potongan"],
            ["id" => "8011", "main_account_id" => "801", "name" => "Beban Listrik Kantor"],
            ["id" => "8021", "main_account_id" => "802", "name" => "Beban Telepon Kantor"],
            ["id" => "8031", "main_account_id" => "803", "name" => "Beban Lain-lain"],
        ]);

        // Menambahkan Accounts
        Account::insert([
            // Aset
            ["id" => "10111", "sub_account_id" => "1011", "cash_flow_category_id" => 1, "name" => "Kas di Bank Mandiri", "initial_balance" => 0],
            ["id" => "10112", "sub_account_id" => "1012", "cash_flow_category_id" => 1, "name" => "Kas di Tangan", "initial_balance" => 0],
            ["id" => "10211", "sub_account_id" => "1021", "cash_flow_category_id" => 1, "name" => "Piutang Dagang Lokal", "initial_balance" => 0],
            ["id" => "10311", "sub_account_id" => "1031", "cash_flow_category_id" => 2, "name" => "Tanah Perusahaan", "initial_balance" => 0],
            ["id" => "10411", "sub_account_id" => "1041", "cash_flow_category_id" => 2, "name" => "Bangunan Pabrik", "initial_balance" => 0],
            ["id" => "10511", "sub_account_id" => "1051", "cash_flow_category_id" => 2, "name" => "Peralatan Produksi", "initial_balance" => 0],
            ["id" => "10611", "sub_account_id" => "1061", "cash_flow_category_id" => 2, "name" => "Inventaris Kantor", "initial_balance" => 0],
            ["id" => "10711", "sub_account_id" => "1071", "cash_flow_category_id" => 1, "name" => "Persediaan Barang Dagang", "initial_balance" => 0],

            // Kewajiban
            ["id" => "20111", "sub_account_id" => "2011", "cash_flow_category_id" => 1, "name" => "Hutang Usaha Lokal", "initial_balance" => 0],
            ["id" => "20211", "sub_account_id" => "2021", "cash_flow_category_id" => 1, "name" => "Hutang Bank Jangka Pendek", "initial_balance" => 0],

            // Modal
            ["id" => "30111", "sub_account_id" => "3011", "cash_flow_category_id" => null, "name" => "Modal Disetor Pemilik", "initial_balance" => 0],
            ["id" => "30211", "sub_account_id" => "3021", "cash_flow_category_id" => null, "name" => "Laba Ditahan Tahun Berjalan", "initial_balance" => 0],

            // Pendapatan
            ["id" => "40111", "sub_account_id" => "4011", "cash_flow_category_id" => 1, "name" => "Penjualan Produk A", "initial_balance" => 0],
            ["id" => "40211", "sub_account_id" => "4021", "cash_flow_category_id" => 1, "name" => "Pendapatan Jasa Konsultasi", "initial_balance" => 0],

            // Beban
            ["id" => "50111", "sub_account_id" => "5011", "cash_flow_category_id" => 1, "name" => "Beban Bahan Baku Utama", "initial_balance" => 0],
            ["id" => "50211", "sub_account_id" => "5021", "cash_flow_category_id" => 1, "name" => "Beban Bahan Baku Sekunder", "initial_balance" => 0],
            ["id" => "50311", "sub_account_id" => "5031", "cash_flow_category_id" => 1, "name" => "Beban Pengiriman", "initial_balance" => 0],
            ["id" => "60111", "sub_account_id" => "6011", "cash_flow_category_id" => 1, "name" => "Beban Gaji Karyawan", "initial_balance" => 0],
            ["id" => "60211", "sub_account_id" => "6021", "cash_flow_category_id" => 1, "name" => "Beban Sewa Gedung", "initial_balance" => 0],
            ["id" => "60311", "sub_account_id" => "6031", "cash_flow_category_id" => 1, "name" => "Beban Pajak Pembelian", "initial_balance" => 0],
            ["id" => "60312", "sub_account_id" => "6031", "cash_flow_category_id" => 1, "name" => "Beban Pajak Penjualan", "initial_balance" => 0],
            ["id" => "70111", "sub_account_id" => "7011", "cash_flow_category_id" => 1, "name" => "Pendapatan Bunga Bank", "initial_balance" => 0],
            ["id" => "70211", "sub_account_id" => "7021", "cash_flow_category_id" => 1, "name" => "Pendapatan Dividen Saham", "initial_balance" => 0],
            ["id" => "70311", "sub_account_id" => "7031", "cash_flow_category_id" => 1, "name" => "Pendapatan Potongan Pembelian", "initial_balance" => 0],
            ["id" => "80111", "sub_account_id" => "8011", "cash_flow_category_id" => 1, "name" => "Beban Listrik Kantor", "initial_balance" => 0],
            ["id" => "80211", "sub_account_id" => "8021", "cash_flow_category_id" => 1, "name" => "Beban Telepon Kantor", "initial_balance" => 0],
            ["id" => "80311", "sub_account_id" => "8031", "cash_flow_category_id" => 1, "name" => "Beban Potongan Penjualan", "initial_balance" => 0],
        ]);

        TaxRate::insert([
            ["name" => "PPN 10%", "rate" => 10.0],
            ["name" => "PPH 21", "rate" => 5.0],
            ["name" => "PPH 23", "rate" => 2.0],
            ["name" => "PPH Badan", "rate" => 25.0],
            ["name" => "Bebas Pajak", "rate" => 0.0],
        ]);

        $setup = [
            'app_name' => ucwords(str_replace('_', ' ', 'MIS')),
            'company_name' => ucwords(str_replace('_', ' ', 'PG Kebon Agung')),
            'company_logo' => 'setups/1718631326.png',
            'retained_earning_id' => "30211",
        ];
        Setup::insert($setup);

        Warehouse::insert([
            ["name" => "Gudang A"],
            ["name" => "Gudang B"],
            ["name" => "Gudang C"],
        ]);

        MaterialCategory::insert([
            ["name" => "Produk"],
            ["name" => "Bahan Baku"],
        ]);

        MaterialSubCategory::insert([
            ["material_category_id" => 1, "name" => "Gula"],
            ["material_category_id" => 1, "name" => "Tetes"],
            ["material_category_id" => 1, "name" => "Ampas"],
            ["material_category_id" => 1, "name" => "Blotong"],
            ["material_category_id" => 2, "name" => "Raw Sugar"],
            ["material_category_id" => 2, "name" => "Tebu"],
        ]);

        PaymentTerm::insert([
            ["day" => 0, "name" => "Tunai"],
            ["day" => 3, "name" => "3 Hari"],
            ["day" => 7, "name" => "7 Hari"],
            ["day" => 14, "name" => "14 Hari"],
        ]);

        Unit::insert([
            ["symbol" => "Kg", "name" => "Kilogram"],
            ["symbol" => "Ku", "name" => "Kuintal"],
            ["symbol" => "Ton", "name" => "Ton"],
            ["symbol" => "Box", "name" => "Box"],
            ["symbol" => "Pck", "name" => "Pack"],
            ["symbol" => "Pcs", "name" => "Pieces"],
            ["symbol" => "Sak", "name" => "Sak"],
        ]);

        $warehouses = Warehouse::all();
        foreach ($warehouses as $warehouse) {
            $column_name = str_replace(' ', '_', $warehouse->name);
            $queries = [
                "ALTER TABLE materials ADD COLUMN `{$column_name}` FLOAT NULL",
            ];

            foreach ($queries as $query) {
                DB::statement($query);
            }
        }

        Business::insert([
            ["name" => "Pabrik"],
            ["name" => "Toko"],
            ["name" => "Petani"],
            ["name" => "Koperasi Unit Daerah"],
            ["name" => "Importir"],
            ["name" => "Konsumen"],
        ]);

        Supplier::insert([
            ["name" => "Importir", "business_id" => Business::where("name", "Importir")->get()->last()->id, "phone_number" => "081234567890", "address" => "Pelabuhan Tanjung Perak"],
        ]);

        Customer::insert([
            ["name" => "Konsumen 1", "business_id" => Business::where("name", "Konsumen")->get()->last()->id, "phone_number" => "081234567890", "address" => "Pelabuhan Tanjung Perak"],
        ]);

        Material::insert([
            [
                "name" => "Raw Sugar Thailand",
                "material_sub_category_id" => MaterialSubCategory::where("name", "Raw Sugar")->get()->last()->id,
                "unit_id" => Unit::where("name", "Kuintal")->get()->last()->id,
                "buy_price" => 960000,
                "sell_price" => null,
            ],
            [
                "name" => "Raw Sugar India",
                "material_sub_category_id" => MaterialSubCategory::where("name", "Raw Sugar")->get()->last()->id,
                "unit_id" => Unit::where("name", "Kuintal")->get()->last()->id,
                "buy_price" => 930000,
                "sell_price" => null,
            ],
        ]);

        TransactionCategory::insert([
            [
                "id" => "PRC",
                "name" => "Pembelian",
                "deal_with" => "suppliers",
                "price_used" => "buy_price",
                "stock_normal_balance_id" => "D",
                "subtotal_account_id" => Account::where("name", "Persediaan Barang Dagang")->get()->last()->id,
                "subtotal_normal_balance_id" => "D",
                "taxes_account_id" => Account::where("name", "Beban Pajak Pembelian")->get()->last()->id,
                "taxes_normal_balance_id" => "D",
                "freight_account_id" => Account::where("name", "Beban Pengiriman")->get()->last()->id,
                "freight_normal_balance_id" => "D",
                "discount_account_id" => Account::where("name", "Pendapatan Potongan Pembelian")->get()->last()->id,
                "discount_normal_balance_id" => "C",
                "grand_total_account_id" => Account::where("name", "Hutang Usaha Lokal")->get()->last()->id,
                "grand_total_normal_balance_id" => "C",
            ],
            [
                "id" => "SLS",
                "name" => "Penjualan",
                "deal_with" => "customers",
                "price_used" => "sell_price",
                "stock_normal_balance_id" => "C",
                "subtotal_account_id" => Account::where("name", "Persediaan Barang Dagang")->get()->last()->id,
                "subtotal_normal_balance_id" => "C",
                "taxes_account_id" => Account::where("name", "Beban Pajak Penjualan")->get()->last()->id,
                "taxes_normal_balance_id" => "D",
                "freight_account_id" => Account::where("name", "Beban Pengiriman")->get()->last()->id,
                "freight_normal_balance_id" => "D",
                "discount_account_id" => Account::where("name", "Beban Potongan Penjualan")->get()->last()->id,
                "discount_normal_balance_id" => "D",
                "grand_total_account_id" => Account::where("name", "Piutang Dagang Lokal")->get()->last()->id,
                "grand_total_normal_balance_id" => "D",
            ],
        ]);

    }
}
