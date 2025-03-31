<!--sidebar Begins-->
<aside class="admin-sidebar">
    <div class="admin-sidebar-brand" style="color: white;background: #a70014;">
        <!-- begin sidebar branding-->
        {{-- <img class="admin-brand-logo" src="{{ asset('public/assets/img/logo1.png') }}" width="150"
            alt="dataxdata Logo"> --}}
        <h6>JAY JINENDRA JEWELLERS </h6>
        <!-- <span class="admin-brand-content"><a href="index.html"> dataxdata</a></span> -->
        <!-- end sidebar branding-->
        {{-- <div class="ml-auto">
            <!-- sidebar pin-->
            <a href="#" class="admin-pin-sidebar btn-ghost btn btn-rounded-circle"></a>
            <!-- sidebar close for mobile device-->
            <a href="#" class="admin-close-sidebar"></a>
        </div> --}}
    </div>
    <div class="admin-sidebar-wrapper js-scrollbar">
        <!-- Menu List Begins-->
        <ul class="menu">
            <!--list item begins-->
            <li class="menu-item @if(Route::is('dashboard')) active @endif">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <span class="menu-label">
                        <span class="menu-name">Dashboard</span>
                    </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder mdi mdi-view-dashboard"></i>
                    </span>
                </a>
            </li>
            <!--list item ends-->

            <!--list item begins-->
            <li class="menu-item @if(Route::is('parties.*')) active @endif ">
                <a href="{{ route('parties.index') }}" class="menu-link">
                    <span class="menu-label">
                        <span class="menu-name">User List</span>
                    </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder mdi mdi-account"></i>
                    </span>
                </a>
            </li>
            <!--list item ends-->

            <!--list item begins-->
            <li class="menu-item @if(Route::is('guarantors.*')) active @endif">
                <a href="{{ route('guarantors.index') }}" class="menu-link">
                    <span class="menu-label">
                        <span class="menu-name">Guarantors List</span>
                    </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder mdi mdi-account-check"></i>
                    </span>
                </a>
            </li>
            <!--list item ends-->
            <!--list item begins-->
            <li class="menu-item @if(Route::is('invoices.*')) active @endif">
                <a href="" class="open-dropdown menu-link">
                    <span class="menu-label">
                        <span class="menu-name">Bills
                            <span class="menu-arrow"></span>
                        </span>
                    </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder mdi mdi-database"></i>
                    </span>
                </a>
                <!--submenu-->
                <ul class="sub-menu">
                    <li class="menu-item @if(Route::is('invoices.create')) active @endif">
                        <a href="{{ route('invoices.create') }}" class="menu-link">
                            <span class="menu-label">
                                <span class="menu-name">Add Data</span>
                            </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-plus-box-outline"></i>
                            </span>
                        </a>
                    </li>
                    <li
                        class="menu-item @if(Route::is('invoices.index') || Route::is('invoices.show') || Route::is('invoices.edit')) active @endif">
                        <a href="{{ route('invoices.index') }}" class="menu-link">
                            <span class="menu-label">
                                <span class="menu-name">View Data</span>
                            </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-eye-outline"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--list item ends-->
            <!--list item begins-->
            <li class="menu-item @if(Route::is('cash-recept.*')) active @endif">
                <a href="{{ route('cash-recept.index') }}" class="open-dropdown menu-link">
                    <span class="menu-label">
                        <span class="menu-name">Cash Recipt</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder mdi mdi-cart"></i>
                    </span>
                </a>
                <!--submenu-->
                <ul class="sub-menu">
                    <li class="menu-item @if(Route::is('cash-recept.create')) active @endif">
                        <a href="{{ route('cash-recept.create') }}" class="menu-link">
                            <span class="menu-label">
                                <span class="menu-name">Add Data</span>
                            </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-plus-box-outline"></i>
                            </span>
                        </a>
                    </li>
                    <li class="menu-item @if(Route::is('cash-recept.index')) active @endif">
                        <a href="{{ route('cash-recept.index') }}" class="menu-link">
                            <span class="menu-label">
                                <span class="menu-name">View Data</span>
                            </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-eye-outline"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--list item ends-->
            <!--list item begins-->
            <li class="menu-item @if(Route::is('gst-bill.*')) active @endif">
                <a href="" class="open-dropdown menu-link">
                    <span class="menu-label">
                        <span class="menu-name">Gst Bills
                            <span class="menu-arrow"></span>
                        </span>
                    </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder mdi mdi-database"></i>
                    </span>
                </a>
                <!--submenu-->
                <ul class="sub-menu">
                    <li class="menu-item @if(Route::is('gst-bill.create')) active @endif">
                        <a href="{{ route('gst-bill.create') }}" class="menu-link">
                            <span class="menu-label">
                                <span class="menu-name">Add Data</span>
                            </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-plus-box-outline"></i>
                            </span>
                        </a>
                    </li>
                    <li
                        class="menu-item @if(Route::is('gst-bill.index') || Route::is('gst-bill.show') || Route::is('gst-bill.edit')) active @endif">
                        <a href="{{ route('gst-bill.index') }}" class="menu-link">
                            <span class="menu-label">
                                <span class="menu-name">View Data</span>
                            </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-eye-outline"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--list item ends-->
            <!--list item begins-->
            {{-- <li class="menu-item @if(Route::is('online-payment.*')) active @endif">
                <a href="{{ route('online-payment.index') }}" class="menu-link">
                    <span class="menu-label">
                        <span class="menu-name">Online Transection</span>
                    </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder mdi mdi-playlist-check"></i>
                    </span>
                </a>
            </li> --}}
            <!--list item ends-->
        </ul>
        <!-- Menu List Ends-->
    </div>
</aside>
<!--sidebar Ends-->