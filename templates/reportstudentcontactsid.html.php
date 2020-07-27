<article class = "table-container">
    <h2><?=$heading;?></h2>

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
                ?>
                <tr>
                    <td><?=$student->id;?></td>
                    <td><?=$student->firstname." ".$student->surname;?></td>
                    <td><?=$student->email;?></td>
                    <td><?=$student->phonenum;?></td>
                    <td><?=$student->termaddress;?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </article>
</article>