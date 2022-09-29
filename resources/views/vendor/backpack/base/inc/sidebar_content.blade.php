{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}</a></li>
<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i>
                <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i
                    class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i
                    class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('category') }}"><i class="nav-icon la la-question"></i>
        Categories</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('customer') }}"><i class="nav-icon la la-question"></i>
        Customers</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('export') }}"><i class="nav-icon la la-question"></i>
        Exports</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('import') }}"><i class="nav-icon la la-question"></i>
        Imports</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('item') }}"><i class="nav-icon la la-question"></i>
        Items</a></li>
{{-- @hasanyrole(Backpack\PermissionManager\app\Models\Role::all()) --}}
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('supplier') }}"><i class="nav-icon la la-question"></i>
            Suppliers</a></li>
{{-- @endhasanyrole --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-question"></i>
        Users</a></li>
