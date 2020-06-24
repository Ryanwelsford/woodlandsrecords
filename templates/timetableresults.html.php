<article class = "table-container">
    <h2><?=$heading;?></h2>

    <div class ="left-search"><?=$searchBox;?></div>
    <article class="search-results-container">
        <?php
        if(isset($_GET['search']) || !isset($_GET['search'])) {
            if($totalSearchResults == 0) {
                ?>
                <p>No Results found try redefining your search</p>
                <p>For the best results dates should be entered in dd-mm-yyyy format</p>
                <?php
            }
            else {
                //could add in pagenation stuff here
                if(sizeof($results) == 1) {
                    $resultWord = 'Result';
                }
                else {
                    $resultWord = 'Results';
                }
                ?>
                <p>Displaying <?=sizeof($results);?> of <?=$totalSearchResults;?> <?=$resultWord;?></p>
                <table class="search-results-table">
                            <tr>
                                <th>Id</th>
                                <th>Course Name</th>
                                <th>Course Year</th>
                                <th>Date Created</th>
                                <th>Links</th>
                            </tr>
                            
                        
                <?php
                foreach($results as $result) {
                    ?>
                    <tr>
                    <?php
                    
                ?>
                    <td><?=$result->id;?></td>
                    <td><?=$result->course->name;?></td>
                    <td><?=$result->course->year;?></td>
                    <td><?=$result->date;?></td>
                    <td>
                        <article class="search-buttons-links">
                        <form method="POST" action="/timetable/create?id=<?=$result->id;?>">
                            <input type="hidden" value="<?=$result->course_id;?>" name="course[id]">
                            <input class ="search-button search-button-amend" type ="submit" value="Amend">
                        </form>
                        <a href="/timetable/view?id=<?=$result->id;?>"><button class="search-button">View</button></a>
                        <form method="POST" action="/diary/delete">
                            <input type="hidden" value="<?=$result->id;?>" name="appointment[id]">
                            <input type="hidden" value="<?=$result->date;?>" name="appointment[date]">
                            <input class ="search-button search-button-delete" type ="submit" value="Delete">
                        </form>
                    </td>
                    
                    </article>
                    </article>
                    </tr>
                    <?php
                }
                ?>
                </table>
                <div class= "pagenation-holder">
                    <?=$pagePrevious;?>
                    <?=$pageNext;?>
                </div>
                <?php
            }
        }
        else {
            ?>
            <p>Please Enter Search Parameters</p>
            <?php

        }
        ?>
    </article>
</article>
