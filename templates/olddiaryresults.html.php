<article class = "table-container">
    <h2><?=$heading;?></h2>

    <div class ="left-search"><?=$searchBox;?></div>
    <article class="search-results-container">
        <?php
        if(isset($_GET['search']) && isset($_GET['field'])) {
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
                <?php
                foreach($results as $result) {
                    ?>
                    <article class="search-result">
                    <?php
                    $a = strtotime($result->date);
                    $yearMonth = date('Y-m', $a);
                    foreach($result as $key => $value) {
                        ?>
                        <div><?=ucwords($key);?>: <?=$value;?></div>
                        <?php
                    }
                ?>

                    <article class="search-buttons-links">
                    <a href="/diary/create?id=<?=$result->id;?>"><button>Amend</button></a>
                    <a href="/diary/view?yearMonth=<?=$yearMonth;?>"><button>View Calendar</button></a>
                    <form method="POST" action="/diary/delete">
                        <input type="hidden" value="<?=$result->id;?>" name="appointment[id]">
                        <input type="hidden" value="<?=$result->date;?>" name="appointment[date]">
                        <input type ="submit" value="Delete">
                    </form>

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
