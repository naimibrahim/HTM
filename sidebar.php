<?php 
//start session
session_start(); ?>
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="main_basic.php"><img src="assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
              	  <h5 class="centered">My Sentiment</h5>
              	  	
                  <li class="mt">
                      <?php
                      if ($_SESSION["user_level"] > "1") {
                        ?><a href="main.php">
                          <i class="fa fa-dashboard"></i>
                          <span>Main</span>
                      </a><?php  } 
                      else {
                        ?><a href="main_basic.php">
                          <i class="fa fa-dashboard"></i>
                          <span>Main</span>
                      </a> <?php  }  ?>
                       <a href="update_details.php">
                          <i class="fa fa-user"></i>
                          <span>Update Profile</span>
                      </a>
                      <?php
                      if ($_SESSION["user_level"] > "1") {
                        ?><a href="manage_keyword.php">
                          <i class="fa fa-search-plus"></i>
                          <span>Manage Keyword</span>
                      </a><?php  }  ?>
                      <?php
                      if ($_SESSION["user_level"] == "99") {
                        ?><a href="manage_users.php">
                          <i class="fa fa-users"></i>
                          <span>Manage Users</span>
                      </a><?php  }  ?>
                          <a href="about_mysentiment.php">
                          <i class="fa fa-user"></i>
                          <span>About MySentiment</span>
                      </a>
                  </li>
                   <li class="mt">
                      <?php //echo _SESSION["username"]; ?>
                  </li>
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>