@auth
<style>
    .dropdown-menu-custom li {
        border-bottom: 1px solid #f25d52;
        /* Subtle border between items */
    }

    .dropdown-menu-custom li:last-child {
        border-bottom: none;
        /* Remove border for the last item */
    }

    .dropdown-menu-custom a {
        display: block;
        padding: 10px 15px;
        color: white;
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
        /* Smooth transitions */
    }

    .dropdown-menu-custom a.active,
    .dropdown-menu-custom a:hover {
        background-color: #f25d52;
        /* Darker background on hover or active */
        color: #f25d52;
        /* Lighter text color on hover or active */
    }


    .dropdown-toggle {
        display: flex;
        align-items: center;
        cursor: pointer;
    }
</style>

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <!-- Sidebar Brand -->
        <div class="sidebar-brand">
            <a href="/home">CSWDO - RMS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/home">
                <img src="{{ asset('img/cswdopnglogo.png') }}" class="logo h-10 w-10" alt="Logo">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('home') }}" style="color: white;"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            @if (Auth::user()->role == 'social-worker')
            <li class="menu-header">Case Listing</li>
            <li class="menu-header">
                <a href="#" class="dropdown-toggle" onclick="toggleDropdown('caseListingDropdown'); return false;" style="color: white;">
                    <i class="fas fa-user-shield"></i> <span>Case Listing</span>
                </a>
                <ul id="caseListingDropdown" class="dropdown-menu-custom">
                    <li><a class="{{ Request::is('social-worker') ? 'active' : '' }}" href="{{ url('social-worker') }}" style="color: white;"><i class="fas fa-list"></i> Case Listing</a></li>
                    <li><a class="{{ Request::is('view-closed-clients') ? 'active' : '' }}" href="{{ url('view-closed-clients') }}" style="color: white;"><i class="fas fa-user-times"></i> Closed Clients</a></li>
                    <li><a class="{{ Request::is('view-ongoing-clients') ? 'active' : '' }}" href="{{ url('view-ongoing-clients') }}" style="color: white;"><i class="fas fa-user-clock"></i> On Going Clients</a></li>
                </ul>
            </li>
            @endif
            @if (Auth::user()->role == 'admin')
            <li class="menu-header">Social Workers</li>
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.index') }}" style="color: white;">
                    <i class="fas fa-user-shield"></i> <span>Social Workers</span>
                </a>
            </li>
            @endif

            <!-- profile ganti password -->
            <li class="menu-header">Profile</li>
            <li class="{{ Request::is('profile/edit') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('profile/edit') }}" style="color: white;"><i class="far fa-user"></i> <span>Profile</span></a>
            </li>
            <li class="{{ Request::is('profile/change-password') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('profile/change-password') }}" style="color: white;"><i class="fas fa-key"></i> <span>Change Password</span></a>
            </li>
            <li class="menu-header">Starter</li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}" style="color: white;"><i class="far fa-square"></i> <span>Blank Page</span></a>
            </li>
        </ul>
    </aside>
</div>
@endauth

<script>
    function toggleDropdown(id) {
        var dropdown = document.getElementById(id);
        if (dropdown.style.display === "block") {
            dropdown.style.display = "none";
        } else {
            dropdown.style.display = "block";
        }
    }
</script>