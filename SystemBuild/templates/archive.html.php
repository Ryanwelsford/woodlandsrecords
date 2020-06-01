<form action="#" method="GET">
<div class="d-flex justify-content-center">
    <div class="searchbar">
    <input class="search_input" type="text" name="search" placeholder="Search...">
    <input class="sear" type="submit" name="submit" value="Search">
    <!-- <a href="#" class="search_icon"><img src="https://img.icons8.com/material-sharp/24/000000/search.png"/><i class="fas fa-search"></i></a> -->
    </div>
</div>
</form>
<table class="studentamend" style="width:100%">
            <tr>
                <th>First name</th>
                <th>Middle name</th>
                <th>Surname</th>
                <th>Student ID</th>
                <th>Student Status</th>
                <th>Action</th>
            </tr>
            <?php foreach($stmt as $row) { ?>
            <tr>
                <td><?= $row['firstname'] ?></td>
                <td><?= $row['middlename'] ?></td>
                <td><?= $row['surname'] ?></td>
                <td><?= $row['studentid'] ?></td>
                <td><?= $row['studentstatus'] ?></td>
                <td class="am">
                    <form action="#" method="POST">
                    <input type="hidden" name="id" value=<?= $row['studentid']?>>
                    <input type="submit" name="archive" value="Archive">
                </form>
            </td>
            </tr>
         <?php   } ?>
        </table>