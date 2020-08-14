<article class = "table-container">
    <h2><?=$heading;?></h2>
    <p>Displaying all unactioned students with 2 or more lectures missed</p>
    <p>Displaying <?=sizeof($results);?> students</p>
    <article class="search-results-container">
        <?php?>
        
                <table class="search-results-table">
                            <tr>
                                <th>Student Id</th>
                                <th>Student Firstname</th>
                                <th>Student Surname</th>
                                <th>Missed Lectures</th>
                                <th>Links</th>
                            </tr>
                            
                        
                <?php
                foreach($results as $result) {
                    ?>
                    <tr>
                    <td><?=$result['student']->studentid;?></td>
                    <td><?=$result['student']->firstname;?></td>
                    <td><?=$result['student']->surname;?></td>
                    <td class="centered"><?=$result['missed'];?></td>
                    <td>
                        <article class="search-buttons-links">
                        <form method="POST" action="/attendance/action?print=true" target="_blank">
                            <input type="hidden" value="<?=$result['missed'];?>" name="missed">
                            <input type="hidden" value="<?=$result['student']->studentid;?>" name="student">
                            <input class ="search-button search-button-delete" type ="submit" value="Action">
                        </form>
                        <a href="/attendance/monitor/student?sid=<?=$result['student']->studentid;?>"><button class="search-button">Profile</button></a>
                    </td>
                    
                    </article>
                    </article>
                    </tr>
                    <?php
                }
                ?>
                </table>
    </article>
</article>
