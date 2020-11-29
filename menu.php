<?php

require 'core_login.php';
require 'database_connect.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Our Menu | Bomino's Pizza</title>

    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="description" content="Web Development Mini-Project.">
    <meta name="author" content="Abhishek Joshi, Vineet Iyer, Vishak Kodethur">

    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#OD2C54">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#OD2C54">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#OD2C54">

    <!-- //Meta tag Keywords -->
    
    <!-- Bootstrap -->
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Google Fonts -->

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">

    <link rel="shortcut icon" href="images/favicon.png">
    <link rel="icon" href="images/favicon.png">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <!-- Functions -->
    <script type="text/javascript">
        
        function menu(){

            let x = document.getElementById("navbar");

            if(x.style.maxHeight == '60px' || x.style.maxHeight == '' || x.style.height == '60px'){
                x.style.maxHeight = " 1000px";
                document.getElementById('bar1').style.transform = 'rotate(-45deg) translate(-3px,7px)';
                document.getElementById('bar3').style.transform = 'rotate(45deg) translate(-3px,-7px)';
                document.getElementById('bar2').style.opacity = '0';
                document.getElementById('notnav').style.display = 'block';
                setTimeout(function() {
                    x.style.transition = '';
                    x.style.transition = '0.5s cubic-bezier(0, 1, 0, 1)';
                }, 500);
            }
            else
            {
                x.style.maxHeight = "60px";
                document.getElementById('bar1').style.transform = 'rotate(0deg) translate(0px,0px)';
                document.getElementById('bar3').style.transform = 'rotate(0deg) translate(0px,0px)';
                document.getElementById('bar2').style.opacity = '1';
                document.getElementById('notnav').style.display = 'none';
                setTimeout(function() {
                    x.style.transition = '';
                    x.style.transition = '1s ease-in;';
                }, 500);
            }
        }

        function navchange() {
            if(window.innerWidth > 850 && window.scrollY > 2)
            {
                document.getElementById('nav-logo-image').style.marginTop = '5px';
                document.getElementById('nav-logo-image').style.height = '60px';
                document.getElementById('navbar-ul').style.marginTop = '20px';
                document.getElementById('navbar').style.height = '70px';
            }

            else if(window.innerWidth > 850 && window.scrollY <= 2)
            {
                document.getElementById('nav-logo-image').style.marginTop = '7px';
                document.getElementById('nav-logo-image').style.height = '70px';
                document.getElementById('navbar-ul').style.marginTop = '29px';
                document.getElementById('navbar').style.height = '83px';
            }

            else
            {
                document.getElementById('nav-logo-image').style.marginTop = '6px';
                document.getElementById('nav-logo-image').style.height = '48px';
                document.getElementById('navbar-ul').style.marginTop = '60px';
                document.getElementById('navbar').style.height = 'auto';
            }
        }

    </script>
</head>
<body>


    <nav class="position-fixed topnav" id="navbar">

        <div class="nav-logo position-absolute">
            <a href="index.php"><img src="images/15b78dc9-cf77-49fe-97f4-fe2b4e5fb36b_200x200.png" class="nav-logo-img" id="nav-logo-image" alt=""></a>
        </div>

        <div class="toggle-bars position-absolute" onclick="menu();">
            <div class="bar-1 bar" id="bar1"></div>
            <div class="bar-2 bar" id="bar2"></div>
            <div class="bar-3 bar" id="bar3"></div>
        </div>

        <ul class="navbar-ul mb-0" id="navbar-ul">
            <a href="index.php" class="navbar-link">
                <li class="navbar-list"><div class="navbar-link-text d-inline">Home</div></li>
            </a>
            <a href="menu.php" class="navbar-link">
                <li class="navbar-list active"><div class="navbar-link-text d-inline">Our Menu</div></li>
            </a>
            <a href="order.php" class="navbar-link">
                <li class="navbar-list"><div class="navbar-link-text d-inline">Order Now</div></li>
            </a>
            <?php
            if(loggedin())
            {
                ?>
                <a href="view_orders.php" class="navbar-link">
                    <li class="navbar-list"><div class="navbar-link-text d-inline">View Orders</div></li>
                </a>
                <a href="profile.php" class="navbar-link">
                    <li class="navbar-list"><div class="navbar-link-text d-inline">Profile</div></li>
                </a>
                <a href="logout.php" class="navbar-link" id="reg-link">
                    <li class="navbar-list" id="reg-list"><div class="navbar-link-text d-inline">Logout</div></li>
                </a>
                <?php
            }
            else
            {
                ?>
                <a href="login.php" class="navbar-link" id="reg-link">
                    <li class="navbar-list" id="reg-list"><div class="navbar-link-text d-inline">Login</div></li>
                </a>
                <?php
            }
            ?>
        </ul>

    </nav>


    <div id="notnav" class="position-fixed h-100 w-100" onclick="menu();"></div>





