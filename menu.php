<!-- Static navbar -->
<div class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li <?php if($page == 'home'){ echo 'class="active"';  } ?>><a href="home.php">Home</a></li>

                <li <?php if($page == 'cf4'){ echo 'class="active"'; } ?> class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">CF4<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a class="dropdown-item" href="cf4_search.php">CF4 Module</a></li>
                        <li><a class="dropdown-item" href="cf4_view_list_record.php">List of CF4 Records</a></li>
                    </ul>
                </li>

                <li <?php if($page == 'reports'){ echo 'class="active"'; } ?>>
                    <a href="generate_cf4_report.php">Generate CF4 XML</a>
                </li>

                <li <?php if($page == 'account'){ echo 'class="active"'; } ?> class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Account<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a class="dropdown-item" href="hci_profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="logout.php" onclick="return confirm('Are you sure you want to logout?');">Logout</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li style="line-height: 20px;color:#555;padding: 15px 0px 15px 0px;">Log in as: <?php echo $pUserId; ?></li>
            </ul>
        </div><!--/.nav-collapse -->

    </div><!--/.container-fluid -->
</div>
