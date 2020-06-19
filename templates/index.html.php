<div class="container">
<form action="/" method=POST>
            <div class="row row1 justify-content-between">
                <div class="col-md-5 mycol">
                    <label for="status">Student Status: </label>
                    <select id="status" name="student[studentstatus]">
                        <option name="live">Live</option>
                        <option name="Pro">Provisional</option>
                        <option name="Dor">Dormant</option>
                    </select>
                    <label for="reason">Reason for Dormancy: </label> <textarea id="reason" name="student[dormancyreason]"></textarea>
                    <label for="fname">First Name: </label> <input type="text" name="student[firstname]" id="fname">
                    <label for="middle">Middle Name: </label> <input type="text" name="student[middlename]" id="middle">
                    <label for="sname">Surname: </label> <input type="text" name="student[surname]" id="sname">
                    <label for="id">Student ID: </label> <input type="text" name="student[studentid]" id="id">
                </div>
                <div class="col-md-5 mycol">
                    <label for="term">Term Time Address: </label> <textarea name="student[termaddress]" id="term"></textarea>
                    <label for="non">Non-Term Time Address: </label> <textarea name="student[nonaddress]" id="non"></textarea>
                    <label for="num">Phone Number: </label> <input type="text" name="student[phonenum]" id="num">
                    <label for="em">Email: </label> <input type="text" name="student[email]" id="em">
                    <label for="code">Course Code: </label> <input type="text" name="student[coursecode]" id="code">
                    <label for="entry">Entry Qualifications: </label> <textarea name="student[entryqual]" id="entry"></textarea>
                </div>
                
            </div>
            <div class="row justify-content-center">
                <div class="col-1 subcol">
                    
                        <input class="hvr-grow" type="submit" name="submit">
                    
                </div>
            </div>
            </form>
        </div>