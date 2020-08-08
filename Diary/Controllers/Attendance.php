<?php
namespace Diary\Controllers;

class Attendance {
    private $studentsTable;
    private $courseTable;
    private $moduleTable;
    private $attendanceTable;
    private $attendance_mappingsTable;
    private $archivedAttendanceTable;
    private $archivedAttendance_mappingsTable;
    //so the pages we will need starting at the top
    public function __construct($studentsTable, $courseTable, $moduleTable, $attendanceTable, $attendance_mappingsTable, $archivedAttendanceTable, $archivedAttendance_mappingsTable) {
        $this->studentsTable = $studentsTable;
        $this->courseTable = $courseTable;
        $this->moduleTable = $moduleTable;
        $this->attendanceTable = $attendanceTable;
        $this->attendance_mappingsTable = $attendance_mappingsTable;
        $this->archivedAttendanceTable = $archivedAttendanceTable;
        $this->archivedAttendance_mappingsTable = $archivedAttendance_mappingsTable;
    }

    //a method to create a new attendance document for the week
    //this will need to include a method to select which module to input students attendance
    public function create() {
        $title = 'Create Attendance';
        //currently uses all available students as students cannot be assigned a course as course doesnt exist!
        $students = $this->studentsTable->findAll();
        $date = \Date('Y-m-d');

        //if data is sent from module selection page pull the module info
        if(isset($_POST['module'])) {
            $module_id = $_POST['module'];
            $module = $this->moduleTable->find('id', $module_id)[0];
            $attendanceRef = false;
        }
        //if an edit is required to an already created attendance form pull that attendance form
        else if (isset($_GET['id'])) {
            $attendanceRef = $this->attendance_mappingsTable->find('id', $_GET['id']);
            if(isset($attendanceRef[0])) {
                //get module info for said attendance form aswell as date and ref id
                $attendanceRef = $attendanceRef[0];
                $module = $this->moduleTable->find('id', $attendanceRef->module_id)[0];
                $date = $attendanceRef->date;
                $attendanceRef = $attendanceRef->id;

                //find all students involved within the attendance
                $mappings = $this->attendanceTable->find('mapping_id', $attendanceRef);
                $students = array();
                //map details to students based on the ref and if they attended in the previous iteration of the form
                foreach($mappings as $mapping) {
                    $student = new \stdclass;
                    $student = $this->studentsTable->find('studentid', $mapping->student_id)[0];
                    $student->attendance = $mapping->id;
                    $student->attended = $mapping->attended;
                    //add mapped student to students array 
                    $students[] = $student;
                }
            }
            //if invalid get id set
            else {
                header('location: /attendance/module/select');
            }
        }
        // if module isnt set
        else {
            header('location: /attendance/module/select');
        }

        // if form is submitted 
        if(isset($_POST['attendance'])) {
            //pull info from form relevent to referene
            $attendanceRef = $_POST['attendanceRef'];
            $date = $_POST['date'];
            $module_id = $_POST['module'];
            //map to fields
            $attendanceMapping['date'] = $date;
            $attendanceMapping['module_id'] = $module_id;
            $attendanceMapping['id'] = $attendanceRef;

            //pull new attendance info
            $attendance = $_POST['attendance'];

            //if is not an update, therfore is a new creation of form
            if($attendanceRef == '') {
                $this->attendance_mappingsTable->save($attendanceMapping);
                $attendanceRef = $this->attendance_mappingsTable->findLatestRecord()[0];
                
            }
            
            $attendanceValue['mapping_id'] = $attendanceRef;
            //save info per student
            foreach($attendance as $student_id => $each) {
                //pretty sure this is redundant but map the attendence table id to the student when updating 
                if(isset($each['id'])) {
                    $attendanceValue['id'] = $each['id'];
                }
                else {
                    $attendanceValue['id'] = '';
                }
                //map final variables then save to table
                $attendanceValue['student_id'] = $student_id;
                $attendanceValue['attended'] = $each['attended'];
                $this->attendanceTable->save($attendanceValue);
            }
            //route to success page
            return $this->success();
            
        }

        
        return [
            'template' => 'attendancetable.html.php',
            'title' => $title,
            'variables' => [
                'students' => $students,
                'date' => $date,
                'module' => $module,
                'attendanceRef' => $attendanceRef
            ]
        ];
    }
    //find which attendance to amend and display
    public function amend() {
        $title = "Find Attendance to Amend";
        $moduleSearch = new \RWCSY2028\TableSearchBox($this->moduleTable);
        $tableSearchBox = new \RWCSY2028\TableSearchBox($this->attendance_mappingsTable);
        $searchBox = $tableSearchBox->generalSearchBox('/attendance/form/search');
        
        if(isset($_GET['pageno']) && $_GET['pageno'] > 1) {
            $pageno = $_GET['pageno'];
        }
        else {
            $pageno = 1;
        }
        $resultsperpage = 5;
        $limit['offset'] = ($pageno-1)*$resultsperpage;
        $limit['total'] = $resultsperpage;

        if(isset($_GET['search']) && isset($_GET['pageno']) && $_GET['pageno'] != '') {
            $search = $_GET['search'];
            $search = strtolower(str_replace('/', '-', $search));
            $dateOptions = explode('-',$search);
            if(sizeof($dateOptions) == 3) {
                try {
                    $date = new \DateTime($search);
                    $search = $date->format('Y-m-d');
                }
                catch (\Exception $e) {
                    $search = $_GET['search'];
                }
            }
            
            $heading = "Attendance Search Results";
            
        }
        else {
            $title = "Select Results";
            $heading = "Displaying All Attendance Forms";
            
            $search = '';
            //var_dump($generalResults);

            //$results = $this->tableSearchBox->getSearchResults($_GET['field'], $search, $limit);
        }
        //pull module information based on search term, add that to the search term for attendance searches
        $moduleResults = $moduleSearch->getGeneralSearchResults($search);
        foreach($moduleResults as $module) {
            $search .= " ".$module->id;
        }
        $generalResults = $tableSearchBox->getGeneralSearchResults($search,$limit);
        $totalSearchResults = sizeof($tableSearchBox->getGeneralSearchResults($search));
        $pageNext = $tableSearchBox->paginationNext($pageno, $totalSearchResults, $resultsperpage);
        $pagePrevious = $tableSearchBox->paginationPrevious($pageno);
        $results = $generalResults;

        foreach ($results as $result) {
            $result->module = $this->moduleTable->find('id', $result->module_id)[0];
        }
        return [
            'template' => 'attendanceresults.html.php',
            'title' => $title,
            'variables' => 
            [ 
                'heading' => $heading,
                'searchBox' => $searchBox,
                'results' => $results,
                'totalSearchResults' => $totalSearchResults,
                'pageno' => $pageno,
                'resultsperpage' => $resultsperpage,
                'pageNext' => $pageNext,
                'pagePrevious' => $pagePrevious,
            ]
        ];
    }
    //used as a variartion of construction page simply shows the form has been submitted and gives option to create another form
    public function success() {
        $title = "Attendance Submitted";

        $h1 = "Attendance Form Successfully Submitted";
        $p = "<a href= '/attendance/module/select'>Create Another? </a>";
        return [
            'template' => 'construction.html.php',
            'title' => $title,
            'variables' => [
                'h1' => $h1,
                'p' => $p
            ]
        ];
    }
    //allow the user to select which module attendance is being taken for
    public function moduleSelect() {
        $title = "Select Module";
        //ideally allow for search of a course then find relevent modules from that but temp course table is not a full implementation of course table
        $courses = $this->courseTable->findAll();
        $modules = $this->moduleTable->findAll();
        $TableSearchBox = new \RWCSY2028\TableSearchBox($this->moduleTable);
        $searchBox = $TableSearchBox->generalSearchBox('/attendance/module/search');

        

        //var_dump($modules);

        return [
            'template' => 'selectModule.html.php',
            'title' => $title,
            'variables' => [
                'searchBox' => $searchBox,
                'modules' => $modules
            ]
        ];
    }
    //if user chooses to search for a module instead of selecting
    //uses same logic as used in table search box else where 
    public function moduleSearch() {
        $title = "Select Module by Search";
        $TableSearchBox = new \RWCSY2028\TableSearchBox($this->moduleTable);
        $searchBox = $TableSearchBox->generalSearchBox('/attendance/module/search');

        $resultsPerPage = 5;
        if(isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        }
        else {
            $pageno = 1;
        }
        if(isset($_GET['search'])) {
            $search = $_GET['search'];
        }
        else {
            header('location: /timetable/select');
        }
        $limit['offset'] = ($pageno-1)*$resultsPerPage;
        $limit['total'] = $resultsPerPage;

        $totalResults = sizeof($TableSearchBox->getGeneralSearchResults($search));
        $results = $TableSearchBox->getGeneralSearchResults($search, $limit);

        $pageNext = $TableSearchBox->paginationNext($pageno, $totalResults, $resultsPerPage);
        $pagePre = $TableSearchBox->paginationPrevious($pageno);
        return [
            'template' => 'selectModuleSearch.html.php',
            'title' => $title,
            'variables' => [
                'searchBox' => $searchBox,
                'pageNext' => $pageNext,
                'pagePre' => $pagePre,
                'results' => $results,
                'totalResults' => $totalResults
            ]
        ];
    }
    //the creation method should also probably check to see if an attendance doc has been submitted within the current week

