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
private $archived_slotsTable;
private $archived_timetableTable;
private $autoDays;

    public function __construct($timetableTable, $timetable_slotsTable, $tempCourseTable,$roomsTable, $archived_timetableTable, $archived_slotsTable) {
        $this->timetableTable = $timetableTable;
        $this->timetable_slotsTable = $timetable_slotsTable;
        $this->tempCourseTable = $tempCourseTable;
        $this->roomsTable = $roomsTable;
        $this->archived_timetableTable = $archived_timetableTable;
        $this->archived_slotsTable = $archived_slotsTable;

        $this->generateRooms();
        $this->days =
        [
            "Monday" => "Mon",
            "Tuesday" => "Tue",
            "Wednesday" => "Wed",
            "Thursday" => "Thu",
            "Friday" => "Fri"
        ];
        
        $this->autoDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
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
        //only do this if submit button is pressed
        if(isset($_POST['timetable']) && isset($_POST['Submit'])) {
            $timetable = $_POST['timetable'];
            $this->simplifyArray($timetable);
            $t_id = $_POST['t_id'];
            //errors test + save to tables
            //$errors['Mon 9-11'] = 'Room in use';
            $errors = $this->timetableErrors($timetable, $course);
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
        else if (isset($_POST['Automate'])) {
            echo 'TEst';
            $timetable = $_POST['timetable'];
            $this->simplifyArray($timetable);
            $t_id = $_POST['t_id'];

            $timetable = $this->automate($timetable, $course);
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
        $courseSearchBox = new \RWCSY2028\TableSearchBox($this->tempCourseTable);
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
        //pull course information based on search term, add that to the search term for timetable searches 
        $courseResults = $courseSearchBox->getGeneralSearchResults($search);
        foreach($courseResults as $course) {
            $search .= " ".$course->id;
        }

        $generalResults = $tableSearchBox->getGeneralSearchResults($search,$limit);
        $totalSearchResults = sizeof($tableSearchBox->getGeneralSearchResults($search));
        $pageNext = $tableSearchBox->paginationNext($pageno, $totalSearchResults, $resultsperpage);
        $pagePrevious = $tableSearchBox->paginationPrevious($pageno);
        $results = $generalResults;

        //map course to timetable result
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
                'pagePrevious' => $pagePrevious,
            ]
        ];
    }

    public function archiveResults() {
        $pageDetails = $this->results();
        $pageDetails['template'] = 'timetablearchiveresults.html.php';

        return $pageDetails;
    }

    public function archiveSearch() {
        $title = "Archive Search Results";
        $courseSearchBox = new \RWCSY2028\TableSearchBox($this->tempCourseTable);
        //would need to change to archived table
        $tableSearchBox = new \RWCSY2028\TableSearchBox($this->archived_timetableTable);
        $searchBox = $tableSearchBox->generalSearchBox('/timetable/archive/results');
        
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
            
            $heading = "Archived Timetable Search Results";
            
        }
        else {
            $title = "Select Results";
            $heading = "Displaying All Archived Timetables";
            //display all results
            $search = '';
        }
        //pull course information based on search term, add that to the search term for timetable searches 
        $courseResults = $courseSearchBox->getGeneralSearchResults($search);
        foreach($courseResults as $course) {
            $search .= " ".$course->id;
        }

        $generalResults = $tableSearchBox->getGeneralSearchResults($search,$limit);
        $totalSearchResults = sizeof($tableSearchBox->getGeneralSearchResults($search));
        $pageNext = $tableSearchBox->paginationNext($pageno, $totalSearchResults, $resultsperpage);
        $pagePrevious = $tableSearchBox->paginationPrevious($pageno);
        $results = $generalResults;

        //map course to timetable result
        foreach ($results as $result) {
            $course = $this->tempCourseTable->find('id', $result->course_id)[0];
            $result->course = $course;
        }
        return [
            'template' => 'archivedtimetable.html.php',
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

    //based on passed post id remove mappings and timetable reference from standard tables and add to archived tables
    public function store() {
        if(isset($_POST['timetable'])) {
            $id = $_POST['timetable']['id'];
            $timetable = $this->timetableTable->find('id', $id)[0];
            //find timetable mappings
            $mappings = $this->timetable_slotsTable->find('timetable_id', $id);
            //add to archives
            $this->archived_timetableTable->saveObject($timetable);
            foreach($mappings as $mapping) {
                $this->archived_slotsTable->saveObject($mapping);
            }
            //remove from standard
            $this->timetableTable->delete($id);
            $this->timetable_slotsTable->deleteWhere('timetable_id', $id);
            header('location: /timetable/results');
        }
    }

    //inverse of store, move stored items back to active tables
    public function restore() {
        if(isset($_POST['timetable'])) {
            $id = $_POST['timetable']['id'];
            $timetable = $this->archived_timetableTable->find('id', $id)[0];
            
            //find timetable mappings
            $mappings = $this->archived_slotsTable->find('timetable_id', $id);
            
            //add to standard
            $this->timetableTable->saveObject($timetable);
            foreach($mappings as $mapping) {
                $this->timetable_slotsTable->saveObject($mapping);
            }
            //remove from archives
            $this->archived_timetableTable->delete($id);
            $this->archived_slotsTable->deleteWhere('timetable_id', $id);
            header('location: /timetable/archive/results');
        }
    }

    public function delete() {
        if(isset($_POST['timetable'])) {
            $timetable = $_POST['timetable'];
            //remove all mappings relating to timetable
            $this->timetable_slotsTable->deleteWhere('timetable_id', $timetable['id'], 12);
            //remove timetable reference
            $this->timetableTable->delete($timetable['id']);
            header('location: /timetable/results');
        }
    }

    public function automate($timetable = [], $course = false) {
        //establish list of modules, each should be input twice, once for lecture once for practical
        $course_mods = [];
        //so i need to pull the current info from $timetable array to establish modules that are already used. 
        $already_applied_mods = [];
        foreach($timetable as $day) {
            foreach($day as $timeslot) {
                if(isset($timeslot['module'])) {
                    $already_applied_mods[] = $timeslot['module'];
                }
            }
        }
        //var_dump($already_applied_mods);
        //this is the ideal modules in play 
        for ($i = 1; $i < 7; $i++) {
            $methodString = 'module_'.$i;
            if(isset($course->$methodString) && $course->$methodString != '') {
                $course_mods[] = $course->$methodString;
                $course_mods[] = $course->$methodString;
            }
        }
        //so the difference between the two is the modules still to be completed 
        foreach($already_applied_mods as $mod) {
            if(in_array($mod, $course_mods)) {
                array_splice($course_mods, array_search($mod, $course_mods), 1);
            }
        }
        //var_dump($course_mods);
        $timetableArray = $this->generateTimetable($course_mods, $timetable); 
        $timetable = [];
        //reorganise array in order of day and timeslot
        foreach ($this->days as $key => $day) {
            if(isset($timetableArray[$day])) {
                foreach ($this->timeslots as $tskey => $timeslot) {
                    if(isset($timetableArray[$day][$timeslot])) {
                        $timetable[$day][$timeslot] = $timetableArray[$day][$timeslot];
                    }
                }
            }
        }
        $this->updateRooms($timetable, $already_applied_mods);

        //at this point we have a structure that matches the other timetable structures
        //var_dump($timetable);
        return $timetable;
    }

    function randomComboLecture(&$day, &$slot) {
        $randomDay = rand(0, sizeof($this->autoDays)-1);
        $day = $this->autoDays[$randomDay];

        $randomSlot = rand(0, sizeof($this->timeslots)-1);
        $slot = $this->timeslots[$randomSlot];

    }

    function randomRoom(&$room, $x, $y) {
        $randomRoom = rand($x,$y);
        $room = $this->rooms[$randomRoom]->name;
    }

    function generateTimetable($course_mods, $timetableArray) {
        foreach($course_mods as $mod) {
            //pick day
            $day;
            $slot;
            //generate combo, if already set regenerate
            $this->randomComboLecture($day, $slot);
            while(isset($timetableArray[$day][$slot])) {
                $this->randomComboLecture($day, $slot);
            }
            
            if(!isset($timetableArray[$day][$slot])) {
                //only add if unique slot/day combo
                $timetableArray[$day][$slot] = [
                'module' => $mod
                ];
            }
            
        }
        return $timetableArray;
    }

    function updateRooms(&$timetableArray, $moduleTrack = []) {
        $room;
        //this is overly complicated for no good reason
        foreach ($this->days as $key => $day) {
            if(isset($timetableArray[$day])) {
                foreach ($this->timeslots as $tskey => $timeslot) {
                    if(isset($timetableArray[$day][$timeslot])) {
                        if(!isset($timetableArray[$day][$timeslot]['room'])) {
                            if(!in_array($timetableArray[$day][$timeslot]['module'], $moduleTrack)) {
                                $moduleTrack[] = $timetableArray[$day][$timeslot]['module'];
                                $this->randomRoom($room, 0, 3);
                            }
                            else {
                                $this->randomRoom($room, 4, sizeof($this->rooms)-1);
                            }

                            $timetableArray[$day][$timeslot]['room'] = $room;
                        }
                    }
                }
            }
        }
        
    }

    function timetableErrors($timetable, $course) {
        //errors to complete, room in use error although that would require changes to automation of rooms method
        //establish count and correct number of each module
        if($course->year == 3) {
            $idealModuleCount = 10;
        }
        else {
            $idealModuleCount = 12;
        }
        //count all modules in use
        $modCount = 0;
        $modulesInUse = [];
        $countOccurenceModule = [];
        foreach($timetable as $dayKey => $day) {
            foreach ($day as $timeKey => $timeslot) {
                if(isset($timeslot['module'])) {
                    //count total modules
                    $modCount++;
                    $modulesInUse[] = $timeslot['module'];

                    //set up counter for each module in turn
                    if(!isset($countOccurenceModule[$timeslot['module']])) {
                        $countOccurenceModule[$timeslot['module']] = 1;
                    }
                    else {
                        //if element exists in array increase count by one
                        $countOccurenceModule[$timeslot['module']] = $countOccurenceModule[$timeslot['module']]+1;
                    }

                }
                //module selected but room not selected 
                if(isset($timeslot['module']) && !isset($timeslot['room'])) {
                    $errors[$dayKey." ".$timeKey] = "Room not set";
                }
                //room selected without a module
                if(isset($timeslot['room']) && !isset($timeslot['module'])) {
                    $errors[$dayKey." ".$timeKey] = "Module not set";
                }
            }
        }
        //display error for incorrect total module count
        if($modCount != $idealModuleCount) {
            $errors['Incorrect Module Number'] = "Courses of year ".$course->year. " should contain ".$idealModuleCount." Modules";
        }
        //display error for incorrect occurence of each module
        foreach($countOccurenceModule as $key =>$mod) {
            if($mod != 2) {
                $errors['Module Counter '.$key] = "Incorrect quantity of ".$key." 2 required ".$mod. " found";
            }
        }

        return $errors;
    }
}