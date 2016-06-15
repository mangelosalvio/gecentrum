<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#spark-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                GC
            </a>
        </div>

        <div class="collapse navbar-collapse" id="spark-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">Home</a></li>
                @if ( Auth::user() )
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Master Files <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('/products') }}">Products</a>
                                <!-- <a href="{{ url('/categories') }}">Categories</a> -->
                                <!-- <a href="{{ url('/warehouses') }}">Warehouse</a> -->
                                <a href="{{ url('/suppliers') }}">Suppliers</a>
                                <a href="{{ url('/customers') }}">Customers</a>

                            </li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Transactions <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('/po') }}">Purchase Order</a>
                                <a href="{{ url('/rr') }}">Stock Arrival</a>
                                <a href="{{ url('/delivery_receipts') }}">Delivery Receipts</a>
                                <a href="{{ url('/sales_returns') }}">Sales Returns</a>
                                <!-- <a href="{{ url('/purchase_returns') }}">Purchase Returns</a> -->
                                <!-- <a href="#">Physical Count</a> -->
                                <!-- <a href="{{ url('/physical_counts') }}">Physical Count</a> -->
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Reports <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('reports/po-history') }}">Purchase Order History</a>
                                <a href="{{ url('reports/rr-history') }}">Stock Arrival History</a>
                                <a href="{{ url('reports/delivery-receipts-history') }}">Delivery Receipts History</a>
                                <!-- <a href="{{ url('reports/purchase-return-history') }}">Purchase Returns History</a>
                                <a href="{{ url('reports/warehouse-release-history') }}">Warehouse Releasing History</a>
                                <a href="{{ url('reports/inventory-balance-report') }}">Inventory Balance Report</a>
                                <a href="{{ url('reports/product-cost-report') }}">Product Cost Report</a> -->

                                <a href="{{ url('reports/stock-card-report') }}">Stock Card</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>