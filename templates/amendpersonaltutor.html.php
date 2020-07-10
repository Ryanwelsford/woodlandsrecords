<div class="container">
<form action="/tutor/amendpersonaltutor" method=POST>
            <div class="row row1 justify-content-center">
                <div class="col-md-5 mycol">

                    <label for="fname">First Name: </label> <input type="text" name="firstname" id="fname" value="<?=$staff['firstname']?>" readonly>
                    <label for="sname">Surname: </label> <input type="text" name="surname" id="sname" value="<?= $staff['surname'] ?>" readonly>
                    <label for="id">Staff ID: </label> <input type="text" name="staffid" id="id" value="<?= $staff['staffid']?>" readonly>

                    <label for="status">Course: </label>
                    <select id="status" name="course">
                        <option name="c1">Course 1</option>
                        <option name="c2">Course 2</option>
                        <option name="c3">Course 3</option>
                        <option selected="selected"><?= $staff['courseteaching'] ?></option>
                    </select>

                </div>
                
            </div>
            <div class="row justify-content-center">
                <div class="col-1 per">
                        <input type="hidden" name="id" value="<?=$staff['id']?>">
                        <input class="hvr-grow" type="submit" name="submit">
                    
                </div>
            </div>
            </form>
        </div>