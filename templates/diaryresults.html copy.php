<article class = "table-container">
    <h2><?=$heading;?></h2>

    <div class ="left-search"><?=$searchBox;?></div>
    <article class="search-results-container">
        <?php
        if(isset($_GET['search'])) {
            if($totalSearchResults == 0) {
                ?>
                <p>No Results found try redefining your search</p>
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
                    <tr></tr>
                    <article class="search-result">
                    <?php
                    //update this into an actual search table would be ideal
                    $a = strtotime($result->date);
                    $yearMonth = date('Y-m', $a);
                    foreach($result as $key => $value) {
                        ?>
                        <div><?=ucwords($key);?>: <?=$value;?></div>
                        <?php
                    }
                ?>
                    <td>
                        <article class="search-buttons-links">
                        <a href="/diary/create?id=<?=$result->id;?>"><button>Amend</button></a>
                        <a href="/diary/view?yearMonth=<?=$yearMonth;?>"><button>View Calendar</button></a>
                        <form method="POST" action="/diary/delete">
                            <input type="hidden" value="<?=$result->id;?>" name="appointment[id]">
                            <input type="hidden" value="<?=$result->date;?>" name="appointment[date]">
                            <input type ="submit" value="Delete">
                        </form>
                    </td>
                    </table>
                    </article>
                    </article>
                    <?php
                }
                ?>
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
