<div class="container">
<form action="amendstudent.php" method="POST">
            <div class="row row1 justify-content-between">
                
                <div class="col-md-5 mycol">
                    <label for="status">Student Status: </label>
                    <select id="status" name="student[studentstatus]">
                        <option name="live">Live</option>
                        <option name="Pro">Provisional</option>
                        <option name="Dor">Dormant</option>
                        <option selected="selected"><?=$student['studentstatus']?></option>
                    </select>
                    <label for="reason">Reason for Dormancy: </label> <textarea id="reason" name="student[dormancyreason]"><?=$student['dormancyreason']?></textarea>
                    <label for="fname">First Name: </label> <input type="text" name="student[firstname]" id="fname" value=<?=$student['firstname']?>>
                    <label for="middle">Middle Name: </label> <input type="text" name="student[middlename]" id="middle" value=<?=$student['middlename']?>>
                    <label for="sname">Surname: </label> <input type="text" name="student[surname]" id="sname" value=<?= $student['surname']?>>
                    <label for="id">Student ID: </label> <input type="text" name="student[studentid]" id="id" value=<?=$student['studentid']?>>
                </div>
                <div class="col-md-5 mycol">
                    <label for="term">Term Time Address: </label> <textarea name="student[termaddress]" id="term"><?=$student['termaddress']?></textarea>
                    <label for="non">Non-Term Time Address: </label> <textarea name="student[nonaddress]" id="non"><?=$student['nonaddress']?></textarea>
                    <label for="num">Phone Number: </label> <input type="text" name="student[phonenum]" id="num" value=<?=$student['phonenum']?>>
                    <label for="em">Email: </label> <input type="text" name="student[email]" id="em" value=<?=$student['email']?>>
                    <label for="code">Course Code: </label> <input type="text" name="student[coursecode]" id="code" value=<?=$student['coursecode']?>>
                    <label for="entry">Entry Qualifications: </label> <textarea name="student[entryqual]" id="entry"><?=$student['entryqual']?></textarea>
                </div>
                
            </div>
            <div class="row justify-content-center">
                <div class="col-1 subcol">
                    <input type="hidden" name="student[id]" value="<?=$student['id']?>">
                    <input type="submit" name="submit">
                </div>
            </div>
</form>
        </div>
