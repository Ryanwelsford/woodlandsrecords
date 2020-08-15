
<?php
    // build options list for form
    $select = '';
    // options are the available pick list for the select box
    foreach($modules as $module) {
        // build options string into a full list of options for the options array
        $select .= '<option value="'.$module->id.'" >'.$module->name.'</option>';
    }
    ?>
<div class = 'formContainer'>
    <h3>Select Module for Attendance</h3>
    
        
    <form method="POST" action="/attendance/create">
        <label>Module: </label>
        <select id="type" name='module'>
            <?=$select ?? ''?>
        </select>
        <input class='submit' type='submit' name='submit' id='submit'>
    </form>

    <p>Or Search for module details below</p>
    <div><?=$searchBox;?></div>
    
</div>