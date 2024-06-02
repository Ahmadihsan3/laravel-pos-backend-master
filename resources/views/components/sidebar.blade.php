<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard.index') }}">Inventory Management</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard.index') }}">IM</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Menu Inventory</li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Users</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('user.index') }}">All Users</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Products</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('product.index') }}">All Products</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Orders</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('order.index') }}">All Orders</a>
                    </li>
                    <li>
                        <a class="nav-link" href="order?selected=1">Success Purchase</a>
                    </li>
                    <li>
                        <a class="nav-link" href="order?selected=2">Cancel Purchase</a>
                    </li>
                    <li>
                        <a class="nav-link" href="order?selected=3">Delivered Purchase</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Purchase</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('purchase.index') }}">All Purchase</a>
                    </li>
                    <li>
                        <a class="nav-link" href="purchase?selected=1">Success Purchase</a>
                    </li>
                    <li>
                        <a class="nav-link" href="purchase?selected=2">Cancel Purchase</a>
                    </li>
                    <li>
                        <a class="nav-link" href="purchase?selected=3">Delivered Purchase</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Setting</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('unit.index') }}">Unit</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('category.index') }}">Category</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('customer.index') }}">Customer</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('supplier.index') }}">Supplier</a>
                    </li>
                </ul>
            </li>

    </aside>
</div>
