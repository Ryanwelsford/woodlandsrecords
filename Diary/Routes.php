<?php
namespace Diary;
class Routes implements \RWCSY2028\Routes {
    public function getRoutes() {
        require '../database.php';
        //amaans
        $studenttable = new \Classes\databasetable($pdo,'students','id');
        $archivestudenttable = new \Classes\databasetable($pdo,'archivedstudents','id');
        $stafftable = new \Classes\databasetable($pdo,'staff','id');
        $unassignedstafftable = new \Classes\databasetable($pdo,'unassignedstaff','id');
        $archivestafftable = new \Classes\databasetable($pdo,'archivedstaff','id');
        $unassignedstafftable = new \Classes\databasetable($pdo,'unassignedstaff','id');
        $personaltutortable = new \Classes\databasetable($pdo,'personaltutor','id');
        $tuteestable = new \Classes\databasetable($pdo,'tutees','id');

        $studentcontroller = new \Controllers\studentController($studenttable,$archivestudenttable);
        $staffcontroller = new \Controllers\staffController($stafftable,$unassignedstafftable,$archivestafftable);
        $personaltutorcontroller = new \Controllers\personaltutorController($unassignedstafftable,$personaltutortable,$studenttable,$tuteestable);
        $loginController = new \Controllers\loginController(false);

        //ryans
        //diary tables
        $appointmentsTable = new \RWCSY2028\DatabaseTable($pdo, 'appointment', 'id');
        $diariesTable = new \RWCSY2028\DatabaseTable($pdo, 'diary', 'id');
        //timetable tables
        $roomsTable = new \RWCSY2028\DatabaseTable($pdo, 'rooms', 'id');
        $timetableTable = new \RWCSY2028\DatabaseTable($pdo, 'timetable', 'id');
        $timetable_slotsTable = new \RWCSY2028\DatabaseTable($pdo, 'timetable_slots', 'id');
        $archivedTimetableTable = new \RWCSY2028\DatabaseTable($pdo, 'archived_timetable', 'id');
        $archived_slotsTable = new \RWCSY2028\DatabaseTable($pdo, 'archived_timetable_slots', 'id');
        $tempCourseTable = new \RWCSY2028\DatabaseTable($pdo, 'temp_course', 'id');

        //reports tables
        $studentReportTable = new \RWCSY2028\DatabaseTable($pdo,'students','id');

        $timetableController = new \Diary\Controllers\Timetable($timetableTable, $timetable_slotsTable, $tempCourseTable, $roomsTable, $archivedTimetableTable, $archived_slotsTable);
        $diaryController = new \Diary\Controllers\Diary($diariesTable, $appointmentsTable, $_GET, $_POST);
        $generalController = new \Diary\Controllers\General();
        $reportController = new \Diary\Controllers\Report($studentReportTable);

        $routes = [
            'student/home' => [
                'GET' => [
                    'controller' =>$studentcontroller,
                    'function' => 'home'
                ],
                'POST' => [
                    'controller' =>$studentcontroller,
                    'function' => 'home'
                ]
            ],
            'student/amendstudentlist' => [
                'GET' => [
                    'controller' =>$studentcontroller,
                    'function' => 'amendstudentlist'
                ],
                'POST' => [
                    'controller' =>$studentcontroller,
                    'function' => 'amendstudentlist'
                ]
            ],
            'student/amendstudent' => [
                'GET' => [
                    'controller' =>$studentcontroller,
                    'function' => 'amendstudent'
                ],
                'POST' => [
                    'controller' =>$studentcontroller,
                    'function' => 'amendstudent'
                ]
            ],
            'student/archive' => [
                'GET' => [
                    'controller' =>$studentcontroller,
                    'function' => 'archive'
                ],
                'POST' => [
                    'controller' =>$studentcontroller,
                    'function' => 'archive'
                ]
            ],
            'student/displaystudentlist' => [
                'GET' => [
                    'controller' =>$studentcontroller,
                    'function' => 'displaystudentlist'
                ],
                'POST' => [
                    'controller' =>$studentcontroller,
                    'function' => 'displaystudentlist'
                ]
            ],
            'student/displaystudent' => [
                'GET' => [
                    'controller' =>$studentcontroller,
                    'function' => 'displaystudent'
                ],
                'POST' => [
                    'controller' =>$studentcontroller,
                    'function' => 'displaystudent'
                ]
            ],
            'staff/create' => [
                'GET' => [
                    'controller' =>$staffcontroller
                    ,
                    'function' => 'createstaff'
                ],
                'POST' => [
                    'controller' =>$staffcontroller,
                    'function' => 'createstaff'
                ]
            ],
            'staff/list' => [
                'GET' => [
                    'controller' =>$staffcontroller
                    ,
                    'function' => 'liststaff'
                ],
                'POST' => [
                    'controller' =>$staffcontroller,
                    'function' => 'liststaff'
                ]
            ],
            'staff/amend' => [
                'GET' => [
                    'controller' =>$staffcontroller
                    ,
                    'function' => 'amendstaff'
                ],
                'POST' => [
                    'controller' =>$staffcontroller,
                    'function' => 'amendstaff'
                ]
            ],
            'staff/archive' => [
                'GET' => [
                    'controller' =>$staffcontroller
                    ,
                    'function' => 'archivestaff'
                ],
                'POST' => [
                    'controller' =>$staffcontroller,
                    'function' => 'archivestaff'
                ]
            ],
            'staff/displaylist' => [
                'GET' => [
                    'controller' =>$staffcontroller
                    ,
                    'function' => 'staffdisplaylist'
                ],
                'POST' => [
                    'controller' =>$staffcontroller,
                    'function' => 'staffdisplaylist'
                ]
            ],
            'staff/displaystaff' => [
                'GET' => [
                    'controller' =>$staffcontroller
                    ,
                    'function' => 'displaystaff'
                ],
                'POST' => [
                    'controller' =>$staffcontroller,
                    'function' => 'displaystaff'
                ]
            ],
            'tutor/personaltutor' => [
                'GET' => [
                    'controller' =>$personaltutorcontroller
                    ,
                    'function' => 'personaltutor'
                ],
                'POST' => [
                    'controller' =>$personaltutorcontroller,
                    'function' => 'personaltutor'
                ]
            ],
            'tutor/personaltutorlist' => [
                'GET' => [
                    'controller' =>$personaltutorcontroller
                    ,
                    'function' => 'personaltutorlist'
                ],
                'POST' => [
                    'controller' =>$personaltutorcontroller,
                    'function' => 'personaltutorlist'
                ]
            ],
            'tutor/amendpersonaltutorlist' => [
                'GET' => [
                    'controller' =>$personaltutorcontroller
                    ,
                    'function' => 'amendpersonaltutorlist'
                ],
                'POST' => [
                    'controller' =>$personaltutorcontroller,
                    'function' => 'amendpersonaltutorlist'
                ]
            ],
            'tutor/amendpersonaltutor' => [
                'GET' => [
                    'controller' =>$personaltutorcontroller
                    ,
                    'function' => 'amendpersonaltutor'
                ],
                'POST' => [
                    'controller' =>$personaltutorcontroller,
                    'function' => 'amendpersonaltutor'
                ]
            ],
            'tutor/assignpersonaltutorlist' => [
                'GET' => [
                    'controller' =>$personaltutorcontroller
                    ,
                    'function' => 'assignpersonaltutorlist'
                ],
                'POST' => [
                    'controller' =>$personaltutorcontroller,
                    'function' => 'assignpersonaltutorlist'
                ]
            ],
            'tutor/assignpersonaltutor' => [
                'GET' => [
                    'controller' =>$personaltutorcontroller
                    ,
                    'function' => 'assignpersonaltutor'
                ],
                'POST' => [
                    'controller' =>$personaltutorcontroller,
                    'function' => 'assignpersonaltutor'
                ]
            ],
            'tutor/displaytutorlist' => [
                'GET' => [
                    'controller' =>$personaltutorcontroller
                    ,
                    'function' => 'displaytutorlist'
                ],
                'POST' => [
                    'controller' =>$personaltutorcontroller,
                    'function' => 'displaytutorlist'
                ]
            ],
            'tutor/displaypersonaltutor' => [
                'GET' => [
                    'controller' =>$personaltutorcontroller
                    ,
                    'function' => 'displaypersonaltutor'
                ],
                'POST' => [
                    'controller' =>$personaltutorcontroller,
                    'function' => 'displaypersonaltutor'
                ]
            ],
            'diary/view' => [
                'GET' => [
                    'controller' =>$diaryController,
                    'function' => 'view'
                ]
            ],
            'diary/create' => [
                'GET' => [
                    'controller' =>$diaryController,
                    'function' => 'create'
                ],
                'POST' => [
                    'controller' => $diaryController,
                    'function' => 'create'
                ]
            ],
            'diary/delete' => [
                'POST' => [
                    'controller' => $diaryController,
                    'function' => 'delete'
                ]
            ],
            'diary/results' => [
                'GET' => [
                    'controller' => $diaryController,
                    'function' => "results"
                ]
            ],
            'timetable/create' => [
                'GET' => [
                    'controller' => $timetableController,
                    'function' => 'create'
                ],
                'POST' => [
                    'controller' => $timetableController,
                    'function' => 'create'
                ]
            ],
            'timetable/view' => [
                'GET' => [
                    'controller' => $timetableController,
                    'function' => 'view'
                ],
                'POST' => [
                    'controller' => $timetableController,
                    'function' => 'view'
                ]
            ],
            'timetable/select' => [
                'GET' => [
                    'controller' => $timetableController,
                    'function' => 'selectCourse'
                ],
                'POST' => [
                    'controller' => $timetableController,
                    'function' => 'selectCourse'
                ]
            ],
            'timetable/selectionSearch' => [
                'GET' => [
                    'controller' => $timetableController,
                    'function' => 'selectionSearch'
                ]
            ],
            'timetable/results' => [
                'GET' => [
                    'controller' => $timetableController,
                    'function' => 'results'
                ]
            ],
            'timetable/delete' => [
                'POST' => [
                    'controller' => $timetableController,
                    'function' => 'delete'
                ]
            ],
            'timetable/archive' => [
                'GET' => [
                    'controller' => $timetableController,
                    'function' => 'archiveResults'
                ],
                'POST' => [
                    'controller' => $timetableController,
                    'function' => 'archiveResults'
                ]
            ],
            'timetable/archive/results' => [
                'GET' => [
                    'controller' => $timetableController,
                    'function' => 'archiveSearch'
                ]
            ],
            'timetable/restore' => [
                'POST' => [
                    'controller' => $timetableController,
                    'function' => 'restore'
                ]
            ],
            'timetable/store' => [
                'POST' => [
                    'controller' => $timetableController,
                    'function' => 'store'
                ]
            ],
            'login' => [
                'GET' => [
                    'controller' => $loginController,
                    'function' => 'login'
                ],
                'POST' => [
                    'controller' => $loginController,
                    'function' => 'login'
                ]
            ],
            'logout' => [
                'GET' => [
                    'controller' => $loginController,
                    'function' => 'logout'
                ]
            ],
            'construction' => [
                'GET' => [
                    'controller' => $generalController,
                    'function' => 'construction'
                ]
            ],
            'pagenotfound' => [
                'GET' => [
                    'controller' => $generalController,
                    'function' => 'pageNotFound'
                ]
            ],
            'report/display' => [
                'GET' => [
                    'controller' => $reportController,
                    'function' => 'display'
                ]
            ],
            'report/print' => [
                'GET' => [
                    'controller' => $reportController,
                    'function' => 'print'
                ]
            ],
            'report/timetable/student' => [
                'GET' => [
                    'controller' => $timetableController,
                    'function' => 'studentTimetable',
                    'print' => true
                ]
            ],
            'report/student/contacts-by-id' => [
                'GET' => [
                    'controller' => $reportController,
                    'function' => 'studentContactsId',
                    'print' => true
                ]
            ],
            '' => [
                'GET' => [
                    'controller' =>$studentcontroller,
                    'function' => 'home'
                ],
                'POST' => [
                    'controller' => $studentcontroller,
                    'function' => 'home'
                ]
            ]

        ];
        return $routes;
    }
    
    //if user attempts to access unset route reroute to default page
    //ultimately would be dashboard concept
    public function getReroute() {
            $route = 'pagenotfound';
        
        return $route;
    }

    public function getLayoutVariables() {
        //this would pull out the user information of logged user
        return [
    
        ];
    }

    //ensure user is logged in order to access any page of rm
    public function checkLogin($route) {
        //session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            return $route;
        }
        else {
            // if not logged send to login page
            return 'login';
        }
    }
}