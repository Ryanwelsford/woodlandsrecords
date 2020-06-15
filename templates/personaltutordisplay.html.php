<div class="container">
<form action="#" method=POST>
            <div class="row row1 justify-content-center">
                <div class="col-md-5 mycol">

                    <label for="fname">Student Name: </label> <input type="text" name="studentfirstname" value="<?=$student['tuteename']?>" readonly>
                    <label for="surname">Student Surname: </label> <input type="text" name="studentsurname" value="<?=$student['tuteesurname']?>" readonly>
                    <label for="stid">Student ID: </label> <input type="text" name="studentid" value="<?=$student['tuteeid']?>" readonly>
                    <label for="co">Course: </label> <input type="text" name="course" value="<?=$student['course']?>" readonly>
                    <label for="staff">Personal Tutor: </label> <input type="text" name="personaltutor" value="<?=$student['tutorname'] . ' ' . $student['tutorsurname']?>" readonly>
                </div>
                
            </div>
            </form>
        </div>