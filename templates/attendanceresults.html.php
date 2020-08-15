<article class = "table-container">
    <h2><?=$heading;?></h2>

    <div class ="left-search"><?=$searchBox;?></div>
    <article class="search-results-container">
    <div class = "Archive-link"><a href='/attendance/archive/results'>Search Archives</a></div>
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
                                <th>Module Code</th>
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
                    <td><?=$result->module->name ?? 'Module not found'?></td>
                    <td><?=$result->date ?? 'date not found'?></td>
                    <td>
                        <article class="search-buttons-links">
                        <a href="/attendance/create?id=<?=$result->id;?>"><button class="search-button search-button-amend">Amend</button></a>
                        <a href="/attendance/view?id=<?=$result->id;?>"><button class="search-button search-button-view">Display</button></a>
                        <form method="POST" action="/attendance/archive">
                            <input type="hidden" value="<?=$result->id;?>" name="attendance[id]">
                            <input class ="search-button search-button-archive" type ="submit" value="Archive">
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
