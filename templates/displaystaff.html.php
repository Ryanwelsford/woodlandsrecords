<div class="container">
<form action="amendstudent.php" method="POST">
    <div class="row ">
        <div class="col propic">
                <img class="profile" src="/images\blank-profile-picture-973460_640.png" alt="Profile Picture" width="200" height="200">
        </div>
    </div>
            <div class="row row1 justify-content-between">
                
                <div class="col-md-5 mycol">
                    <label for="status">Staff Status: </label> <input type="text" name="studentstatus" value="<?=$staff['staffstatus']?>" readonly>
                    <label for="reason">Reason for Dormancy: </label> <textarea id="reason" name="dormancy" readonly><?=$staff['dormancyreason']?></textarea>
                    <label for="fname">First Name: </label> <input type="text" name="firstname" id="fname" value=<?=$staff['firstname']?> readonly>
                    <label for="middle">Middle Name: </label> <input type="text" name="middlename" id="middle" value=<?=$staff['middlename']?> readonly>
                    <label for="sname">Surname: </label> <input type="text" name="surname" id="sname" value=<?= $staff['surname']?> readonly>
                    <label for="id">Staff ID: </label> <input type="text" name="studentid" id="id" value=<?=$staff['staffid']?> readonly>
                </div>
                <div class="col-md-5 mycol">
                    <label for="term">Address: </label> <textarea name="termaddress" id="term" readonly><?=$staff['address']?></textarea>
                    <label for="num">Phone Number: </label> <input type="text" name="number" id="num" value=<?=$staff['phonenumber']?> readonly>
                    <label for="em">Email: </label> <input type="text" name="email" id="em" value=<?=$staff['email']?> readonly>
                    <label for="code">Roles: </label> <input type="text" name="coursecode" id="code" value=<?=$staff['roles']?> readonly>
                    <label for="entry">Specialist Subjects: </label> <textarea name="entryqual" id="entry" readonly><?=$staff['specialistsub']?></textarea>
                </div>
                
            </div>
            <!-- <div class="row justify-content-center">
                <div class="col-1 subcol">
                    <input type="submit" name="submit">
                </div>
            </div> -->

        
</form>
        </div>
