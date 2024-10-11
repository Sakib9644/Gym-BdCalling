<div id="layoutSidenav_nav">
    <style>
   
        #sidenavAccordion {
            background-color: #343a40; 
        }

        .aiz-side-nav-item {
            margin: 10px 0; 
        }

        .aiz-side-nav-link {
            color: white; 
            padding: 10px 15px; 
            display: flex; 
            align-items: center; 
            transition: background-color 0.3s; 
        }

        .aiz-side-nav-link:hover {
            background-color: #495057; 
            border-radius: 5px; 
        }

        .aiz-side-nav-icon {
            margin-right: 10px; 
        }

        .sb-sidenav-footer {
            background-color: #2c2f33; 
            color: white; 
        }
    </style>
    <nav class="sb-sidenav accordion" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            @if (auth()->check())
                <!-- Admin Dashboard -->
                @if (auth()->user()->hasRole('admin'))
                    <li class="aiz-side-nav-item">
                        <a href="/dashboard" class="aiz-side-nav-link">
                            <i class="fas fa-tachometer-alt aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Admin Dashboard</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-3">
                            @if (auth()->user()->hasPermissionTo('manage trainers', 'api') || auth()->user()->hasPermissionTo('manage trainers'))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.trainers.index') }}" class="aiz-side-nav-link">
                                        <i class="fas fa-users aiz-side-nav-icon"></i>
                                        <span class="aiz-side-nav-text">Manage Trainers</span>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->hasPermissionTo('schedule classes', 'api') || auth()->user()->hasPermissionTo('schedule classes'))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.classes.index') }}" class="aiz-side-nav-link">
                                        <i class="fas fa-calendar-alt aiz-side-nav-icon"></i>
                                        <span class="aiz-side-nav-text">Schedule Classes</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Trainer Dashboard -->
                @if (auth()->user()->hasRole('trainer'))
                    <li class="aiz-side-nav-item">
                        <a href="/dashboard" class="aiz-side-nav-link">
                            <i class="fas fa-chalkboard-teacher aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Trainer Dashboard</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-3">
                            @if (auth()->user()->hasPermissionTo('view schedules', 'api'))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('trainer.schedules.index') }}" class="aiz-side-nav-link">
                                        <i class="fas fa-eye aiz-side-nav-icon"></i>
                                        <span class="aiz-side-nav-text">View Schedules</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Trainee Dashboard -->
                @if (auth()->user()->hasRole('trainee'))
                    <li class="aiz-side-nav-item">
                        <a href="/dashboard" class="aiz-side-nav-link">
                            <i class="fas fa-user-graduate aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Trainee Dashboard</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-3">
                            @if (auth()->user()->hasPermissionTo('manage profile', 'api'))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('trainee.profile') }}" class="aiz-side-nav-link">
                                        <i class="fas fa-user aiz-side-nav-icon"></i>
                                        <span class="aiz-side-nav-text">Manage Profile</span>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->hasPermissionTo('book classes', 'api'))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('trainee.bookings.index') }}" class="aiz-side-nav-link">
                                        <i class="fas fa-book aiz-side-nav-icon"></i>
                                        <span class="aiz-side-nav-text">Book Classes</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endif
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ auth()->user()->name ?? 'Guest' }}
        </div>
    </nav>
</div>
