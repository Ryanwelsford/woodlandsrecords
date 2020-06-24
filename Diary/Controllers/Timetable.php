<?php
namespace Diary\Controllers;
class Timetable {
//needs access to course, timetables, modules, staff, student, timetable-modules, assigned-timetable and alot more
private $days;
private $timeslots;
private $roomsTable;
private $rooms;
private $tempCourseTable;
private $roomDetails;
private $timetableTable;
private $timetable_slotsTable;

    public function __construct($timetableTable, $timetable_slotsTable, $tempCourseTable,$roomsTable) {
        $this->timetableTable = $timetableTable;
        $this->timetable_slotsTable = $timetable_slotsTable;
        $this->tempCourseTable = $tempCourseTable;
        $this->roomsTable = $roomsTable;
        $this->generateRooms();
        $this->days =
        [
            "Monday" => "Mon",
            "Tuesday" => "Tue",
            "Wednesday" => "Wed",
            "Thursday" => "Thu",
            "Friday" => "Fri"
        ];
        $this->timeslots = ['9-10', '10-11', '11-12', '12-1', '1-2', '2-3', '3-4', '4-5'];
    }

    public function selectCourse($errors = []) {
        $title = "Select Course";
        $courses = $this->tempCourseTable->findAll();
        $TableSearchBox = new \RWCSY2028\TableSearchBox($this->tempCourseTable);
        $searchBox = $TableSearchBox->generalSearchBox('/timetable/selectionSearch');
        return [
            'template' => 'selectCourse.html.php',
            'title' => $title,
            'variables' => [
                'courses' => $courses,
                'errors' => $errors,
                'searchBox' => $searchBox
            ]
        ];
    }

