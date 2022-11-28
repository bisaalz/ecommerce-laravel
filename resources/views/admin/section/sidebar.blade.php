<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('home') }}" class="site_title">
                <i class="fa fa-dove"></i> <span>Admin CMS!</span>
            </a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ Auth::user()->name }}</h2>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li>
                        <a href="{{ route('banner.index') }}">
                            <i class="fas fa-image"></i> Banner management <i class="fas fa-chevron-right pull-right"></i>
                        </a></li>
                    <li><a href="{{ route('category.index') }}">
                            <i class="fas fa-sitemap"></i> Category management <i class="fas fa-chevron-right pull-right"></i>
                        </a></li>
                    <li><a href="{{ route('product.index') }}">
                            <i class="fas fa-shopping-bag"></i> Product management <i class="fas fa-chevron-right pull-right"></i>
                        </a></li>

                    <li><a href="">
                            <i class="fas fa-shopping-cart"></i> Order management <i class="fas fa-chevron-right pull-right"></i>
                        </a></li>

                    <li><a href="{{ route('user.index') }}">
                            <i class="fas fa-users"></i> User management <i class="fas fa-chevron-right pull-right"></i>
                        </a></li>
                    <li><a href="">
                            <i class="fas fa-comment"></i> Review management <i class="fas fa-chevron-right pull-right"></i>
                        </a></li>
                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">

        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
