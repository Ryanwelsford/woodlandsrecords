<?php
namespace Diary\Controllers;

class Diary {
    private $diariesTable;
    private $appointmentsTable;
    private $get;
    private $post;
    private $tableSearchBox;

    //basic class constructor, creates a table search box class for use througout controller due to only one being required 
    public function __construct($diariesTable, $appointmentsTable, $get, $post) {
        $this->diariesTable = $diariesTable;
        $this->appointmentsTable = $appointmentsTable;
        $this->get = $get;
        $this->post = $post;
        $this->tableSearchBox = $TableSearchBox = new \RWCSY2028\TableSearchBox($this->appointmentsTable,['diary_id']);
    }

    //purpose is to display the calendar style element in table format and allow user a visual input
    public function view() {
        $title = 'View Diary';
        // ref https://codingwithsara.com/how-to-code-calendar-in-php/
        date_default_timezone_set('Europe/London');
        if(isset($_GET['yearMonth'])) {
            // if links clicked get those dates or from results page
            //need to validate the date
            $yearMonth = $_GET['yearMonth'];
        }
        else {
            // sets date = to today
            $yearMonth = date("Y-m");
        }
        $a = strtotime($yearMonth);
        $diarytitle = date('Y-M', $a);

        // if you dont use timestamp like this is doesnt work properly with time() for some reason
        $timestamp = strtotime($yearMonth . '-01');
        if ($timestamp === false) {
            $yearMonth = date('Y-m');
            $timestamp = strtotime($yearMonth . '-01');
        }
        // todays date
        $today = date('Y-m-d', time());

        // prev and next month dates
        $thisMonth = $yearMonth;
        $prev = date("Y-m", strtotime( date( "Y-M-d", strtotime( $thisMonth ) ) . "-1 month" ) );
        $next = date("Y-m", strtotime( date( "Y-M-d", strtotime( $thisMonth ) ) . "+1 month" ) );

        $dayCount = date('t', $timestamp);
        //0 is sunday 1 is monday etc
        $str = date('w', $timestamp);


        $weeks = array();
        $week = '';
        $week .= str_repeat('<td></td>', $str);
        $test = date('2020-03-11');

        if(isset($_SESSION['id'])) {
            $diary_id = $_SESSION['id'];
        }
        else {
            $diary_id = 1;
        }
        //pull appointments from this month, start to finish
        $startmonth = $yearMonth."-01";
        $endmonth = $yearMonth."-".$dayCount;
        $order = ['date', 'start_time'];
        //this should in theory also have an id passed to it aswell, the diary id associated with the logged user
        $appointments = $this->appointmentsTable->findBetweenOrdered('date', $startmonth, $endmonth, $order);

        //reorder appointments into an array with the date as the key
        $appointments = $this->reorderArray($appointments);
        // you can use strtotime to format to convert strings from date objects into unicode time stamps
        // you then pass this to a new date with a different format like so with the timestamp being a second parameter 
        // $old = date('Y-m');
        // $timestamp = strtotime($old);
        // $new = date('y-m-d', $timestamp);
        // create an appointment class with a function that aproduces the <a><ul>etc</ul></a> then loop through 
        // type, id start and end times description would all be attributes of appointment along with the link it would follow. i.e. would be createAppointment etc etc
        for ( $day = 1; $day <= $dayCount; $day++, $str++) {
            
            //prevents errors with posting dates
            if($day < 10) {
                $date = $yearMonth . '-0' . $day;
            }
            else {
                $date = $yearMonth . '-' . $day;
            }
            //day anchor used to have unique links on each clickable td element corresponding to the date of said element
            $dayanchor = '<a href="/diary/create?date='.$date.'">'.$day.'</a>';

            //display today in unique style
            if ($today == $date) {
                $week .= '<td class="diary-today">';
            } 
            else {
                $week .= '<td>';
            }
            //if set in appointments array add to diary 
            if(isset($appointments[$date])) {
                //var_dump($appointments[$date]);
                $week .= $this->loadTemplateInternal('../templates/diaryappointment.html.php', ['appointments'=> $appointments[$date]]);
            }
            // this would be where the appointments loop would be, the appointments array would be created from a group of appointment objects, these would be made from the info pulled from the appointments table.
            $week .= $dayanchor.'</td>';
            
            // End of the week OR End of the month
            if ($str % 7 == 6 || $day == $dayCount) {

                if ($day == $dayCount) {
                    // Add empty cell
                    $week .= str_repeat('<td></td>', 6 - ($str % 7));
                }

                $weeks[] = '<tr>' . $week . '</tr>';

                // Prepare for new week
                $week = '';
            }

        }
        return [
            'template' => 'diary.html.php',
            'title' => $title,
            'variables' => [
                'weeks' => $weeks,
                'diarytitle' => $diarytitle,
                'prev' => $prev,
                'next' => $next
            ]
        ];
    }
    //https://www.php.net/manual/en/function.checkdate.php
    //glavic at gmail dot com
    //used to ensure a valid date is passed to form
    private function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    //reorder an array to have passed element set as key
    private function reorderArray($appointments) {
        $array = [];
        foreach($appointments as $appointment){
            $array[$appointment['date']][] = $appointment;
        }
        return $array;
    }

