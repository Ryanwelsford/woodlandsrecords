
<article class="diary table-container">
    <h3>
        <?php 
            $a = strtotime($prev); 
            $prevPrintout = date("M", $a);
            $a = strtotime($next); 
            $nextPrintout = date("M", $a);
            $a = strtotime($diarytitle);
            $prevYear = date("Y", strtotime( date( "Y-M-d",$a) . "-1 year" ) );
            $nextYear = date("Y", strtotime( date( "Y-M-d",$a) . "+1 year" ) );
            $preYearMonth = date("Y-m", strtotime( date( "Y-M-d",$a) . "-1 year" ) );
            $nextYearMonth = date("Y-m", strtotime( date( "Y-M-d",$a) . "+1 year" ) );
            $printedTitle = date("F Y", $a);
        ?>
        <section class = "diary-title">
            <div class = "diary-left">
                <button>
                    <a href=<?="/diary/view?yearMonth=".$preYearMonth;?>><?=$prevYear;?></a>
                </button>&emsp;

                <button>
                    <a href=<?="/diary/view?yearMonth=".$prev;?>><?=$prevPrintout;?></a> 
                </button>
            </div>

            &emsp;<a class = "diary-title-text"><?=$printedTitle;?></a>&emsp; 

            <div class = "diary-right">
                <button>
                    <a href=<?="/diary/view?yearMonth=".$next;?>><?=$nextPrintout;?></a>
                </button>&emsp;

                <button>
                    <a href=<?="/diary/view?yearMonth=".$nextYearMonth;?>><?=$nextYear;?></a>
                </button>
            </div>
        </section>
    </h3>
    <table class="diary-table large-table">
        <tr>
            <th>S</th>
            <th>M</th>
            <th>T</th>
            <th>W</th>
            <th>T</th>
            <th>F</th>
            <th>S</th>
        </tr>
            <?php 

            foreach($weeks as $week) {
                echo $week;
            } 
            ?>
    </table>
</article>
<!--This template requires the current date. no vars are passed into it atm will need
an appointments array in final version-->