<header class="header section">
    <!-- Header  Start -->
    <?php
    include("TEMPLATE/login.php");

    ?>
    <div class="header-bottom color-scheme-dark d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <!-- Header Logo Start -->
                    <div class="header-logo"><a href="HOME.php"><img src="../IMAGES/IMG_WEB/rosie-logo.png"
                                                               height="90vh"      alt="rosie"></a></div>
                    <!-- Header Logo End -->
                </div>
                <div class="col-lg-6">
                    <!-- ayira Menu Start -->
                    <div class="ayira-menu">
                        <nav>
                            <ul>
                                <li><a href="HOME.php">Home</a>
                                </li>
                                <li class=""><a href="NEW.php">NEW</a>
                                </li>
                                <li class="menu-item-has-children"><a href="">BRAND</a>
                                    <div class="sub-menu">
                                        <ul class="d-block">
                                            <?php
                                            $query="select * from BRAND";
                                            $stmt=$dao->DML($query);
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                            $IDBR=$row['IDBR'];
                                            $NAMEBR=$row['NAMEBR'];
                                            ?>
                                            <li><a href="SHOWPRO.php?IDBR=<?=$IDBR?>"><?=$NAMEBR?></a></li>
                                            <?php
                                            endwhile;
                                            ?>
                                        </ul>
                                    </div>
                                </li>
                                <li class="position-static"> <a href="#" class="page-item-has-children">PRODUCT</a>
                                    <div class="mega-menu">
                                        <div class="container">
                                            <ul>
                                                <li class="menu-item-has-children">
                                                    <h3>MAKE UP</h3>
                                                    <ul class="sub-sub-menu">
                                                        <?php
                                                        $query="select * from CATEGORY where (IDCTGR='CT1' or IDCTGR='CT2' or IDCTGR='CT3')";
                                                        $stmt=$dao->DML($query);
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                                            $IDCTGR=$row['IDCTGR'];
                                                            $NAMECTGR=$row['NAMECTGR'];
                                                            ?>
                                                            <li><a href="SHOWPRO.php?IDCTGR=<?=$IDCTGR?>"><?=$NAMECTGR?></a></li>
                                                        <?php
                                                        endwhile;
                                                        ?>
                                                    </ul>
                                                </li>
                                                <li class="menu-item-has-children">
                                                    <h3>SKIN CARE</h3>
                                                    <ul class="sub-sub-menu">
                                                        <?php
                                                        $query="select * from CATEGORY where (IDCTGR='CT4' or IDCTGR='CT5' or IDCTGR='CT6'or IDCTGR='CT7'or IDCTGR='CT8')";
                                                        $stmt=$dao->DML($query);
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                                            $IDCTGR=$row['IDCTGR'];
                                                            $NAMECTGR=$row['NAMECTGR'];
                                                            ?>
                                                            <li><a href="SHOWPRO.php?IDCTGR=<?=$IDCTGR?>"><?=$NAMECTGR?></a></li>
                                                        <?php
                                                        endwhile;
                                                        ?>
                                                    </ul>
                                                </li>
                                                <li class="menu-item-has-children">
                                                    <a href="SHOWPRO.php?IDCTGR=CT9"><h3>ACCESSORIES</h3></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class=""><a href="SPECIALPRICE.php">SPECIALPRICE</a>
                                </li>
                                <li><a href="CONTACT.php">CONTACT</a></li>
                            </ul>
                        </nav>
                    </div>
                    <!--  Menu End -->
                </div>
                <div class="col-lg-3">
                    <!-- Header Action Start -->
                    <div class="header-action">
                        <a href="javascript:void(0"class="action header-action-btn header-action-btn-search"><i class="flaticon-search"></i></a>
                        <?php
                        if (isset($_SESSION['USERNAME'])) {
                            if (($_SESSION['USERNAME'] == 'admin') ) {
                                echo '<a href="./ADMIN.php" class="action " ><i
                                            class="flaticon-account"></i></a>';
                                echo '<a href="logout.php" class="action "><i
                                            class="flaticon-logout "></i></a>' ;
                            }
                            if (($_SESSION['USERNAME'] != 'admin')) {
                                echo '<a href="./USER.php" class="action"><i
                                            class="flaticon-user"></i></a>' ;
                                echo '<a href="logout.php" class="action"><i
                                            class="flaticon-logout"></i></a>' ;
                            }
                        } else {

                            echo ' <a href = "#" class="action" data-bs-toggle = "modal" data-bs-target = "#login" ><i class="flaticon-user" ></i ></a >';

                        }
                        ?>
                        <a class="action cart d-flex header-action-btn header-action-btn-cart" href="VIEWCART.php"><i class="flaticon-shopping-bag"></i> <span class="num"><?=$total?></span></a>

                    </div>
                    <!-- Header Action End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Header Bottom End -->
