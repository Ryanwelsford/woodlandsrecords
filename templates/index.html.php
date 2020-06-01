<div class="container">
<form action="index.php" method=POST>
            <div class="row row1 justify-content-between">
                <div class="col-md-5 mycol">
                    <label for="status">Student Status: </label>
                    <select id="status" name="studentstatus">
                        <option name="live">Live</option>
                        <option name="Pro">Provisional</option>
                        <option name="Dor">Dormant</option>
                    </select>
                    <label for="reason">Reason for Dormancy: </label> <textarea id="reason" name="dormancy"></textarea>
                    <label for="fname">First Name: </label> <input type="text" name="firstname" id="fname">
                    <label for="middle">Middle Name: </label> <input type="text" name="middlename" id="middle">
                    <label for="sname">Surname: </label> <input type="text" name="surname" id="sname">
                    <label for="id">Student ID: </label> <input type="text" name="studentid" id="id">
                </div>
                <div class="col-md-5 mycol">
                    <label for="term">Term Time Address: </label> <textarea name="termaddress" id="term"></textarea>
                    <label for="non">Non-Term Time Address: </label> <textarea name="nontermaddress" id="non"></textarea>
                    <label for="num">Phone Number: </label> <input type="text" name="number" id="num">
                    <label for="em">Email: </label> <input type="text" name="email" id="em">
                    <label for="code">Course Code: </label> <input type="text" name="coursecode" id="code">
                    <label for="entry">Entry Qualifications: </label> <textarea name="entryqual" id="entry"></textarea>
                    <label for="studentimg">Student Photo: </label> <input type="file" name="photo" id="studentimg">
                </div>
                
            </div>
            <div class="row justify-content-center">
                <div class="col-1 subcol">
                    
                        <input class="hvr-grow" type="submit" name="submit">
                    
                </div>
            </div>
            </form>
        </div>