    //the ability to archive any attendance record
    public function archive() {
        if(isset($_POST['attendance'])) {
            $attendanceRef = $_POST['attendance']['id'];
            //find referenece information
            $attendance_mapping = $this->attendance_mappingsTable->find('id', $attendanceRef)[0];
            //find each student attendance mapping
            $attendance = $this->attendanceTable->find('mapping_id', $attendanceRef);

            //save in turn to archive tables
            $this->archivedAttendance_mappingsTable->saveObject($attendance_mapping);
            foreach($attendance as $each) {
                $this->archivedAttendanceTable->saveObject($each);
            }
            //delete in turn from standard tables 
            $this->attendance_mappingsTable->delete($attendanceRef);
            $this->attendanceTable->deleteWhere('mapping_id', $attendanceRef);
        }
        //pulls up a success page using the opaque banners used elsewhere
        $page = $this->success();
        $page['title'] = "Archived Attendance";
        $page['variables']['h1'] = "Attendance Successfully Archived";
        $page['variables']['p'] = "<a href='/attendance/form/search'>Return</a>";
        return $page;
    }
    //inversion of archive so remove from archive tables and place into standard
    public function restore() {
        if(isset($_POST['attendance'])) {
            $attendanceRef = $_POST['attendance']['id'];
            //find referenece information
            $attendance_mapping = $this->archivedAttendance_mappingsTable->find('id', $attendanceRef)[0];
            //find each student attendance mapping
            $attendance = $this->archivedAttendanceTable->find('mapping_id', $attendanceRef);

            //save in turn to archive tables
            $this->attendance_mappingsTable->saveObject($attendance_mapping);
            foreach($attendance as $each) {
                $this->attendanceTable->saveObject($each);
            }
            //delete in turn from standard tables 
            $this->archivedAttendance_mappingsTable->delete($attendanceRef);
            $this->archivedAttendanceTable->deleteWhere('mapping_id', $attendanceRef);
        }
        $page = $this->success();
        $page['title'] = "Restored Attendance";
        $page['variables']['h1'] = "Attendance Successfully Restored";
        $page['variables']['p'] = "View restored attendance <a href='/attendance/create?id=". $attendanceRef ."'>here</a>";
        return $page;
    }

