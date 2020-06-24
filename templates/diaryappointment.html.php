<?php 
    foreach($appointments as $appointment) {
        //bug fix for select values not mataching class names
        if(strtolower($appointment['type']) == "personal tutorial") {
            $appointment['type'] = "Personal-Tutorial";
        }
?>
<section class="diary-<?=strtolower($appointment['type']);?>">

    <form method="POST" action="/diary/delete" class="diary-delete">
        <input type="hidden" value="<?=$appointment['id'];?>" name="appointment[id]">
        <input type="hidden" value="<?=$appointment['date'];?>" name="appointment[date]">
        <input type="submit" value="X">
    </form>
    <a href = "/diary/create?id=<?=$appointment['id'];?>">
    <div class="diary-time">
        <?=$appointment['start_time'];?> - <?=$appointment['end_time'];?>
    </div>
    <div class="hidden"><?=$appointment['details'];?></div>
    <div><?=ucfirst($appointment['type']);?></div>
    </a>
</section>
<?php
    }
?>

        
    