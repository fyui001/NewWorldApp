<div class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('top_page') }}" class="brand-link">
        <img src="/img/new_world_logo.png" alt="NewWorld Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">管理画面</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            @if(\Auth::guard('web')->user()->getAttribute('role') === \Domain\AdminUsers\AdminUserRole::ROLE_SYSTEM->getValue()->getRawValue())
                <ul class="nav nav-pills nav-sidebar flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ $activePage == 'AdminUser' ? 'active' : '' }}" href="{{ route('admin_users.index') }}">
                            <i class="oi oi-person"></i>
                            <p>管理ユーザー</p>
                        </a>
                    </li>
                </ul>
            @endif
            <ul class="nav nav-pills nav-sidebar flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ $activePage == 'Drug' ? 'active' : '' }}" href="{{ route('drugs.index') }}">
                        <i class="oi oi-eye"></i>
                        <p>薬物一覧</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-pills nav-sidebar flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ $activePage == 'MedicationHistory' ? 'active' : '' }}" href="{{ route('medication_histories.index') }}">
                        <i class="oi oi-graph"></i>
                        <p>服薬履歴</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