    public function archiveResults() {
        $title = "Search Archives";
        $moduleSearch = new \RWCSY2028\TableSearchBox($this->moduleTable);
        $tableSearchBox = new \RWCSY2028\TableSearchBox($this->archivedAttendance_mappingsTable);
        $searchBox = $tableSearchBox->generalSearchBox('/attendance/archive/results');
        
        if(isset($_GET['pageno']) && $_GET['pageno'] > 1) {
            $pageno = $_GET['pageno'];
        }
        else {
            $pageno = 1;
        }
        $resultsperpage = 5;
        $limit['offset'] = ($pageno-1)*$resultsperpage;
        $limit['total'] = $resultsperpage;

        if(isset($_GET['search']) && isset($_GET['pageno']) && $_GET['pageno'] != '') {
            $search = $_GET['search'];
            $search = strtolower(str_replace('/', '-', $search));
            $dateOptions = explode('-',$search);
            if(sizeof($dateOptions) == 3) {
                try {
                    $date = new \DateTime($search);
                    $search = $date->format('Y-m-d');
                }
                catch (\Exception $e) {
                    $search = $_GET['search'];
                }
            }
            
            $heading = "Archived Attendance Search Results";
            
        }
        else {
            $title = "Select Results";
            $heading = "Displaying All Archived Attendance Forms";
            
            $search = '';
            //var_dump($generalResults);

            //$results = $this->tableSearchBox->getSearchResults($_GET['field'], $search, $limit);
        }
        //pull module information based on search term, add that to the search term for attendance searches
        $moduleResults = $moduleSearch->getGeneralSearchResults($search);
        foreach($moduleResults as $module) {
            $search .= " ".$module->id;
        }
        $generalResults = $tableSearchBox->getGeneralSearchResults($search,$limit);
        $totalSearchResults = sizeof($tableSearchBox->getGeneralSearchResults($search));
        $pageNext = $tableSearchBox->paginationNext($pageno, $totalSearchResults, $resultsperpage);
        $pagePrevious = $tableSearchBox->paginationPrevious($pageno);
        $results = $generalResults;

        foreach ($results as $result) {
            $result->module = $this->moduleTable->find('id', $result->module_id)[0];
        }
        return [
            'template' => 'archiveattendanceresults.html.php',
            'title' => $title,
            'variables' => 
            [ 
                'heading' => $heading,
                'searchBox' => $searchBox,
                'results' => $results,
                'totalSearchResults' => $totalSearchResults,
                'pageno' => $pageno,
                'resultsperpage' => $resultsperpage,
                'pageNext' => $pageNext,
                'pagePrevious' => $pagePrevious,
            ]
        ];
    }
    //action poor attendance in some way, i.e. for those that have poor attendance produce a printout for it ..?

    //monitor should display which students have not attended some count of modules within a certain time frame?
}