<?php
    $selectModules = "";
    $selectRooms = "";
    foreach($optionModules as $option) {
        $selectModules .= "<option value='".$option."'"." >". $option ."</option>";
    }
    foreach($optionRooms as $option) {
        $selectRooms .= "<option value='".$option."'"." >". $option ."</option>";
    }
    if($errors != false) {
        $errorSize = " [".sizeof($errors)."]";
        $errorButtonStatus = "";
    }
    else {
        $errorSize = "";
        $errorButtonStatus ="disabled";
        }

?>
<article class = "table-container">
    <h2>Create Timetable</h2>
    <div class="tab-container">
        <button id="defaultOpen" class="tablinks active-tab timetable-tab " onclick="openTab(event, 'timetable-view')" >View</button>
        <button <?=$errorButtonStatus;?> class="tablinks timetable-tab" onclick="openTab(event, 'timetable-errors')">Errors<section class = "error"><?=$errorSize;?></section></button>
    </div>


    <div id="timetable-errors" class="timetable-tabcontent">
        <div class = "large-table error-display">
    <?php
    foreach($errors as $key => $error) {
        ?>
            <p class = "error timetable-error">
                <?=$key." - ";?>
                <?=$error;?>
            </p>
    <?php
    }
    ?>
        </div>
    </div>

    <div id="timetable-view" class="timetable-tabcontent">
    
    <form method = "POST" action="/timetable/create">
        <table class= 'timetable-table large-table'>
            <tr><div class = "heading-course">Course: <?=$course->name;?> - Year <?=$course->year;?></div></tr>
            <tr>
                <th>Day</th>
                <th>9-10</th>
                <th>10-11</th>
                <th>11-12</th>
                <th>12-1</th>
                <th>1-2</th>
                <th>2-3</th>
                <th>3-4</th>
                <th>4-5</th>
            </tr>
            <tr>
            <?php 
            foreach ($days as $daykey => $day) {

            ?>
                <td><?=$day;?></td>
                <?php 
                foreach ($timeslots as $keyslot => $value) {
                    $tdclass = '';
                    if(isset($errors[$day . " ". $value])) {
                        $tdclass = "class = table-error";
                    }
                ?>
                <td <?=$tdclass;?> >
                    <select id="type" name='timetable[<?=$day;?>][<?=$value;?>][module]'>
                    <?php
                    if(isset($timetable[$days[$daykey]][$timeslots[$keyslot]]['module'])) {
                        $uniModules = "";
                        foreach($optionModules as $option) {
                            if(isset($timetable[$days[$daykey]][$timeslots[$keyslot]]['module']) && $option == $timetable[$days[$daykey]][$timeslots[$keyslot]]['module']) {
                                $selected =' selected = "selected"';
                            }
                            else {
                                $selected = '';
                            }
                            $uniModules .= "<option value='".$option."'"." ".$selected." >". $option ."</option>";
                        }
                    }
                    else {
                        $uniModules = $selectModules;
                    }
                    ?>
                    <?=$uniModules;?>
                    </select>
            
                    <select id="type" name='timetable[<?=$days[$daykey];?>][<?=$timeslots[$keyslot];?>][room]'>
                    <?php
                    if(isset($timetable[$days[$daykey]][$timeslots[$keyslot]]['room'])) {
                        $unirooms = "";
                        foreach($optionRooms as $option) {
                            if(isset($timetable[$days[$daykey]][$timeslots[$keyslot]]['room']) && $option == $timetable[$days[$daykey]][$timeslots[$keyslot]]['room']) {
                                $selected =' selected = "selected"';
                            }
                            else {
                                $selected = '';
                            }
                            $unirooms .= "<option value='".$option."'"." ".$selected." >". $option ."</option>";
                        }
                    }
                    else {
                        $unirooms = $selectRooms;
                    }
                    ?>
                    <?=$unirooms;?>
                    </select>
                </td>
                <?php
                }
                ?>
            </tr>
            <?php
                }
                ?>
        </table>
        
        <div class="submit-hold">
            <input class="table-submit" type="submit" name="Submit">
            <input type="submit" class = "table-submit" name="Automate" value="Automate">
        </div>
        <input type = "hidden" name="course[id]" value="<?=$course->id;?>">
        <input type = "hidden" name="t_id" value="<?=$t_id ?? '';?>">

    </form>
    
    </div>
</article>