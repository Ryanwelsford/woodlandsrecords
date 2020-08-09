<article class = "table-container">
<h2><?=$heading;?></h2><br>
    <h3>Weekly Register Return</h3>
    <p>Module: <?=$module->name ?? "test"?> Date Created: <?=$date ?? \Date('d-m-y')?></p>

    <article class="search-results-container">
        <table class="search-results-table">
            <tr>
                <th>Student Id</th>
                <th>First Name</th>
                <th>Surname</th>
                <th>Attendance</th>
            </tr>
            <?php
            //var_dump($attendanceRef);
            foreach ($students as $student) {
                $tdclass = 'attended ';
                if($student->attended == 'X' || $student->attended == 'A') {
                    $tdclass .= "not-attended";
                }
                ?>
                <tr>
                <td><?=$student->studentid;?></td>
                <td><?=$student->firstname;?></td>
                <td><?=$student->surname;?></td>
                <td class = "<?=$tdclass;?>"><div><?=$student->attended;?></div></td>
                    <?php
                }
                ?>
            </tr>
            <?php
            
            ?>
            
        </table>
    </article>
</article>
