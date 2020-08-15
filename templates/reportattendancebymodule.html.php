
<article class = "table-container fit-table">
<h2><?=$heading;?></h2><br>

    <article class="search-results-container">
        <table class="search-results-table">
            <tr>
                <th>Module Code</th>
                <th>Attendance Percentage</th>
            </tr>
            <?php

            foreach ($moduleWithCount as $key => $each) {
                    $modAttendance = round(($each['attended']/$each['total'])*100, 2);
                    $class = "centered";
                    if($modAttendance <= 50) {
                        $class .= " poor-attendance";
                    }
                    else if ($modAttendance >= 80) {
                        $class .= " good-attendance";
                    }
                ?>

                <tr>
                    <td class="<?=$class;?>" ><?=$key;?></td>
                    <td class="<?=$class;?>" ><?=$modAttendance;?>%</td>
                </tr>
                <?php
            }
           ?>
        </table>

        
    </article>
</article>

