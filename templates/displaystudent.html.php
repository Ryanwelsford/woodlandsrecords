<div class="container">
<form action="amendstudent.php" method="POST">
    <div class="row ">
        <div class="col propic">
                <img class="profile" src="/images\blank-profile-picture-973460_640.png" alt="Profile Picture" width="200" height="200">
        </div>
    </div>
            <div class="row row1 justify-content-between">
                
                <div class="col-md-5 mycol">
                    <label for="status">Student Status: </label> <input type="text" name="studentstatus" value="<?=$student['studentstatus']?>" readonly>
                    <label for="reason">Reason for Dormancy: </label> <textarea id="reason" name="dormancy" readonly><?=$student['dormancyreason']?></textarea>
                    <label for="fname">First Name: </label> <input type="text" name="firstname" id="fname" value=<?=$student['firstname']?> readonly>
                    <label for="middle">Middle Name: </label> <input type="text" name="middlename" id="middle" value=<?=$student['middlename']?> readonly>
                    <label for="sname">Surname: </label> <input type="text" name="surname" id="sname" value=<?= $student['surname']?> readonly>
                    <label for="id">Student ID: </label> <input type="text" name="studentid" id="id" value=<?=$student['studentid']?> readonly>
                </div>
                <div class="col-md-5 mycol">
                    <label for="term">Term Time Address: </label> <textarea name="termaddress" id="term" readonly><?=$student['termaddress']?></textarea>
                    <label for="non">Non-Term Time Address: </label> <textarea name="nontermaddress" id="non" readonly><?=$student['nonaddress']?></textarea>
                    <label for="num">Phone Number: </label> <input type="text" name="number" id="num" value=<?=$student['phonenum']?> readonly>
                    <label for="em">Email: </label> <input type="text" name="email" id="em" value=<?=$student['email']?> readonly>
                    <label for="code">Course Code: </label> <input type="text" name="coursecode" id="code" value=<?=$student['coursecode']?> readonly>
                    <label for="entry">Entry Qualifications: </label> <textarea name="entryqual" id="entry" readonly><?=$student['entryqual']?></textarea>
                </div>
                
            </div>
            <!-- <div class="row justify-content-center">
                <div class="col-1 subcol">
                    <input type="submit" name="submit">
                </div>
            </div> -->

        
</form>
        </div>