</header>
<!-- Header End -->

<!-- Header Mobile Start -->
<div class="header-mobile d-lg-none">
    <div class="container">
        <div class="row row-cols-2 align-items-center">
            <div class="col-4">
                <!-- Header Logo Start -->
                <div class="header-logo"> <a href="HOME.php"><img src="../IMAGES/IMG_WEB/rosie-logo.png"
                                                        height="90vh" alt="ROSIE STORE"></a> </div>
                <!-- Header Logo End -->
            </div>
            <div class="col-8">
                <!-- Header Action Start -->

                <div class="header-action"><a href="VIEWCART.php" class="action cart header-action-btn header-action-btn-cart"> <i class="flaticon-shopping-bag"></i><span class="num"><?=$total?></span> </a> <a href="javascript:;" class="action mobile-menu-open"><i class="flaticon-menu"></i></a> </div>

                <!-- Header Action End -->
            </div>
        </div>
    </div>
</div>
<!-- Header Mobile End -->

<!-- offcanvas Menu Start -->
<div class="offcanvas-menu d-lg-none color-scheme-light">
    <div class="offcanvas-menu-wrapper">
        <div class="header-top-search">
            <form method="get" action="SHOWPRO.php">
                <input type="text" name="search"placeholder="Search Hear...">
                <button type="submit" value="search" ><i class="flaticon-search"></i></button>
            </form>
        </div>
        <!-- Header Top search End -->
        <!--  Menu Start -->
        <div class="mobile-ayira-menu">
            <nav>
                <ul>
                    <li class=""><a href="HOME.php">Home</a>
                    </li>
                    <li class=""><a href="NEW.php">NEW</a>
                    </li>
                    <li><a href="SHOWPRO.php">BRAND</a>
                        <ul class="sub-menu">
                            <?php
                            $query="select * from BRAND";
                            $stmt=$dao->DML($query);
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                $IDBR=$row['IDBR'];
                                $NAMEBR=$row['NAMEBR'];
                                ?>
                                <li><a href="SHOWPRO.php?IDBR=<?=$IDBR?>"><?=$NAMEBR?></a></li>
                            <?php
                            endwhile;
                            ?>
                        </ul>
                    </li>
                    <li><a href="">MAKE UP</a>
                        <ul class="sub-menu">
                            <?php
                            $query="select * from CATEGORY where (IDCTGR='CT1' or IDCTGR='CT2' or IDCTGR='CT3')";
                            $stmt=$dao->DML($query);
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                $IDCTGR=$row['IDCTGR'];
                                $NAMECTGR=$row['NAMECTGR'];
                                ?>
                                <li><a href="SHOWPRO.php?IDCTGR=<?=$IDCTGR?>"><?=$NAMECTGR?></a></li>
                            <?php
                            endwhile;
                            ?>
                        </ul>
                    </li>
                    <li><a href="">SKIN CARE</a>
                        <ul class="sub-menu">
                            <?php
                            $query="select * from CATEGORY where (IDCTGR='CT4' or IDCTGR='CT5' or IDCTGR='CT6'or IDCTGR='CT7'or IDCTGR='CT8')";
                            $stmt=$dao->DML($query);
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                $IDCTGR=$row['IDCTGR'];
                                $NAMECTGR=$row['NAMECTGR'];
                                ?>
                                <li><a href="SHOWPRO.php?IDCTGR=<?=$IDCTGR?>"><?=$NAMECTGR?></a></li>
                            <?php
                            endwhile;
                            ?>
                        </ul>
                    </li>
                    <li><a href="SHOWPRO.php?IDCTGR=CT9">ACCESSORIES</a>
                    </li>
                    <li class=""><a href="SPECIALPRICE.php">SPECIALPRICE</a>
                    </li>
                    <li><a href="CONTACT.php">CONTACT US</a></li>
                    <?php
                    if (isset($_SESSION['USERNAME'])) {
                        if (($_SESSION['USERNAME'] == 'admin') ) {
                            echo '<li><a href="./ADMIN.php" class="action ">HELLO BOSS</a></li>';
                            echo '<li><a href="logout.php" class="action ">LOG OUT</a></li>' ;
                        }
                        if (($_SESSION['USERNAME'] != 'admin')) {
                            echo '<li><a href="./USER.php" class="action">'."WELLCOME," . $_SESSION['USERNAME'] ."</a></li>";
                            echo '<li><a href="logout.php" class="action ">LOG OUT</a></li>' ;
                        }
                    } else {

                        echo '<li><a href="#" data-bs-toggle="modal" data-bs-target="#login">MY ACCOUNT</a></li> ';
                    }
                    ?>


                </ul>
            </nav>
        </div>
        <!-- Menu End -->
    </div>
