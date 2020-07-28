<article class = "table-container mid-table-container">
    <h2 class="report-heading"><?=$heading;?></h2>

    <article class="search-results-container">
        <table class="search-results-table">
            <tr>
                <th>Student Id</th>
                <th>Student Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
            </tr>
            <?php
            foreach($students as $student) {
                //var_dump($student);
                ?>
                <tr>
                    <td><?=$student->studentid;?></td>
                    <td><?=$student->firstname." ".$student->surname;?></td>
                    <td><?=$student->email;?></td>
                    <td><?=$student->phonenum;?></td>
                    <td class="report-address-td"><?=$student->termaddress;?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </article>
</article>