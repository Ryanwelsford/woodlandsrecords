
<?php
    // build options list for form
    $select = '';
    // options are the available pick list for the select box
    foreach($courses as $course) {
        // build options string into a full list of options for the options array
        $select .= '<option value="'.$course->id.'" >'.ucwords($course->name." Year ".$course->year).'</option>';
    }
    ?>
<div class = 'formContainer'>
    <h3>Select Course for Timetable</h3>
    
    <?php
        foreach($errors as $error) {?>
            <p class='error'><?=$error;?></p>
            <?php
        }
        ?>
        
    <form method="POST" action="/timetable/create">
        <label>Course: </label>
        <select id="type" name='course[id]'>
            <?=$select ?? ''?>
        </select>
        <input class='submit' type='submit' name='submit' id='submit'>
    </form>

    <p>Or Search for course details below</p>
    <div><?=$searchBox;?></div>
    
</div>