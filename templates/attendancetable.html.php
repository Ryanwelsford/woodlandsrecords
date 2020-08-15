<article class = "table-container">
    <h2>Weekly Register Return</h2>
    <p>Module: <?=$module->name ?? "test"?> Date Created: <?=$date ?? \Date('d-m-y')?></p>

    <article class="search-results-container">
    <form method="POST" action="/attendance/create">
    <input type="hidden" value="<?=$date;?>" name="date">
    <input type="hidden" value="<?=$module->id;?>" name="module">
    <input type="hidden" value="<?=$attendanceRef ?? ''?>" name="attendanceRef">
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
                ?>
                <tr>
                <td><?=$student->studentid;?></td>
                <td><?=$student->firstname;?></td>
                <td><?=$student->surname;?></td>
                <td>
                <input type="hidden" name = "attendance[<?=$student->studentid;?>][id]" value="<?=$student->attendance ?? '' ?>">
                <?php
                if(isset($student->attended)) {
                    //var_dump($student);
                    ?>
                    <select name = "attendance[<?=$student->studentid;?>][attended]">

                    <?php
                    $options = ["O", "X", "A"];
                    foreach($options as $option) {
                        $selected = '';
                        if ($option == $student->attended) {
                            
                            $selected = 'selected';
                        }
                        ?>
                        <option value="<?=$option;?>" <?=$selected;?> ><?=$option;?></option>
                        <?php
                    }
                    ?>
                    </select>

                    <?php
                }
                else {
                    ?>
                    <select name = "attendance[<?=$student->studentid;?>][attended]">
                        <option value="O">O</option>
                        <option value="X">X</option>
                        <option value="A">A</option>
                    </select>

                    <?php
                }
                ?>
                </td>
            </tr>
            <?php
            }
            ?>
            
        </table>
        <div class="submit-hold">
            <input type="submit" value="Save Attendance">
        </div>
    </form>
    </article>
</article>
