<?php
foreach ($students as $student) {
?>
<article class = "table-container fit-table">
<h2><?=$heading;?></h2><br>
    <p class="bold-text">Student: <?=$student->studentid . " ". $student->firstname. " " . $student->surname ?? "Student Not Found"?></p>

    <article class="search-results-container">
        <table class="search-results-table">
            <tr>
                <th>Module Code</th>
                <th>Attendance Percentage</th>
            </tr>
            <?php
            if(sizeof($student->module) == 0 ) {
                ?>
                </table>
                <p>No Student Attendance Information Found</p>
                <?php
            }
            else {
                foreach($student->module as $key=>$module) {
                    //round to 2 dp
                    $modAttendance = round(($module['attended']/$module['total'])*100, 2);
                    $class = "centered";
                    if($modAttendance < 50) {
                        $class .= " poor-attendance";
                    }
                    ?>
                    <tr>
                        <td class="<?=$class;?>"><?=$key;?></td>
                        <td class="<?=$class;?>"><?=$modAttendance;?>%</td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <th>Total Attendance</th>
                <th><?=$student->percentageAttended;?>%</th>
            </tr>
        </table>

        
    </article>
</article>
<?php
}
?>