    public function selectionSearch() {
        $title = "Select by Search Course";
        $TableSearchBox = new \RWCSY2028\TableSearchBox($this->tempCourseTable);
        $searchBox = $TableSearchBox->generalSearchBox('/timetable/selectionSearch');

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
            'template' => 'selectsearchCourse.html.php',
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

    private function generateRooms() {
        $this->rooms = $this->roomsTable->findAll();
        $roomDetails = [];

        foreach($this->rooms as $room) {
            $roomDetails[$room->name] = $room;
        }
        $this->roomDetails  = $roomDetails;
    }

    public function view($timetable = []) {
        $title = 'View Timetable';
        $course['title'] = "Software Engineering";
        if(isset($_GET['id'])) {
            $results = $this->timetableTable->find('id', $_GET['id']);
            //prevent errors from 0 results i.e search for invalid id
            if(isset($results[0])) {
                $timetableObject = $results[0];
                $timetable = $this->recreateTimetableArray($timetableObject->id);
                $course = $this->tempCourseTable->find('id',$timetableObject->course_id)[0];
                $t_id = $_GET['id'];
            }
            else {
                $timetable = false;
                $t_id = false;
            }
        }
        else {
            //this should really route
            $t_id = false;
            $timetable = false;
        }
        
        return [
            'template' => 'viewtimetable.html.php',
            'title' => $title,
            'variables' => [
                'course' => $course,
                'days' =>$this->days,
                'timeslots' => $this->timeslots,
                'timetable' => $timetable,
                't_id' => $t_id
            ]
        ];
    }

    public function create($errors = []) {
        $title = "Create Timetable";
        if(isset($_POST['course'])) {
            $course = $this->tempCourseTable->find('id',$_POST['course']['id'])[0];
        }
        else if(isset($_GET['id'])) {
            $t_id = $_GET['id'];
        }
        else {
            header('location: /timetable/select');
        }
        //the reality is this would be more complicated then this
        //$optionModules = ["","C1001", "C1002", "C1003", "C1004", "C1005", "C1006"];
        $optionRooms = [""];

        foreach($this->rooms as $room) {
            $optionRooms[] = $room->name; 
        }
        if(isset($_POST['timetable'])) {
            $timetable = $_POST['timetable'];
            $this->simplifyArray($timetable);
            $t_id = $_POST['t_id'];
            //errors test + save to tables
            //$errors[] = 'placeholder';
            
            if(sizeof($errors) == 0) {
                
                //whats the logic here

                //first create a timetable reference i.e. tid map course id to that along with date?
                $savedtimetable['id'] = $_POST['t_id'];
                $savedtimetable['course_id'] = $course->id;
                //date format Y-m-d
                $savedtimetable['date'] = Date('Y-m-d');
                $this->timetableTable->save($savedtimetable);
                //then get that reference either through get id set or query for most recent id through SELECT * FROM timetable WHERE (select max(id) FROM timetable WHERE course = course) or etc
                if(isset($t_id) && $t_id != '') {
                    //if something is being updated remove previous ref
                    //im sure there is a better way to do this without deleting all ref
                    $this->timetable_slotsTable->deleteWhere('timetable_id', $t_id, 12);
                }
                else {
                    $latestresult = $this->timetableTable->findLatestRecord();
                    $t_id = $latestresult['id'];
                }
                //then use that reference to insert into another table that maps time table id to module, room, day and timeslot
                //build each mapping from time table array then save each in turn
                //to update the mappings i can either create an array to update each in turn or delete all ref to tid then recreate
                $mapping['id'] = '';
                $mapping['timetable_id'] = $t_id;
                foreach($timetable as $daykey => $day) {
                    $mapping['day'] = $daykey;
                    foreach($day as $tkey => $timeslot) {
                        $mapping['timeslot'] = $tkey;
                        $mapping['module_code'] = $timeslot['module'];
                        $mapping['room'] = $timeslot['room'];
                        //save
                        $this->timetable_slotsTable->save($mapping);
                    }
            }
                //then ultimately route user to view page setting the get id to tid
                header('location: /timetable/view?id='.$t_id);
            }

        }
        else if (isset($_GET['id'])) {
            //find tid and find all matching mappings, rebuild array
            $results = $this->timetableTable->find('id', $_GET['id']);
            //prevent errors from 0 results i.e search for invalid id
            $t_id = $_GET['id'];
            if(isset($results[0])) {
                $timetableObject = $results[0];
                $timetable = $this->recreateTimetableArray($timetableObject->id);
                $course = $this->tempCourseTable->find('id',$timetableObject->course_id)[0];
            }
            else {
                $timetable = false;
            }

        }
        else {
            $timetable = false;
            $t_id = '';
        }
        //var_dump($t_id);
        $optionModules[] = '';
        for ($i = 1; $i < 7; $i++) {
            $methodString = 'module_'.$i;
            if(isset($course->$methodString) && $course->$methodString != '') {
                $optionModules[] = $course->$methodString;
            }
        }
        return [
            'template' => 'timetable.html.php',
            'title' => $title,
            'variables' => [
                'timetable' => $timetable,
                'optionModules' => $optionModules,
                'optionRooms' => $optionRooms,
                'days' => $this->days,
                'timeslots' => $this->timeslots,
                'errors' => $errors,
                'course' => $course,
                't_id' => $t_id
            ]
        ];
    }

    //you can pass by reference in php who knew
    private function simplifyArray(&$array) {
        //var_dump($array);
        foreach($array as $ak => $days) {
            foreach($days as $key =>$times) {
                if(isset($times['module']) && isset($times['room'])){
                    if ($times['module'] == '' && $times['room'] == '') {
                        unset($array[$ak][$key]);
                    }
                    else if ($times['room'] == '') {
                        unset($array[$ak][$key]['room']);
                    }
                    else if ($times['module'] == '') {
                        unset($array[$ak][$key]['module']);
                    }
                }
            }
        }
        return $array;


    }
    private function recreateTimetableArray($id) {
        $mappings = $this->timetable_slotsTable->find('timetable_id', $id);
        $timetable = [];
        foreach($mappings as $mapping) {
            $temp['room'] = $mapping->room;
            $temp['module'] = $mapping->module_code;
            $timetable[$mapping->day][$mapping->timeslot] = $temp; 

        }
        //$timetable = false;
        return $timetable;
    }

    //page needs to function better, should search course table for name/year etc return id and then include that in the $search term
    public function results() {
        $title = "Search Results";
        $tableSearchBox = new \RWCSY2028\TableSearchBox($this->timetableTable);
        $searchBox = $tableSearchBox->generalSearchBox();
        
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
            
            $heading = "Timetable Search Results";
            
        }
        else {
            $title = "Select Results";
            $heading = "Displaying All Timetables";
            
            $search = '';
            //var_dump($generalResults);

            //$results = $this->tableSearchBox->getSearchResults($_GET['field'], $search, $limit);
        }
        $generalResults = $tableSearchBox->getGeneralSearchResults($search,$limit);
        $totalSearchResults = sizeof($tableSearchBox->getGeneralSearchResults($search));
        $pageNext = $tableSearchBox->paginationNext($pageno, $totalSearchResults, $resultsperpage);
        $pagePrevious = $tableSearchBox->paginationPrevious($pageno);
        $results = $generalResults;

        foreach ($results as $result) {
            $course = $this->tempCourseTable->find('id', $result->course_id)[0];
            $result->course = $course;
        }
        return [
            'template' => 'timetableresults.html.php',
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
                'pagePrevious' => $pagePrevious
            ]
        ];
    }
}