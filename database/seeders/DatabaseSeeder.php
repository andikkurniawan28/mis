<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Bank;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\Level;
use App\Models\Major;
use App\Models\Setup;
use App\Models\Skill;
use App\Models\Title;
use App\Models\Campus;
use App\Models\Account;
use App\Models\Feature;
use App\Models\TaxRate;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Material;
use App\Models\Religion;
use App\Models\Supplier;
use App\Models\Education;
use App\Models\Warehouse;
use App\Models\Department;
use App\Models\Permission;
use App\Models\SubAccount;
use App\Models\MainAccount;
use App\Models\PaymentTerm;
use App\Models\AccountGroup;
use App\Models\MaritalStatus;
use App\Models\NormalBalance;
use App\Models\SubDepartment;
use App\Models\EmployeeStatus;
use Illuminate\Database\Seeder;
use App\Models\CashFlowCategory;
use App\Models\EmployeeIdentity;
use App\Models\MaterialCategory;
use App\Models\RepaymentCategory;
use App\Models\FinancialStatement;
use Illuminate\Support\Facades\DB;
use App\Models\MaterialSubCategory;
use App\Models\InvoiceCategory;

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
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_invoice_category')), 'route' => 'invoice_category.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_invoice_category')), 'route' => 'invoice_category.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_invoice_category')), 'route' => 'invoice_category.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_invoice_category')), 'route' => 'invoice_category.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_invoice_category')), 'route' => 'invoice_category.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_invoice_category')), 'route' => 'invoice_category.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_invoice_category')), 'route' => 'invoice_category.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_repayment_category')), 'route' => 'repayment_category.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_repayment_category')), 'route' => 'repayment_category.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_repayment_category')), 'route' => 'repayment_category.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_repayment_category')), 'route' => 'repayment_category.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_repayment_category')), 'route' => 'repayment_category.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_repayment_category')), 'route' => 'repayment_category.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_repayment_category')), 'route' => 'repayment_category.destroy'],
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
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_service')), 'route' => 'service.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_service')), 'route' => 'service.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_service')), 'route' => 'service.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_service')), 'route' => 'service.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_service')), 'route' => 'service.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_service')), 'route' => 'service.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_service')), 'route' => 'service.destroy'],
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
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_vendor')), 'route' => 'vendor.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_vendor')), 'route' => 'vendor.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_vendor')), 'route' => 'vendor.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_vendor')), 'route' => 'vendor.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_vendor')), 'route' => 'vendor.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_vendor')), 'route' => 'vendor.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_vendor')), 'route' => 'vendor.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_customer')), 'route' => 'customer.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_customer')), 'route' => 'customer.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_customer')), 'route' => 'customer.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_customer')), 'route' => 'customer.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_customer')), 'route' => 'customer.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_customer')), 'route' => 'customer.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_customer')), 'route' => 'customer.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_invoice')), 'route' => 'invoice.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_invoice')), 'route' => 'invoice.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_invoice')), 'route' => 'invoice.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_invoice')), 'route' => 'invoice.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_invoice')), 'route' => 'invoice.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_invoice')), 'route' => 'invoice.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_invoice')), 'route' => 'invoice.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_repayment')), 'route' => 'repayment.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_repayment')), 'route' => 'repayment.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_repayment')), 'route' => 'repayment.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_repayment')), 'route' => 'repayment.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_repayment')), 'route' => 'repayment.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_repayment')), 'route' => 'repayment.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_repayment')), 'route' => 'repayment.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_department')), 'route' => 'department.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_department')), 'route' => 'department.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_department')), 'route' => 'department.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_department')), 'route' => 'department.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_department')), 'route' => 'department.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_department')), 'route' => 'department.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_department')), 'route' => 'department.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_sub_department')), 'route' => 'sub_department.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_sub_department')), 'route' => 'sub_department.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_sub_department')), 'route' => 'sub_department.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_sub_department')), 'route' => 'sub_department.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_sub_department')), 'route' => 'sub_department.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_sub_department')), 'route' => 'sub_department.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_sub_department')), 'route' => 'sub_department.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_level')), 'route' => 'level.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_level')), 'route' => 'level.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_level')), 'route' => 'level.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_level')), 'route' => 'level.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_level')), 'route' => 'level.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_level')), 'route' => 'level.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_level')), 'route' => 'level.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_employee_status')), 'route' => 'employee_status.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_employee_status')), 'route' => 'employee_status.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_employee_status')), 'route' => 'employee_status.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_employee_status')), 'route' => 'employee_status.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_employee_status')), 'route' => 'employee_status.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_employee_status')), 'route' => 'employee_status.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_employee_status')), 'route' => 'employee_status.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_education')), 'route' => 'education.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_education')), 'route' => 'education.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_education')), 'route' => 'education.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_education')), 'route' => 'education.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_education')), 'route' => 'education.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_education')), 'route' => 'education.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_education')), 'route' => 'education.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_campus')), 'route' => 'campus.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_campus')), 'route' => 'campus.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_campus')), 'route' => 'campus.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_campus')), 'route' => 'campus.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_campus')), 'route' => 'campus.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_campus')), 'route' => 'campus.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_campus')), 'route' => 'campus.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_major')), 'route' => 'major.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_major')), 'route' => 'major.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_major')), 'route' => 'major.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_major')), 'route' => 'major.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_major')), 'route' => 'major.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_major')), 'route' => 'major.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_major')), 'route' => 'major.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_religion')), 'route' => 'religion.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_religion')), 'route' => 'religion.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_religion')), 'route' => 'religion.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_religion')), 'route' => 'religion.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_religion')), 'route' => 'religion.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_religion')), 'route' => 'religion.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_religion')), 'route' => 'religion.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_marital_status')), 'route' => 'marital_status.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_marital_status')), 'route' => 'marital_status.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_marital_status')), 'route' => 'marital_status.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_marital_status')), 'route' => 'marital_status.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_marital_status')), 'route' => 'marital_status.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_marital_status')), 'route' => 'marital_status.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_marital_status')), 'route' => 'marital_status.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_bank')), 'route' => 'bank.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_bank')), 'route' => 'bank.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_bank')), 'route' => 'bank.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_bank')), 'route' => 'bank.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_bank')), 'route' => 'bank.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_bank')), 'route' => 'bank.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_bank')), 'route' => 'bank.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_skill')), 'route' => 'skill.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_skill')), 'route' => 'skill.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_skill')), 'route' => 'skill.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_skill')), 'route' => 'skill.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_skill')), 'route' => 'skill.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_skill')), 'route' => 'skill.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_skill')), 'route' => 'skill.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_title')), 'route' => 'title.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_title')), 'route' => 'title.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_title')), 'route' => 'title.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_title')), 'route' => 'title.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_title')), 'route' => 'title.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_title')), 'route' => 'title.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_title')), 'route' => 'title.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_employee_identity')), 'route' => 'employee_identity.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_employee_identity')), 'route' => 'employee_identity.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_employee_identity')), 'route' => 'employee_identity.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_employee_identity')), 'route' => 'employee_identity.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_employee_identity')), 'route' => 'employee_identity.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_employee_identity')), 'route' => 'employee_identity.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_employee_identity')), 'route' => 'employee_identity.destroy'],
            ['name' => ucfirst(str_replace('_', ' ', 'list_of_employee')), 'route' => 'employee.index'],
            ['name' => ucfirst(str_replace('_', ' ', 'create_employee')), 'route' => 'employee.create'],
            ['name' => ucfirst(str_replace('_', ' ', 'save_employee')), 'route' => 'employee.store'],
            ['name' => ucfirst(str_replace('_', ' ', 'edit_employee')), 'route' => 'employee.edit'],
            ['name' => ucfirst(str_replace('_', ' ', 'show_employee')), 'route' => 'employee.show'],
            ['name' => ucfirst(str_replace('_', ' ', 'update_employee')), 'route' => 'employee.update'],
            ['name' => ucfirst(str_replace('_', ' ', 'delete_employee')), 'route' => 'employee.destroy'],
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
            ["id" => "504", "account_group_id" => "50", "name" => "Beban Jasa"],
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
            ["id" => "1071", "main_account_id" => "107", "name" => "Persediaan Barang"],
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
            ["id" => "5041", "main_account_id" => "504", "name" => "Beban Jasa"],
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
            ["id" => "10111", "sub_account_id" => "1011", "cash_flow_category_id" => 1, "name" => "Kas di Bank Mandiri", "initial_balance" => 0, "is_payment_gateway" => 1],
            ["id" => "10112", "sub_account_id" => "1012", "cash_flow_category_id" => 1, "name" => "Kas di Tangan", "initial_balance" => 0, "is_payment_gateway" => 1],
            ["id" => "10211", "sub_account_id" => "1021", "cash_flow_category_id" => 1, "name" => "Piutang Dagang Lokal", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "10311", "sub_account_id" => "1031", "cash_flow_category_id" => 2, "name" => "Tanah Perusahaan", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "10411", "sub_account_id" => "1041", "cash_flow_category_id" => 2, "name" => "Bangunan Pabrik", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "10511", "sub_account_id" => "1051", "cash_flow_category_id" => 2, "name" => "Peralatan Produksi", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "10611", "sub_account_id" => "1061", "cash_flow_category_id" => 2, "name" => "Inventaris Kantor", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "10711", "sub_account_id" => "1071", "cash_flow_category_id" => 1, "name" => "Persediaan Barang Dagang", "initial_balance" => 0, "is_payment_gateway" => 0],

            // Kewajiban
            ["id" => "20111", "sub_account_id" => "2011", "cash_flow_category_id" => 1, "name" => "Hutang Usaha Lokal", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "20211", "sub_account_id" => "2021", "cash_flow_category_id" => 1, "name" => "Hutang Bank Jangka Pendek", "initial_balance" => 0, "is_payment_gateway" => 0],

            // Modal
            ["id" => "30111", "sub_account_id" => "3011", "cash_flow_category_id" => null, "name" => "Modal Disetor Pemilik", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "30211", "sub_account_id" => "3021", "cash_flow_category_id" => null, "name" => "Laba Ditahan Tahun Berjalan", "initial_balance" => 0, "is_payment_gateway" => 0],

            // Pendapatan
            ["id" => "40111", "sub_account_id" => "4011", "cash_flow_category_id" => 1, "name" => "Penjualan Produk A", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "40211", "sub_account_id" => "4021", "cash_flow_category_id" => 1, "name" => "Pendapatan Jasa Konsultasi", "initial_balance" => 0, "is_payment_gateway" => 0],

            // Beban
            ["id" => "50111", "sub_account_id" => "5011", "cash_flow_category_id" => 1, "name" => "Beban Bahan Baku Utama", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "50211", "sub_account_id" => "5021", "cash_flow_category_id" => 1, "name" => "Beban Bahan Baku Sekunder", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "50311", "sub_account_id" => "5031", "cash_flow_category_id" => 1, "name" => "Beban Pengiriman", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "50411", "sub_account_id" => "5041", "cash_flow_category_id" => 1, "name" => "Beban Jasa", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "60111", "sub_account_id" => "6011", "cash_flow_category_id" => 1, "name" => "Beban Gaji Karyawan", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "60211", "sub_account_id" => "6021", "cash_flow_category_id" => 1, "name" => "Beban Sewa Gedung", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "60311", "sub_account_id" => "6031", "cash_flow_category_id" => 1, "name" => "Beban Pajak Pembelian", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "60312", "sub_account_id" => "6031", "cash_flow_category_id" => 1, "name" => "Beban Pajak Penjualan", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "70111", "sub_account_id" => "7011", "cash_flow_category_id" => 1, "name" => "Pendapatan Bunga Bank", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "70211", "sub_account_id" => "7021", "cash_flow_category_id" => 1, "name" => "Pendapatan Dividen Saham", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "70311", "sub_account_id" => "7031", "cash_flow_category_id" => 1, "name" => "Pendapatan Potongan Pembelian", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "80111", "sub_account_id" => "8011", "cash_flow_category_id" => 1, "name" => "Beban Listrik Kantor", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "80211", "sub_account_id" => "8021", "cash_flow_category_id" => 1, "name" => "Beban Telepon Kantor", "initial_balance" => 0, "is_payment_gateway" => 0],
            ["id" => "80311", "sub_account_id" => "8031", "cash_flow_category_id" => 1, "name" => "Beban Potongan Penjualan", "initial_balance" => 0, "is_payment_gateway" => 0],

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

        $importerBusinessId = Business::where('name', 'Importir')->first()->id;
        Supplier::insert([
            [
                'name' => 'PT Sumber Makmur',
                'business_id' => $importerBusinessId,
                'phone_number' => '081234567890',
                'address' => 'Jl. Pelabuhan Tanjung Perak No.12, Surabaya'
            ],
            [
                'name' => 'CV Aneka Kargo',
                'business_id' => $importerBusinessId,
                'phone_number' => '081234567891',
                'address' => 'Jl. Pelabuhan Tanjung Mas No.8, Semarang'
            ],
            [
                'name' => 'PT Bina Niaga Sejahtera',
                'business_id' => $importerBusinessId,
                'phone_number' => '081234567892',
                'address' => 'Jl. Raya Pelabuhan Bakauheni No.5, Lampung'
            ],
            [
                'name' => 'PT Mitra Samudera',
                'business_id' => $importerBusinessId,
                'phone_number' => '081234567893',
                'address' => 'Jl. Pelabuhan Benoa No.20, Bali'
            ],
            [
                'name' => 'CV Nusantara Kargo',
                'business_id' => $importerBusinessId,
                'phone_number' => '081234567894',
                'address' => 'Jl. Pelabuhan Belawan No.3, Medan'
            ],
        ]);

        Customer::insert([
            ["name" => "Customer A", "business_id" => Business::where("name", "Konsumen")->get()->last()->id, "phone_number" => "081234567890", "address" => "Pelabuhan Tanjung Perak"],
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

        InvoiceCategory::insert([
            [
                "id" => "PRCM",
                "name" => "Pembelian Material",
                "deal_with" => "suppliers",
                "item" => "materials",
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
                "id" => "SLSM",
                "name" => "Penjualan Material",
                "deal_with" => "customers",
                "item" => "materials",
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
            [
                "id" => "PRCS",
                "name" => "Pembelian Jasa",
                "deal_with" => "vendors",
                "item" => "services",
                "price_used" => "buy_price",
                "stock_normal_balance_id" => "D",
                "subtotal_account_id" => Account::where("name", "Beban Jasa")->get()->last()->id,
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
                "id" => "SLSS",
                "name" => "Penjualan Jasa",
                "deal_with" => "customers",
                "item" => "services",
                "price_used" => "sell_price",
                "stock_normal_balance_id" => "C",
                "subtotal_account_id" => Account::where("name", "Pendapatan Jasa Konsultasi")->get()->last()->id,
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

        RepaymentCategory::insert([
            [
                "id" => "PRP",
                "name" => "Pelunasan Hutang",
                "deal_with" => "suppliers",
                "grand_total_account_id" => Account::where("name", "Hutang Usaha Lokal")->get()->last()->id,
                "grand_total_normal_balance_id" => "D",
            ],
            [
                "id" => "RRP",
                "name" => "Pelunasan Piutang",
                "deal_with" => "customers",
                "grand_total_account_id" => Account::where("name", "Piutang Dagang Lokal")->get()->last()->id,
                "grand_total_normal_balance_id" => "C",
            ],
        ]);

        Department::insert([
            ["name" => "Direktur"],
            ["name" => "Keuangan"],
            ["name" => "Personalia"],
            ["name" => "Produksi"],
            ["name" => "Gudang"],
            ["name" => "Pembelian"],
            ["name" => "Penjualan"],
            ["name" => "Pemasaran"],
        ]);

        SubDepartment::insert([
            ["name" => "Direktur", "department_id" => Department::where("name", "Direktur")->get()->last()->id],
            ["name" => "Akunting", "department_id" => Department::where("name", "Keuangan")->get()->last()->id],
            ["name" => "Keuangan", "department_id" => Department::where("name", "Keuangan")->get()->last()->id],
            ["name" => "Personalia", "department_id" => Department::where("name", "Personalia")->get()->last()->id],
            ["name" => "Tata Usaha", "department_id" => Department::where("name", "Personalia")->get()->last()->id],
            ["name" => "Produksi", "department_id" => Department::where("name", "Produksi")->get()->last()->id],
            ["name" => "QC", "department_id" => Department::where("name", "Produksi")->get()->last()->id],
            ["name" => "Gudang Produk", "department_id" => Department::where("name", "Gudang")->get()->last()->id],
            ["name" => "Gudang Bahan Baku", "department_id" => Department::where("name", "Gudang")->get()->last()->id],
            ["name" => "Gudang Peralatan & Perlengkapan", "department_id" => Department::where("name", "Gudang")->get()->last()->id],
            ["name" => "Pengadaan Barang", "department_id" => Department::where("name", "Pembelian")->get()->last()->id],
            ["name" => "Pengadaan Jasa", "department_id" => Department::where("name", "Pembelian")->get()->last()->id],
            ["name" => "Penjualan", "department_id" => Department::where("name", "Penjualan")->get()->last()->id],
            ["name" => "Pemasaran", "department_id" => Department::where("name", "Pemasaran")->get()->last()->id],
        ]);

        Level::insert([
            ["name" => "Direktur"],
            ["name" => "Kepala Bagian"],
            ["name" => "Kepala Seksie"],
            ["name" => "Kepala Sub-Seksie"],
            ["name" => "Supervisor"],
            ["name" => "Kepala Regu"],
            ["name" => "Pelaksana"],
        ]);

        Education::insert([
            ["name" => "Tidak Bersekolah Formal"],
            ["name" => "Setara SD"],
            ["name" => "Setara SMP"],
            ["name" => "Setara SMA"],
            ["name" => "Setara D1"],
            ["name" => "Setara D2"],
            ["name" => "Setara D3"],
            ["name" => "Setara S1"],
            ["name" => "Setara S2"],
            ["name" => "Setara S3"],
        ]);

        Major::insert([
            ["name" => "Ekonomi"],
            ["name" => "Akuntansi"],
            ["name" => "Statistika"],
            ["name" => "Psikologi"],
            ["name" => "Teknik Kimia"],
            ["name" => "Teknik Mesin"],
            ["name" => "Teknik Instrumen"],
            ["name" => "Teknik Elektronika"],
            ["name" => "Teknik Informatika"],
            ["name" => "Pertanian"],
            ["name" => "Ilmu Pangan"],
            ["name" => "Kimia Murni"],
            ["name" => "Fisika Murni"],
            ["name" => "Matematika Murni"],
            ["name" => "Sastra Bahasa Inggris"],
            ["name" => "Sastra Bahasa Indonesia"],
            ["name" => "Sastra Bahasa Mandarin"],
        ]);

        Religion::insert([
            ["name" => "Islam"],
            ["name" => "Kristen Protestan"],
            ["name" => "Kristen Katholik"],
            ["name" => "Hindu"],
            ["name" => "Buddha"],
            ["name" => "Konghucu"],
            ["name" => "Keperacayaan Lokal"],
            ["name" => "Atheis"],
        ]);

        MaritalStatus::insert([
            ["name" => "Lajang"],
            ["name" => "Menikah"],
            ["name" => "Cerai"],
        ]);

        Bank::insert([
            ["name" => "Bank Aceh Syariah"],
            ["name" => "Bank Aladin Syariah"],
            ["name" => "Bank Amar Indonesia"],
            ["name" => "Bank ANZ Indonesia"],
            ["name" => "Bank Artha Graha Internasional"],
            ["name" => "Bank Banten"],
            ["name" => "Bank BCA Syariah"],
            ["name" => "Bank Bengkulu"],
            ["name" => "Bank BJB"],
            ["name" => "Bank BJB Syariah"],
            ["name" => "Bank BNP Paribas Indonesia"],
            ["name" => "Bank BPD Bali"],
            ["name" => "Bank BPD DIY"],
            ["name" => "Bank BRK Syariah"],
            ["name" => "Bank BSG"],
            ["name" => "Bank BTPN"],
            ["name" => "Bank Bumi Arta"],
            ["name" => "Bank Capital Indonesia"],
            ["name" => "Bank Central Asia"],
            ["name" => "Bank China Construction Bank Indonesia"],
            ["name" => "Bank CIMB Niaga"],
            ["name" => "Bank Commonwealth"],
            ["name" => "Bank CTBC Indonesia"],
            ["name" => "Bank Danamon Indonesia"],
            ["name" => "Bank DBS Indonesia"],
            ["name" => "Bank Digital BCA"],
            ["name" => "Bank DKI"],
            ["name" => "Bank Ganesha"],
            ["name" => "Bank Hana Indonesia"],
            ["name" => "Bank Hibank Indonesia"],
            ["name" => "Bank HSBC Indonesia"],
            ["name" => "Bank IBK Indonesia"],
            ["name" => "Bank ICBC Indonesia"],
            ["name" => "Bank Ina Perdana"],
            ["name" => "Bank Index Selindo"],
            ["name" => "Bank Jago"],
            ["name" => "Bank Jambi"],
            ["name" => "Bank Jasa Jakarta"],
            ["name" => "Bank Jateng"],
            ["name" => "Bank Jatim"],
            ["name" => "Bank J Trust Indonesia"],
            ["name" => "Bank Kalbar"],
            ["name" => "Bank Kalsel"],
            ["name" => "Bank Kalteng"],
            ["name" => "Bank KB Indonesia"],
            ["name" => "Bank KB Syariah"],
            ["name" => "Bank Lampung"],
            ["name" => "Bank Maluku Malut"],
            ["name" => "Bank Mandiri"],
            ["name" => "Bank Mandiri Taspen"],
            ["name" => "Bank Maspion"],
            ["name" => "Bank Mayapada Internasional"],
            ["name" => "Bank Maybank Indonesia"],
            ["name" => "Bank Mega"],
            ["name" => "Bank Mega Syariah"],
            ["name" => "Bank Mestika Dharma"],
            ["name" => "Bank Mizuho Indonesia"],
            ["name" => "Bank MNC Internasional"],
            ["name" => "Bank Muamalat Indonesia"],
            ["name" => "Bank Multiarta Sentosa"],
            ["name" => "Bank Nagari"],
            ["name" => "Bank Nano Syariah"],
            ["name" => "Bank Nationalnobu"],
            ["name" => "Bank Negara Indonesia"],
            ["name" => "Bank Neo Commerce"],
            ["name" => "Bank NTT"],
            ["name" => "Bank OCBC Indonesia"],
            ["name" => "Bank Oke Indonesia"],
            ["name" => "Bank Papua"],
            ["name" => "Bank Permata"],
            ["name" => "Bank QNB Indonesia"],
            ["name" => "Bank Rakyat Indonesia"],
            ["name" => "Bank Raya Indonesia"],
            ["name" => "Bank Resona Perdania"],
            ["name" => "Bank Sahabat Sampoerna"],
            ["name" => "Bank SBI Indonesia"],
            ["name" => "Bank Shinhan Indonesia"],
            ["name" => "Bank Sinarmas"],
            ["name" => "Bank Sulselbar"],
            ["name" => "Bank Sulteng"],
            ["name" => "Bank Sultra"],
            ["name" => "Bank Sumsel Babel"],
            ["name" => "Bank Sumut"],
            ["name" => "Bank Superbank Indonesia"],
            ["name" => "Bank Syariah Indonesia"],
            ["name" => "Bank Tabungan Negara"],
            ["name" => "Bank UOB Indonesia"],
            ["name" => "Bank Victoria Syariah"],
            ["name" => "Bank Woori Saudara"],
        ]);

        Skill::insert([
            ["name" => "Public Speaking"],
            ["name" => "Bahasa Inggris"],
            ["name" => "Bahasa Mandarin"],
            ["name" => "Akuntansi"],
            ["name" => "Statistik"],
            ["name" => "Pemrograman Desktop"],
            ["name" => "Pemrograman Web"],
            ["name" => "Pemrograman Mobile"],
            ["name" => "Robotika"],
            ["name" => "Instalasi Jaringan Fiber Optic"],
            ["name" => "Instalasi Jaringan Ethernet"],
            ["name" => "Teknisi Hardware"],
            ["name" => "Panel Wiring"],
            ["name" => "Pemrograman PLC"],
            ["name" => "Pemrograman HMI"],
            ["name" => "Instalasi Listrik Arus Kuat"],
            ["name" => "Pengelasan"],
            ["name" => "Mekanik Mesin"],
            ["name" => "Pengoperasian Alat Berat"],
            ["name" => "Konstruksi Bangunan"],
            ["name" => "Arsitek Bangunan"],
            ["name" => "Analisa Laboratorium"],
        ]);

        Campus::insert([
            ["name" => "Institut Teknik Sepuluh November"],
            ["name" => "Universitas Brawijaya"],
            ["name" => "Politeknik LPP Agro"],
            ["name" => "Universitas Negeri Malang"],
            ["name" => "Politeknik Negeri Malang"],
            ["name" => "Institut Nasional Malang"],
            ["name" => "SMK Negeri 7 Malang"],
            ["name" => "Lainnya"],
        ]);

        Title::insert([
            [
                'name' => 'Direktur Utama',
                'sub_department_id' => SubDepartment::where('name', 'Direktur')->first()->id,
                'level_id' => Level::where('name', 'Direktur')->first()->id,
            ],
            [
                'name' => 'Kepala Bagian Akuntansi',
                'sub_department_id' => SubDepartment::where('name', 'Akunting')->first()->id,
                'level_id' => Level::where('name', 'Kepala Bagian')->first()->id,
            ],
            [
                'name' => 'Supervisor Produksi',
                'sub_department_id' => SubDepartment::where('name', 'Produksi')->first()->id,
                'level_id' => Level::where('name', 'Supervisor')->first()->id,
            ],
            [
                'name' => 'Kepala Gudang Produk',
                'sub_department_id' => SubDepartment::where('name', 'Gudang Produk')->first()->id,
                'level_id' => Level::where('name', 'Kepala Bagian')->first()->id,
            ],
            [
                'name' => 'Pelaksana QC',
                'sub_department_id' => SubDepartment::where('name', 'QC')->first()->id,
                'level_id' => Level::where('name', 'Pelaksana')->first()->id,
            ],
        ]);

        EmployeeStatus::insert([
            ["name" => "Karyawan Tetap"],
            ["name" => "Karyawan Kampanye"],
            ["name" => "Karyawan PKWT"],
            ["name" => "Karyawan Outsourcing"],
        ]);

        EmployeeIdentity::insert([
            ["name" => "Nomor Telepon"],
            ["name" => "Nomor Induk Kependudukan"],
            ["name" => "Nomor KK"],
            ["name" => "NPWP"],
            ["name" => "Nomor BPJS Kesehatan"],
            ["name" => "Nomor BPJS Ketenagakerjaan"],
        ]);

        $employee_identities = EmployeeIdentity::all();
        foreach ($employee_identities as $employee_identity) {
            $column_name = str_replace(' ', '_', $employee_identity->name);
            $queries = [
                "ALTER TABLE employees ADD COLUMN `{$column_name}` VARCHAR(255) NULL",
            ];

            foreach ($queries as $query) {
                DB::statement($query);
            }
        }

    }
}
