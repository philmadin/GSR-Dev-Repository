<?php
include "mysql_con.php";

if(isset($_SESSION['username'])){$sessionlogin = $_SESSION['username'];}
if(isset($_COOKIE['username'])){$cookielogin = $_COOKIE['username'];}

?>



<div id="sidebar" class="navmenu navmenu-default navmenu-fixed-right">
    <a class="navmenu-brand" href="index.php"><img src="imgs/header_logo.png" style="width: 100px; display: inline-block;margin:auto;"/></a>
    
                <div class="input-group" id="adv-search">
                    <input type="text" id="search-gsr" class="form-control" placeholder="Search GSR" />
                    <div class="input-group-btn">
                        <div class="btn-group" role="group">
                            <div class="dropdown dropdown-lg">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">
                                            <label for="filter">Filter by</label>
                                            <select class="form-control">
                                                <option value="1" selected>Featured</option>
                                                <option value="2">Most popular</option>
                                                <option value="3">Top rated</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary"><span class="fa fa-search" aria-hidden="true"></span></button>
                                    </form>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary"><span class="fa fa-search" aria-hidden="true"></span></button>
                        </div>
                    </div>
                </div>


    <ul class="nav navmenu-nav">
        <?php include 'nav-links.php'; ?>
    </ul>

    <style>
        .dropdown.dropdown-lg .dropdown-menu {
            margin-top: -1px;
            padding: 6px 20px;
        }
        .input-group-btn .btn-group {
            display: flex !important;
        }
        .btn-group .btn {
            border-radius: 0;
            margin-left: -1px;
        }
        .btn-group .btn:last-child {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        .btn-group .form-horizontal .btn[type="submit"] {
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }
        .form-horizontal .form-group {
            margin-left: 0;
            margin-right: 0;
        }
        .form-group .form-control:last-child {
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }


            #adv-search {
                width: 100%;
                margin: 0 auto;

            .dropdown.dropdown-lg {
                position: static !important;
            }
            .dropdown.dropdown-lg .dropdown-menu {
                min-width: 300px;
            }

        #search-gsr{
            color:white;
        }

        #search-gsr::-webkit-input-placeholder {
            color: white;
        }

        #search-gsr:-moz-placeholder { /* Firefox 18- */
            color: white;
        }

        #search-gsr::-moz-placeholder {  /* Firefox 19+ */
            color: white;
        }

        #search-gsr:-ms-input-placeholder {
            color: white;
        }
    </style>

</div>
