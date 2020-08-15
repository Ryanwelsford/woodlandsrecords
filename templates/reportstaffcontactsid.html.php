<article class = "table-container mid-table-container">
    <h2 class="report-heading"><?=$heading;?></h2>

    <article class="search-results-container">
        <table class="search-results-table">
            <tr>
                <th>Staff Id</th>
                <th>Staff Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th class="report-address-td">Address</th>
            </tr>
            <?php
            foreach($staff as $single) {
                //var_dump($single);
                ?>
                <tr>
                    <td><?=$single->staffid;?></td>
                    <td><?=$single->surname.", ".$single->firstname;?></td>
                    <td><?=$single->email;?></td>
                    <td><?=$single->phonenumber;?></td>
                    <td class="report-address-td"><?=$single->address;?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </article>
</article>