    //used to create appointments and edit
    public function create($errors = []) {
        $title = "Add an Appointment";
        if (isset($this->post['appointment'])) {
            $appointment = (object) $this->post['appointment'];
            $errors = $this->appointmentErrors($appointment);
        }
        //edit form
        else if(isset($this->get['id'])) {
            $app1 = $this->appointmentsTable->find('id',$this->get['id']);
            //if record found
            if(isset($app1[0])) {
                $appointment = $app1[0];
            }
            //if record not found, manipulated get variable
            else {
                $appointment = false;
            }
        }
        //if sent to form from diary table, validate date and set form date to passed
        else if (isset($this->get['date']) && $this->validateDate($this->get['date'], "Y-m-d")) {
            $appointment['date'] = $this->get['date'];
            $appointment = (object) $appointment;
        }
        //otherwise set appointment to false
        else {
            $appointment = false;
        }

        //if submitted and 0 errors
        if(isset($this->post['appointment']) && sizeof($errors) == 0) {
            //set appointment for current user
            if(isset($_SESSION['id'])) {
                //should actually be a query for diary id based on user id passed
                $diary_id = $_SESSION['id'];
            }
            //if not logged ( used for testing)
            else {
                $diary_id = 1;
            }
            //add user id to appointment info
            $this->post['appointment']['diary_id'] = $diary_id;

            $this->appointmentsTable->save($this->post['appointment']);

            //build header function to send to appropriate date location
            $yearMonth = $this->post['appointment']['date'];
            //remove the day from date string
            $this->rerouteDate($yearMonth);
        }
        else {
            return [
                'template' => 'appointmentform.html.php',
                'title' => $title,
                'variables' => 
                [ 
                    'errors' => $errors,
                    'appointment' => $appointment
                ]
            ];
        }
    }
    public function checkPageno() {
        if(!isset($_GET['pageno'])) {
            return false;
        }
        $pageno = $_GET['pageno'];
        if(!is_int($pageno)) {
            return false;
        } 
        else {
            return true;
        }
    }

    //used as a search entry and results page, uses tablesearchbox class 
    public function results() {
        $title = "Search Results";
        $searchBox = $this->tableSearchBox->generalSearchBox();
        
        //find which page is required for search
        if(isset($_GET['pageno']) && $_GET['pageno'] > 1) {
            $pageno = $_GET['pageno'];
        }
        else {
            $pageno = 1;
        }
        //set up limits for page display, quantity of results per page
        $resultsperpage = 5;
        $limit['offset'] = ($pageno-1)*$resultsperpage;
        $limit['total'] = $resultsperpage;
        
        if(isset($_GET['search']) && isset($_GET['pageno']) && $_GET['pageno'] != '') {
            $search = $_GET['search'];
            $search = strtolower(str_replace('/', '-', $search));
            $dateOptions = explode('-',$search);
            //attempt to validate date, if date appears to be in date format re format into date within table else continue as not date
            if(sizeof($dateOptions) == 3) {
                try {
                    $date = new \DateTime($search);
                    $search = $date->format('Y-m-d');
                }
                catch (\Exception $e) {
                    $search = $_GET['search'];
                }
            }
            
            $heading = "Search Results";
            
            //get results of search with pagenation
            $generalResults = $this->tableSearchBox->getGeneralSearchResults($search,$limit);
            //var_dump($generalResults);
            //$results = $this->tableSearchBox->getSearchResults($_GET['field'], $search, $limit);

            $results = $generalResults;
            
        }
        else {
            $heading = "Displaying All Appointments";
            //if search is not entered, i.e. on first entry to page display all 
            $search = '';
            //var_dump($generalResults);

            //$results = $this->tableSearchBox->getSearchResults($_GET['field'], $search, $limit);
        }
        //results array would in theory be the results of query of searchbox.
        //create results and set total size of result page
        $generalResults = $this->tableSearchBox->getGeneralSearchResults($search,$limit);
        $totalSearchResults = sizeof($this->tableSearchBox->getGeneralSearchResults($search));
        
        //create instance of pagination buttons
        $pageNext = $this->tableSearchBox->paginationNext($pageno, $totalSearchResults, $resultsperpage);
        $pagePrevious = $this->tableSearchBox->paginationPrevious($pageno);
        $results = $generalResults;

        return [
            'template' => 'diaryresults.html.php',
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

    //used to reroute to view page based on date, i.e. if created appointment then send user to diary view of the page
    private function rerouteDate($date) {
        $yearMonth = substr($date,0,-3);
        $headerstring = "location: /diary/view?yearMonth=".$yearMonth;
        header($headerstring);
    }


    //prevent errors based on start times and details
    public function appointmentErrors($appointment) {
        $errors = [];
        if($appointment->start_time > $appointment->end_time) {
            $errors[] = "Appointment start time must be before end time";
        }
        if($appointment->details == '' || $appointment->details == ' ') {
            $errors[] = "Appointment details must be completed";
        }
        //could add a clashing appointment aspect also
        return $errors;
    }

    //remove appointment
    public function delete() {
        if(isset($this->post['appointment'])) {
            var_dump($this->post['appointment']);
            $this->appointmentsTable->delete($this->post['appointment']['id']);
            $this->rerouteDate($this->post['appointment']['date']);
        }
        
    }

    //setup an array of variables and build them into a template file, returns a html page with variables built into it
    private function loadTemplateInternal($fileName, $templateVars) {
        extract($templateVars);
        ob_start();
        require $fileName;
        $contents = ob_get_clean();
        return $contents;
    }
}

?>