</div>

<!-- Offcanvas Search Start -->
<div class="offcanvas-search">
    <div class="offcanvas-search-inner">
        <div class="search-wrapper">
            <form method="get" ACTION="SHOWPRO.php" >
                <input type="text" name="search" placeholder="Search Hear...">
                <button type="submit" value="search" ><i class="flaticon-search"></i></button>
            </form>
        </div>
        <!-- Button Close Start -->
        <div class="offcanvas-btn-close"><a class="search-close" href="javascript:;">
                <span></span>
                <span></span> </a>
        </div>
        <!-- Button Close End -->

    </div>
</div>
<!-- Offcanvas Search End -->
<!-- Modal login-->
<div class="modal fade login" id="login" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="column-left">
                    <div class="login-wrpper">
                        <h4 class="title title-small no_after mb-0">Login</h4>
                        <div class="comments-form">
                            <form name="login" method="POST" action="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="single-form">
                                            <input type="text" name="USERNAME" placeholder="Your Username">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                            <input type="password" name="PASS" placeholder="Your Password">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form d-flex justify-content-between submit_lost-password">
                                            <input type="submit" value="LOGIN" id="login1">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="RESETPASS.php" class="lost-password">Lost your password?</a>

                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="column-right">
                    <div class="not-member">
                        <h4 class="title title-small no_after text_white mb-0">Not a member?</h4>
                        <span class="subtitle text_white mt-3">To keep connected with us please
            login with your personal info.</span>
                        <a href="#" class="load-more primary_dark_btn mt-4" data-dismiss="modal" data-bs-toggle="modal" data-bs-target="#register">Create an account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade login" id="register" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" >
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="column-right">
                    <div class="not-member">
                        <h4 class="title title-small no_after text_white mb-0">Welcome Back!</h4>
                        <span class="subtitle text_white mt-3">To keep connected with us please
            login your personal info.</span> <a href="#" class="load-more primary_dark_btn mt-4" data-bs-toggle="modal" data-bs-target="#login">Login</a> </div>
                </div>
                <div class="column-left">
                    <div class="login-wrpper">
                        <h4 class="title title-small no_after mb-0">Create an account</h4>
                        <div class="comments-form">
                            <form name="signup" method="POST" action="" onsubmit="return CHECK();">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="single-form">
                                            <span class="required error"
                                                  id="USERNAME-info"></span>
                                            <input type="text" placeholder="Username" value="" name="USERNAME"  id="USERNAME">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                             <span class="required error"
                                                   id="PASS-info"></span>
                                            <input type="password" name="PASS" value="" placeholder="What is your password?"
                                                   id="PASS">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                             <span class="required error"
                                                   id="CFPASS-info"></span>
                                            <input type="password" name="CFPASS" value="" placeholder="Confirm your password?"
                                                   id="CFPASS">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                             <span class="required error"
                                                   id="EMAIL-info"></span>
                                            <input type="text" name="EMAIL" value="" placeholder="What is your email?"
                                                   id="EMAIL">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                            <span class="required error"
                                                  id="PHONE-info"></span>
                                            <input type="text" name="PHONE" value="" placeholder="What is your phone number?"
                                                   id="PHONE">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                       <p>By registering, you agree to Rosie Store's terms of service & privacy policy</p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form d-flex justify-content-between submit_lost-password">
                                            <input type="submit" value="RESIGN" id="login2">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Slider Start  -->
