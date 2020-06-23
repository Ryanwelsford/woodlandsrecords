<article class = "table-container">
    <h2><?=$heading;?></h2>

    <div class ="left-search"><?=$searchBox;?></div>
    <article class="search-results-container">
        <?php
        if(isset($_GET['search'])) {
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
                                <th>Type</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Details</th>
                                <th>Links</th>
                            </tr>
                            
                        
                <?php
                foreach($results as $result) {
                    ?>
                    <tr>
                    <?php
                    //update this into an actual search table would be ideal
                    $a = strtotime($result->date);
                    $yearMonth = date('Y-m', $a);
                    
                ?>
                    <td><?=$result->id;?></td>
                    <td><?=ucwords($result->type);?></td>
                    <td><?=date('d-m-Y', $a);?></td>
                    <td><?=$result->start_time;?>-<?=$result->end_time;?></td>
                    <td><?=$result->details;?></td>
                    <td>
                        <article class="search-buttons-links">
                        <a href="/diary/create?id=<?=$result->id;?>"><button class=" search-button search-button-amend">Amend</button></a>
                        <a href="/diary/view?yearMonth=<?=$yearMonth;?>"><button class="search-button">View Calendar</button></a>
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
