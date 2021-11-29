<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
            </router-link>
        </li>

        @can('isAdmin')
        <li class="nav-item">
            <router-link to="/users" class="nav-link">
                <i class="fa fa-list nav-icon"></i>
                <p>Manage Users</p>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/services" class="nav-link">
                <i class="fa fa-list nav-icon"></i>
                <p>Manage Services</p>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/tasks" class="nav-link">
                <i class="fa fa-list nav-icon"></i>
                <p>Manage Tasks</p>
            </router-link>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-list nav-icon"></i>
                <p>
                    Manage Bookings
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="/bookings" class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Booking Authorization </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/bookings" class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Task Assignment</p>
                    </router-link>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <router-link to="/galleries" class="nav-link">
                <i class="fa fa-list nav-icon"></i>
                <p>Manage Gallery</p>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="faqs" class="nav-link">
                <i class="fa fa-list nav-icon"></i>
                <p>Manage FAQs</p>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/pages" class="nav-link">
                <i class="fa fa-list nav-icon"></i>
                <p>Manage CMS Pages</p>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/complaints" class="nav-link">
                <i class="fa fa-list nav-icon"></i>
                <p>Manage Complaints</p>
            </router-link>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>
                    Manage Reports
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="#" class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Bookings </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="#" class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Payments</p>
                    </router-link>
                </li>
            </ul>
        </li>

        @endcan


        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-clock blue"></i>
                <p>
                    My Account
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="/profile" class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Profile</p>
                    </router-link>
                </li>
            </ul>
        </li>

        {{-- @can('isAdmin')
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cog green"></i>
                <p>
                    Settings
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="#" class="nav-link">
                        <i class="nav-icon fas fa-cash-register green"></i>
                        <p>Configrations</p>
                    </router-link>
                </li>
            </ul>
        </li>
        @endcan --}}


        <li class="nav-item">
            <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-power-off red"></i>
                <p>
                    {{ __('Logout') }}
                </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>
