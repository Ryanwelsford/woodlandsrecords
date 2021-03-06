<?php
namespace wucdb;
class routes {
    public function callControllerFunction($route) {
        require '../database.php';
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

        //ryans section of tables and controllers
        $appointmentsTable = new \RWCSY2028\DatabaseTable($pdo, 'appointment', 'id');
        $diariesTable = new \RWCSY2028\DatabaseTable($pdo, 'diary', 'id');
        //timetable tables
        $roomsTable = new \RWCSY2028\DatabaseTable($pdo, 'rooms', 'id');
        $timetableTable = new \RWCSY2028\DatabaseTable($pdo, 'timetable', 'id');
        $timetable_slotsTable = new \RWCSY2028\DatabaseTable($pdo, 'timetable_slots', 'id');
        $tempCourseTable = new \RWCSY2028\DatabaseTable($pdo, 'temp_course', 'id');

        $timetableController = new \Diary\Controllers\Timetable($timetableTable, $timetable_slotsTable, $tempCourseTable, $roomsTable);
        $diaryController = new \Diary\Controllers\Diary($diariesTable, $appointmentsTable, $_GET, $_POST);



if($route == '')
{
    $page = $studentcontroller->home();
}
if($route == 'amendstudentlist')
{
    $page = $studentcontroller->amendstudentlist();
}
if($route == 'amendstudent')
{
    $page = $studentcontroller->amendstudent();
}
if($route == 'archive')
{
    $page = $studentcontroller->archive();
}
if($route == 'displaystudentlist')
{
    $page = $studentcontroller->displaystudentlist();
}
if($route == 'displaystudent')
{
    $page = $studentcontroller->displaystudent();
}
if($route == 'createstaff')
{
    $page = $staffcontroller->createstaff();
}
if($route == 'liststaff')
{
    $page = $staffcontroller->liststaff();
}
if($route == 'amendstaff')
{
    $page = $staffcontroller->amendstaff();
}
if($route == 'archivestaff')
{
    $page = $staffcontroller->archivestaff();
}
if($route == 'staffdisplaylist')
{
    $page = $staffcontroller->staffdisplaylist();
}
if($route == 'displaystaff')
{
    $page = $staffcontroller->displaystaff();
}
if($route == 'personaltutorlist')
{
    $page = $personaltutorcontroller->personaltutorlist();
}
if($route == 'personaltutor')
{
    $page = $personaltutorcontroller->personaltutor();
}
if($route == 'amendpersonaltutorlist')
{
    $page = $personaltutorcontroller->amendpersonaltutorlist();
}
if($route == 'amendpersonaltutor')
{
    $page = $personaltutorcontroller->amendpersonaltutor();
}
if($route == 'assignpersonaltutorlist')
{
    $page = $personaltutorcontroller->assignpersonaltutorlist();
}
if($route == 'assignpersonaltutor')
{
    $page = $personaltutorcontroller->assignpersonaltutor();
}
if($route == 'displaytutorlist')
{
    $page = $personaltutorcontroller->displaytutorlist();
}
if($route == 'displaypersonaltutor')
{
    $page = $personaltutorcontroller->displaypersonaltutor();
}
else if($route == 'home')
{
    $page = $studentcontroller->home();
}

return $page;
    }
}
?>