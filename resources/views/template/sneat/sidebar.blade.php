<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                @if(isset($setup->company_logo) && $setup->company_logo)
                    <img src="{{ asset($setup->company_logo) }}" alt="Company Logo" style="height: 25px;">
                @endif
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ ucwords(str_replace('_', ' ', $setup->app_name)) }}</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    @php
        $permissions = collect($setup->permission)
            ->pluck('feature.route')
            ->toArray();
    @endphp

    <ul class="menu-inner py-1">

        <li class="menu-item @yield('dashboard-active')">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">{{ ucwords(str_replace('_', ' ', 'dashboard')) }}</div>
            </a>
        </li>

        @if (in_array('setup.index', $permissions))
            <li class="menu-item @yield('setup-active')">
                <a href="{{ route('setup.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div data-i18n="Analytics">{{ ucwords(str_replace('_', ' ', 'setup')) }}</div>
                </a>
            </li>
        @endif

        @if (in_array('role.index', $permissions) ||
                in_array('user.index', $permissions) ||
                in_array('activity_log', $permissions))
            <li
                class="menu-item
                @yield('role-active')
                @yield('user-active')
                @yield('activity_log-active')
            ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-door-open"></i>
                    <div data-i18n="Analytics">{{ ucwords(str_replace('_', ' ', 'access')) }}</div>
                </a>
                <ul class="menu-sub">
                    @if (in_array('role.index', $permissions))
                        <li class="menu-item @yield('role-active')">
                            <a href="{{ route('role.index') }}" class="menu-link">
                                <div data-i18n="Without menu">{{ ucwords(str_replace('_', ' ', 'role')) }}
                                </div>
                            </a>
                        </li>
                    @endif
                    @if (in_array('user.index', $permissions))
                        <li class="menu-item @yield('user-active')">
                            <a href="{{ route('user.index') }}" class="menu-link">
                                <div data-i18n="Without menu">{{ ucwords(str_replace('_', ' ', 'user')) }}
                                </div>
                            </a>
                        </li>
                    @endif
                    @if (in_array('activity_log', $permissions))
                        <li class="menu-item @yield('activity_log-active')">
                            <a href="{{ route('activity_log') }}" class="menu-link">
                                <div data-i18n="Without menu">{{ ucwords(str_replace('_', ' ', 'activity_log')) }}
                                </div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (
            in_array('cash_flow_category.index', $permissions) ||
            in_array('financial_statement.index', $permissions) ||
            in_array('normal_balance.index', $permissions) ||
            in_array('account_group.index', $permissions) ||
            in_array('main_account.index', $permissions) ||
            in_array('sub_account.index', $permissions) ||
            in_array('account.index', $permissions) ||
            in_array('tax_rate.index', $permissions) ||
            in_array('journal.index', $permissions) ||
            in_array('ledger.index', $permissions) ||
            in_array('balance_sheet.index', $permissions)
            )
            <li
                class="menu-item
                @yield('cash_flow_category-active')
                @yield('financial_statement-active')
                @yield('normal_balance-active')
                @yield('account_group-active')
                @yield('main_account-active')
                @yield('sub_account-active')
                @yield('account-active')
                @yield('tax_rate-active')
                @yield('journal-active')
                @yield('ledger-active')
                @yield('balance_sheet-active')
            ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-wallet-alt"></i>
                    <div data-i18n="Analytics">{{ ucwords(str_replace('_', ' ', 'finance')) }}</div>
                </a>
                <ul class="menu-sub">
                    @if (in_array('cash_flow_category.index', $permissions))
                    <li class="menu-item @yield('cash_flow_category-active')">
                        <a href="{{ route('cash_flow_category.index') }}" class="menu-link">
                            <div data-i18n="Without menu">{{ ucwords(str_replace('_', ' ', 'cash_flow_category')) }}
                            </div>
                        </a>
                    </li>
                    @endif
                    @if (in_array('financial_statement.index', $permissions))
                        <li class="menu-item @yield('financial_statement-active')">
                            <a href="{{ route('financial_statement.index') }}" class="menu-link">
                                <div data-i18n="Without menu">{{ ucwords(str_replace('_', ' ', 'financial_statement')) }}
                                </div>
                            </a>
                        </li>
                    @endif
                    @if (in_array('normal_balance.index', $permissions))
                        <li class="menu-item @yield('normal_balance-active')">
                            <a href="{{ route('normal_balance.index') }}" class="menu-link">
                                <div data-i18n="Without menu">{{ ucwords(str_replace('_', ' ', 'normal_balance')) }}
                                </div>
                            </a>
                        </li>
                    @endif
                    @if (in_array('account_group.index', $permissions))
                        <li class="menu-item @yield('account_group-active')">
                            <a href="{{ route('account_group.index') }}" class="menu-link">
                                <div data-i18n="Without menu">{{ ucwords(str_replace('_', ' ', 'account_group')) }}
                                </div>
                            </a>
                        </li>
                    @endif
                    @if (in_array('main_account.index', $permissions))
                        <li class="menu-item @yield('main_account-active')">
                            <a href="{{ route('main_account.index') }}" class="menu-link">
                                <div data-i18n="Without menu">{{ ucwords(str_replace('_', ' ', 'main_account')) }}
                                </div>
                            </a>
                        </li>
                    @endif
                    @if (in_array('sub_account.index', $permissions))
                        <li class="menu-item @yield('sub_account-active')">
                            <a href="{{ route('sub_account.index') }}" class="menu-link">
                                <div data-i18n="Without menu">{{ ucwords(str_replace('_', ' ', 'sub_account')) }}
                                </div>
                            </a>
                        </li>
                    @endif
                    @if (in_array('account.index', $permissions))
                        <li class="menu-item @yield('account-active')">
                            <a href="{{ route('account.index') }}" class="menu-link">
                                <div data-i18n="Without menu">{{ ucwords(str_replace('_', ' ', 'account')) }}
                                </div>
                            </a>
                        </li>
                    @endif
                    @if (in_array('tax_rate.index', $permissions))
                        <li class="menu-item @yield('tax_rate-active')">
                            <a href="{{ route('tax_rate.index') }}" class="menu-link">
                                <div data-i18n="Without menu">{{ ucwords(str_replace('_', ' ', 'tax_rate')) }}
                                </div>
                            </a>
                        </li>
                    @endif
                    @if (in_array('journal.index', $permissions))
                        <li class="menu-item @yield('journal-active')">
                            <a href="{{ route('journal.index') }}" class="menu-link">
                                <div data-i18n="Without menu">{{ ucwords(str_replace('_', ' ', 'journal')) }}
                                </div>
                            </a>
                        </li>
                    @endif
                    @if (in_array('ledger.index', $permissions))
                        <li class="menu-item @yield('ledger-active')">
                            <a href="{{ route('ledger.index') }}" class="menu-link">
                                <div data-i18n="Without menu">{{ ucwords(str_replace('_', ' ', 'ledger')) }}
                                </div>
                            </a>
                        </li>
                    @endif
                    @if (in_array('balance_sheet.index', $permissions))
                        <li class="menu-item @yield('balance_sheet-active')">
                            <a href="{{ route('balance_sheet.index') }}" class="menu-link">
                                <div data-i18n="Without menu">{{ ucwords(str_replace('_', ' ', 'balance_sheet')) }}
                                </div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

    </ul>

</aside>
<!-- / Menu -->
