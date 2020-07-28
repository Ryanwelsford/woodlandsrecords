<article class = "table-container mid-table-container">
    <h2 class="report-heading"><?=$heading;?></h2>

    <article class="search-results-container">
        <?php
        foreach ($courses as $course) {
            if($course->module_6 != null) {
                $mod6 = true;
            }
            else {
                $mod6 = false;
            }
        ?>
        <p class="report-p-spacer"><?=$course->name." Year ".$course->year;?></p>
        <table class="search-results-table">
            <tr>
                <th>Module 1</th>
                <th>Module 2</th>
                <th>Module 3</th>
                <th>Module 4</th>
                <th>Module 5</th>
                <?php
                if($mod6) {
                    ?>
                <th>Module 6</th>
                <?php
                }
                ?>
            </tr>
            <tr>
                <td><?=$course->module_1;?></td>
                <td><?=$course->module_2;?></td>
                <td><?=$course->module_3;?></td>
                <td><?=$course->module_4;?></td>
                <td><?=$course->module_5;?></td>
                <?php
                if($mod6) {
                    ?>
                <td><?=$course->module_6;?></td>
                <?php
                }
                ?>
            </tr>
        </table>
                <?php
        }
            ?>
        </table>
    </article>
</article>