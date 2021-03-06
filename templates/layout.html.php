<!DOCTYPE html>
<html lang="en">
    <head>
        <script type="text/javascript" src="/tabScript.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/style.css">
        <link rel="stylesheet" href="/diary.css"/>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        
        <title><?=$title?></title>
    </head>
    
    
        <?php 
        //var_dump($route);
        
            if($route == 'login') {
                //maybe load a template at this point for login box or etc
                ?>
                <body>
                <img class="logo" src="/images/new logo.jpg" alt="logo"> 
                <?=$output;?>
                <?php
                //to-do add section to enable printout of reports without nav and background image
            }
            //in order to print a route must be printable, i.e. print is set in the route + get var must be set
            else if (isset($_GET['print']) && $_GET == true && isset($routes[$route][$method]['print']) && $routes[$route][$method]['print'] == true){
                ?>
                
                <body class = "printout">
                <div class = "printout-top">
                <img class="logo-printout" src="/images/new logo.jpg" alt="logo"> 

                <h2>Woodlands University College</h2>

                <section class="address-info">
                    <ul>
                        <li>123 Woodlands Lane, NN1 5SF</li>
                        <li>contact@woodlands.ac.uk</li>
                        <li>01733 451786</li>
                    </ul>
                </section>
                
                </div>
                <?=$output;?>

                <section class="print-footer">
                    <ul>
                        <li>Woodland University College &copy;</li>
                    </ul>
                </section>
                <?php
            }
            else {
        ?>
        <body>
        <!--Container for logo and user access box-->
        <div class = "logo-container">
            <img class="logo" src="/images/new logo.jpg" alt="logo">
            <div class="login-info">
                <img class="usericon" src="/images/profile-icon-illustration-user-profile-computer-icons-girl-customer-avatar-png-clip-art.png"> 
                <div class="username-login"><?=$user['name'] ?? 'Admin'?></div>
                <div class="btn-group">
                    <button class="btn btn-secondary btn-sm dropdown-toggle logout-button" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </button>
                    
                    <!--Dropdown menu for user access, i.e. other none main selection items-->
                    <div class="dropdown-menu">
                        <a class="dropdown-item hvr-grow-shadow" href="/construction">Dashboard</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/construction">Settings</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/tutorial/timetable">Tutorials</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/construction">Help</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/logout">Logout</a>
                    </div>
                </div>
                
            </div>
            
        </div>   
        <nav class="navbar navbar-expand-lg justify-content-center">
            <!-- <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button> -->
            <!-- <div class="collapse navbar-collapse " id="navbarMenu"> -->        
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link hvr-sweep-to-left" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Student</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item hvr-grow-shadow" href="/student/home">Create</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/student/amendstudentlist">Amend</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/student/archive">Archive</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/student/displaystudentlist">Display</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Assign</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link hvr-sweep-to-left" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Staff</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item hvr-grow-shadow" href="/staff/create">Create</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/staff/list">Amend</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/staff/archive">Archive</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/staff/displaylist">Display</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Assign</a>

                    </div>
                </li>
                <li class="nav-item dropdown ">
                    <a href="#" class="nav-link hvr-sweep-to-left" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Course</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item hvr-grow-shadow" href="#">Create Structure</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Amend</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Display</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Delete</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Archive</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link hvr-sweep-to-left" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Module</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item hvr-grow-shadow" href="#">Create</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Amend</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Delete</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Archive</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Display</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Assign</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link hvr-sweep-to-left" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Assignment</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item hvr-grow-shadow" href="#">Create</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Amend</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Delete</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Archive</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Display</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Assign</a>
                        <a class="dropdown-item hvr-grow-shadow" href="#">Mark/Grade</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link hvr-sweep-to-left" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Attendance</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item hvr-grow-shadow" href="/attendance/module/select">Create</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/attendance/form/search">Amend</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/attendance/form/search">Archive</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/attendance/monitor">Monitor</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/attendance/form/search">Display</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/attendance/action/list">Action Poor Attendance</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link hvr-sweep-to-left" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Personal Tutor</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item hvr-grow-shadow" href="/tutor/personaltutorlist">Create</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/tutor/amendpersonaltutorlist">Amend</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/tutor/assignpersonaltutorlist">Assign</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/tutor/displaytutorlist">Display</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link hvr-sweep-to-left" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Timetable</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item hvr-grow-shadow" href="/timetable/select">Create</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/timetable/results">Amend</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/timetable/results">Delete</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/timetable/archive">Archive</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/timetable/results">Display</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/timetable/results">Search</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link hvr-sweep-to-left" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Diary</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item hvr-grow-shadow" href="/diary/create">Create</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/diary/results">Amend</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/diary/results">Delete</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/diary/view">Display</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/diary/results">Search</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link hvr-sweep-to-left" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Report</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item hvr-grow-shadow" href="/construction">Create</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/report/display">Display</a>
                        <a class="dropdown-item hvr-grow-shadow" href="/report/print">Print</a>
                    </div>
                </li>
            </ul>
        <!-- </div> -->
        </nav>

        <?= $output ?>

        </body>
        <?php
        }
        ?>
</html>