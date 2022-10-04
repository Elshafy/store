{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}</a></li>
<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i>
        {{ trans('side.auth') }}</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i>
                <span>{{ trans('side.user') }}</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i
                    class="nav-icon la la-id-badge"></i> <span>{{ trans('side.role') }}</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i
                    class="nav-icon la la-key"></i> <span>{{ trans('side.perm') }}</span></a></li>
    </ul>
</li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('category') }}">
        <i class="nav-icon la la-folder"></i>
        {{ trans('side.category') }}</a></li>
@can('edit-customer')
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('customer') }}">
            <i class="nav-icon la la-level-up"></i>
            {{ trans('side.customer') }}</a>
    </li>
@endcan
@can('edit-export')
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('export') }}"><i class="nav-icon la la-question"></i>
            {{ trans('side.export') }}</a>
    </li>
@endcan
@can('edit-import')
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('import') }}"><i class="nav-icon la la-question"></i>
            {{ trans('side.import') }}</a></li>
@endcan



@canany(['changeStateItem', 'edit-item'])
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('item') }}"><i class="nav-icon la la-leaf"></i>
            {{ trans('side.item') }}</a></li>
@endcanany
@can('edit-supplier')
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('supplier') }}">
            <i class="nav-icon la la-question"></i>
            {{ trans('side.supplier') }}</a>
    </li>
@endcan
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i
            class="nav-icon la la-cart-arrow-down"></i>
        {{ trans('side.user') }}</a></li>