<!-- MENU Section -->
    <div class="menu_bg">

        <!--row 1-->
        <div class="container">
            <?php

            $query = "SELECT * FROM menu WHERE included = 1";

            $query_run = mysqli_query($connect,$query);

            $count = 0;
            while($row = mysqli_fetch_assoc($query_run))
            {
                $count++;

                $non = '';
                $non1 = '';
                if($row['type'] == '0')
                {
                    $non = 'non-';
                    $non1 = 'Non-';
                }

                $arr = explode(", ",$row['ingredients']);

                $more = count($arr) - 1;
                ?>
                <div class="row col-sm-8 col-12 mx-auto border rounded p-3 main_row">
                    <!--Image and Name Content-->
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 my-auto mx-auto main_box">
                        <div class="mx-auto pizza_name <?php echo $non; ?>veg-pizza">
                            <b><?php echo $row['item'] ?></b>
                        </div>
                        <div class="topline">
                            
                        </div>
                        <div class="image_box">
                            <img src="<?php echo $row['img_src'] ?>" class="image">
                            <div title="<?php echo $row['ingredients'] ?>" data-toggle="tooltip" data-placement="bottom">
                                <div class="image_overlay">
                                    <div class="overlay_text">
                                        <span><b><?php echo $arr[0]; ?> and <?php echo $more; ?> more</b></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bottomline">
                            
                        </div>
                    </div>
                    <!--Middle Border Separator-->
                    <div class="col-xl-2 col-lg-2 col-md-2 middle_line">
                        <div class="line">
                            
                        </div>
                    </div>
                    <!--Details-->
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 details_box ">
                        <div class="mt-lg-4">
                            <div>
                                <b class="my-auto">Price:<span><?php echo $row['cost'] ?></span></b>
                            </div><br/>
                            <div>
                                <p><b>15 inch per peice.</b></p>
                                <p><b><span><?php echo $row['ingredients'] ?></span></b></p>
                                <p class="<?php echo $non; ?>veg-pizza"><span style="font-size: 0.5em;" class="fa-stack"><i class="far fa-square fa-stack-2x"></i><i class="fas fa-circle fa-stack-1x"></i></span> <?php echo $non1; ?>Veg</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php

            }

            ?>
        
            
        </div>

    </div>  
    




<footer class="footer pt-4 pb-2">
    <div class="container text-white">
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-12">
                <h3 class="text-center">Our Branches</h3>
                <p class="text-center">
                    Mumbai
                    <br>
                    Chennai
                    <br>
                    Bangalore
                </p>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 pt-sm-0 pt-3">
                <h3 class="text-center">Reach Out to Us</h3>
                <p class="text-center pt-2">
                    <i class="fas fa-phone-alt"></i> 9876987699
                </p>
                <p class="text-center">
                    <i class="fas fa-envelope"></i> contact@bominos.com
                </p>
            </div>
            <div class="col-lg-4 col-12 pt-lg-0 pt-3">
                <h3 class="text-center">Our Safety Norms</h3>
                <p class="text-center">
                    All our Employees Wear Masks
                    <br>
                    Contact-less Delivery
                    <br>
                    Temperature checking of all employees
                </p>
            </div>
        </div>
    </div>
</footer>




<!-- //MENU Section -->



    <script type="text/javascript">
        window.onresize = function() {
            let x = document.getElementById("navbar");
            navchange();
            if(window.innerWidth > 850)
            {
                x.style.maxHeight = "1000px";
                document.getElementById('bar1').style.transform = 'rotate(0deg) translate(0px,0px)';
                document.getElementById('bar3').style.transform = 'rotate(0deg) translate(0px,0px)';
                document.getElementById('bar2').style.opacity = '1';
                document.getElementById('notnav').style.display = 'none';
            }
            else
            {
                x.style.maxHeight = "60px";
                document.getElementById('bar1').style.transform = 'rotate(0deg) translate(0px,0px)';
                document.getElementById('bar3').style.transform = 'rotate(0deg) translate(0px,0px)';
                document.getElementById('bar2').style.opacity = '1';
                document.getElementById('notnav').style.display = 'none';
            }
        };

        window.onscroll = function() {
            navchange();
        }

        //Tooltip Script-->
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });

    </script>

</body>
</html>

