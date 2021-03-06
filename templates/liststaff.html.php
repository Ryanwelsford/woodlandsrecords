<form action="#" method="GET">
<div class="d-flex justify-content-center h-100">
    <div class="searchbar">
    <input class="search_input" type="text" name="search" placeholder="Search...">
    <input class="sear" type="submit" name="submit" value="Search">
    <!-- <a href="#" class="search_icon"><img src="https://img.icons8.com/material-sharp/24/000000/search.png"/><i class="fas fa-search"></i></a> -->
    </div>
</div>
</form>
<article class = "table-container fit-table">
    <table class="studentamend search-results-table" >
            <tr>
                <th>First name</th>
                <th>Middle name</th>
                <th>Surname</th>
                <th>Staff ID</th>
                <th>Staff Status</th>
                <th>Action</th>
            </tr>
            <?php foreach($stmt as $row) { 
                $class = "search-button";
                if($buttonName == "Amend") {
                    $class .= " search-button-amend";
                }
                else if($buttonName == "Archive") {
                    $class .= " search-button-archive";
                }
                ?>
            <tr>
                <td><?= $row['firstname'] ?></td>
                <td><?= $row['middlename'] ?></td>
                <td><?= $row['surname'] ?></td>
                <td><?= $row['staffid'] ?></td>
                <td><?=$row['staffstatus']?></td>
                <td class="am">
                    <form action="<?=$location?>" method="POST">
                    <input type="hidden" name="id" value=<?= $row['id']?>>
                    <input class="<?=$class;?>" type="submit" name="archive" value="<?=$buttonName?>">
                </form>
            </td>
            </tr>
         <?php   } ?>
        </table>
            </article>