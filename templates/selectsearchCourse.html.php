<article class = "table-container">
    <div class ="left-search"><?=$searchBox;?></div>
    <article class="search-results-container">
        <?php
        if($totalResults == 0) {
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
            <p>Displaying <?=sizeof($results);?> of <?=$totalResults;?> <?=$resultWord;?></p>
            <table class="search-results-table">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Year</th>
                    <th>Links</th>
                </tr>
            <?php
            foreach($results as $result) {
                ?>
                <tr>
                <td><?=$result->id;?></td>
                <td><?=ucwords($result->name);?></td>
                <td><?=$result->year;?></td>
                <td>
                    <article class="search-buttons-links">
                    <form method="POST" action="/timetable/create">
                        <input type="hidden" value="<?=$result->id;?>" name="course[id]">
                        <input class ="search-button" type ="submit" value="Select">
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
                <?=$pagePre;?>
                <?=$pageNext;?>
            </div>
            <?php  
        }  
?>
    </article>
</article>