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
                                <th>Student Id</th>
                                <th>First Name</th>
                                <th>Surname</th>
                                <th>Course Code</th>
                                <th>Links</th>
                            </tr>
                            
                        
                <?php
                foreach($results as $result) {
                    ?>
                    <tr>
                    <?php
                    
                ?>
                    <td><?=$result->studentid;?></td>
                    <td><?=$result->firstname;?></td>
                    <td><?=$result->surname;?></td>
                    <td><?=$result->coursecode;?></td>
                    <td>
                        <article class="search-buttons-links">
                            <a href="/attendance/monitor/student?sid=<?=$result->studentid;?>"><button class="search-button">Profile</button></a>
                        </article>
                    </td>
                    
                    
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
