<?php
namespace RWCSY2028;
class TableSearchBox {

    //maybe this class should actually be an extension of dbt class 
    //or should have access to pdo var to remove methods required 
    private $databaseTable;
    private $fields;
    private $blockedFields;

    public function __construct(DatabaseTable $table, $blockedFields = []) {
        $this->databasetable = $table;
        $this->blockedFields = $blockedFields;
        $this->fields = $this->generateFields();
    }  
    //generate fields to be searched, uses desc and checks against fields passed that do not want to be searched
    private function generateFields() {
        $results = $this->databasetable->desc();
        $fields = [];
        foreach($results as $result) {
                if(!in_array($result['Field'], $this->blockedFields)) {
                    $string = $result['Field'];
                    $fields[] = $string;
            }
        }
        return $fields;
    }

    //produce search box with select list for all accepted table columns
    public function searchBox($action = "results") {
        //start output buffering to prevent html being printed to page
        ob_start();
        //if you have /results it returns to top level
            //if you have results as below it stays within the same controller i.e. diary/results
        ?>
        <form method="GET" action="<?=$action;?>">
        <input type="hidden" name="pageno" value="1">
        <input type="text" name="search" placeholder="Enter Search Values" value="<?= $_GET['search'] ?? ''?>">
        <select name="field">
        <?php
        foreach($this->fields as $field) {
            if(isset($_GET['field']) && $_GET['field'] == $field) {
                $selected = "selected = 'selected'";
            }
            else {
                $selected = "";
            }
            ?>
            <option value="<?=$field;?>" <?=$selected;?> ><?=ucwords($field);?></option>
            <?php
        
    }
    ?>
    <input type="submit" value="Search">
    </form>
    </select>
    <?php
    $contents = ob_get_clean();
    return $contents;

    }

    public function generalSearchBox($action = 'results') {
        ob_start();
        ?>
        <form method="GET" action="<?=$action;?>">
        <input type="hidden" name="pageno" value="1">
        <input type="text" name="search" placeholder="Enter Search Values" value="<?= $_GET['search'] ?? ''?>">
        <input type="submit" value="Search">
        </form>

        <?php
        $contents = ob_get_clean();
        return $contents;
    } 
    //produce pagination button for next result set
    public function paginationNext($pageno, $totalSearchResults, $resultsperpage, $class = 'search-next search-pagination-button') {
        ob_start();
        $next = '';
        if($pageno >= ceil($totalSearchResults/$resultsperpage)) {
            $next = "disabled";
        }
        //note field input only required in refined search box class
        ?>
        <form METHOD="GET" action='' class="<?=$class;?>">
            <input name="search" type = "hidden" value ="<?=$_GET['search'] ?? ''?>">
            <input name="field" type = "hidden" value ="<?=$_GET['field'] ?? ''?>">
            <input name="pageno" type = "hidden" value ="<?=$pageno+1;?>">
            <input type="submit" value="Next" <?=$next;?>>
        </form>
        <?php
        $contents = ob_get_clean();
        return $contents;   
    }
    //produce pagination button for previous results set
    public function paginationPrevious($pageno, $class = 'search-previous search-pagination-button') {
        ob_start();
        $previous = '';
        if($pageno <= 1) {
            $previous = "disabled";
        }
        ?>
        <form METHOD="GET" action='' class="<?=$class;?>">
            <input name="search" type = "hidden" value ="<?=$_GET['search'] ?? ''?>">
            <input name="field" type = "hidden" value ="<?=$_GET['field'] ?? ''?>">
            <input name="pageno" type = "hidden" value ="<?=$pageno-1 ?? ''?>">
            <input type="submit" value="Previous" <?=$previous;?>>
        </form>
        <?php
        $contents = ob_get_clean();
        return $contents;   
    }

    //produce results for field passed and value, limits based on offset and total results to display
    //prevents search of blocked fields
    public function getSearchResults($field, $value, $limit = false) {
        $results = false;
        //prevent url manipulation to allow access to banned field
        if (in_array($field,$this->fields)) {
            $results = $this->databasetable->findLike($field, $value, $limit);
        }
        return $results;
    }

    //search all fields within given dbtable object, fields that are allowed to be searched
    public function getGeneralSearchResults($value, $limit = false) {
        
        $results = $this->databasetable->findGeneralLike($this->fields, $value, $limit);
        return $results;
    }


}

