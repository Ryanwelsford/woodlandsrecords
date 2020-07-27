
<?php
    // build options list for form
    $select = '';
    // options are the available pick list for the select box
    $options = ['event', 'appointment', 'personal tutorial', 'meeting'];
    foreach($options as $option) {
        // if appointment is set and the type = the option have that option selected
        if ( isset($appointment->type) && strtolower($appointment->type) == $option) {
            $selected = 'selected ="selected"';
        }
        // if not set or appointment type does not equal
        else {
            $selected = '';
        }
        // build options string into a full list of options for the options array
        $select .= '<option value="'.$option.'" '. $selected .' >'.ucwords($option).'</option>';
    }
    $date = new DateTime();
    ?>
<div class = 'formContainer form-colour-background'>
    <h3>Appointment Creation</h3>
    
    <?php
        foreach($errors as $error) {?>
            <p class='error'><?=$error;?></p>
            <?php
        }
        ?>
        
    <form method="POST" action="/diary/create">
        <label>Appointment Type</label>
        <input type='hidden' name='appointment[id]' id='id' value="<?=$appointment->id ?? ''?>">
        <select id="type" name='appointment[type]'>
            <?=$select ?? ''?>
        </select>
        <label>Date</label>
        <input type='date' name='appointment[date]' id='date' value="<?=$appointment->date ?? $date->format("Y-m-d")?>">
        <label>Start Time</label>
        <input type='time' name='appointment[start_time]' id='start_time' value="<?=$appointment->start_time ?? '12:00'?>">
        <label>End Time</label>
        <input type='time' name='appointment[end_time]' id='end_time' value="<?=$appointment->end_time ?? '15:00'?>">
        <label>Details</label>
        <input type='text' name='appointment[details]' id ='details' value='<?=$appointment->details ?? ''?>'>
        <input class='submit' type='submit' name='submit' id='submit'>
    </form>
    
</div>