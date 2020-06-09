<div class="container">
<form action="#" method=POST>
            <div class="row row1 justify-content-center">
                <div class="col-md-5 mycol">

                    <label for="fname">Student Name: </label> <input type="text" name="studentfirstname" value="<?=$student['firstname']?>">
                    <label for="surname">Student Surname: </label> <input type="text" name="studentsurname" value="<?=$student['surname']?>">
                    <label for="stid">Student ID: </label> <input type="text" name="studentid" value="<?=$student['studentid']?>">
                    <label for="co">Course: </label> <input type="text" name="course" value="<?=$student['coursecode']?>">
                    <label for="staff">Personal Tutor: </label>
                    <select name="personaltutor">
                    <?php foreach($stmt as $row) { ?>
                            <option value="<?= $row['id']?>"><?=$row['firstname'] . ' ' . $row['surname'] . '-' . $row['courseteaching']?></option>
               <?php   }   ?>
                    </select>
                    

                </div>
                
            </div>
            <div class="row justify-content-center">
                <div class="col-1 per">
                        <input type="hidden" name="id" value="">
                        <input class="hvr-grow" type="submit" name="submit">
                    
                </div>
            </div>
            </form>
        </div>