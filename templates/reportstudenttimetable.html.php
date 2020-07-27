<article class = "table-container">

        <h3>Timetable for <?=$student->name;?></h3>
        <table class= 'timetable-table large-table'>
        <tr><div class = "heading-course">Course: <?=$course->name ?? '';?> - Year <?=$course->year ?? '';?> - Timetable <?=$t_id ?? ''?></div></tr>
        <tr>
            <th>Day</th>
            <th>9-10</th>
            <th>10-11</th>
            <th>11-12</th>
            <th>12-1</th>
            <th>1-2</th>
            <th>2-3</th>
            <th>3-4</th>
            <th>4-5</th>
        </tr>

        <?php
        $moduleArray = [];
        foreach($days as $day) {
            ?>
            <tr>
                <td><?=$day;?></td>
                <?php
                    foreach($timeslots as $timeslot) {
                        ?>
                        
                        <?php
                            if (isset($timetable[$day][$timeslot])) {
                                if(!in_array($timetable[$day][$timeslot]['module'], $moduleArray)) {
                                    $moduleArray[] = $timetable[$day][$timeslot]['module'];
                                    $moduleType = "Lecture";
                                    $timetablepractical = '';
                                }
                                else {
                                    $moduleType = "Practical";
                                    $timetablepractical = 'timetable-practical';
                                }
                                ?>
                                <td class= "timetable-module <?=$timetablepractical;?>">
                                    <div>
                                        <div><?=$timetable[$day][$timeslot]['module'] ?? 'Module Not Set'?></div>
                                        <div><?=$moduleType;?></div>
                                        <div>Timetable <?=$t_id ?? ''?></div>
                                        <div><?=$timetable[$day][$timeslot]['room'] ?? 'Room Not Set'?></div>
                                    </div>
                                

                                <?php
                            }
                            else {
                                echo "<td>";
                            }
                        ?>
                        
                        </td>
                        <?php
                    }
                ?>  
            </tr>
        <?php
        }
        ?>
        </table>
</article>