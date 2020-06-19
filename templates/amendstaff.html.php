<div class="container">
    <div class="row therow">
        <div class="col columns">
            <div class="top">
                <div class="w3-bar" id="mydiv">
                    <button class="w3-bar-item w3-button hvr-pulse-shrink" onclick="openContent('Status')">Status</button>
                    <button class="w3-bar-item w3-button hvr-pulse-shrink" onclick="openContent('Pinfo')">Personal Info</button>
                    <button class="w3-bar-item w3-button hvr-pulse-shrink" onclick="openContent('Contact')">Contact Info</button>
                    <button class="w3-bar-item w3-button hvr-pulse-shrink" onclick="openContent('Academic')">Academic Info</button>
                </div>
            </div>
            <form action="/amendstaff" method="POST">
            <div class="bottom">
                <div class="inner">
                    <div id="Status" class="w3-container city">
                        <div class="data">
                            <p></p>
                            <p></p>
                            <label for="stastatus">Staff Status: </label>
                            <select id="stastatus" name="staff[staffstatus]">
                                <option name="live">Live</option>
                                <option name="Dor">Dormant</option>
                                <option selected="selected"><?=$staff['staffstatus']?></option>
                            </select>

                            <label for="dor">Reason for dormancy: </label> <textarea id="dor" name="staff[dormancyreason]"><?=$staff['dormancyreason']?></textarea>
                        </div>    
                    </div>

                    <div id="Pinfo" class="w3-container city" style="display:none">
                        <div class="data">
                            <p></p>
                            <p></p>
                            <label id="fname">First name: </label> <input type="text" name="staff[firstname]" id="fname" value="<?=$staff['firstname']?>">
                            <label id="mname">Middle name: </label> <input type="text" name="staff[middlename]" id="mname" value="<?=$staff['middlename']?>">
                            <label id="sname">Surname: </label> <input type="text" name="staff[surname]" id="sname" value="<?=$staff['surname']?>">
                            <label id="id">Staff ID: </label> <input type="text" name="staff[staffid]" id="id" value="<?=$staff['staffid']?>">
                        </div>
                    </div>

                    <div id="Contact" class="w3-container city" style="display:none">
                        <div class="data">
                            <p></p>
                            <p></p>
                            <label for="add">Address: </label> <textarea id="add" name="staff[address]"><?=$staff['address']?></textarea>
                            <label for="num">Phone Number: </label> <input type="text" name="staff[phonenumber]" id="num" value="<?=$staff['phonenumber']?>">
                            <label for="em">Email Address: </label> <input type="text" name="staff[email]" id="em" value="<?=$staff['email']?>">
                        </div>
                    </div>

                    <div id="Academic" class="w3-container city" style="display:none">
                        <div class="data">
                            <p></p>
                            <p></p>
                            <label for="ro">Roles: </label> <textarea name="staff[roles]" id="ro"><?=$staff['roles']?></textarea>
                            <label for="spe">Specailist Subjects: </label> <textarea name="staff[specialistsub]" id="spe"><?=$staff['specialistsub']?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            function openContent(cityName) {
                var i;
                var x = document.getElementsByClassName("city");
                for(i=0;i < x.length; i++)
                {
                    x[i].style.display = "none";
                }
                document.getElementById(cityName).style.display = "block";
            }

            var header = document.getElementById("mydiv");
            var btns = header.getElementsByClassName("w3-bar-item");
            for(var i=0;i < btns.length; i++)
            {
                btns[i].addEventListener("click", function() {
                    var current = document.getElementsByClassName("active");
                    if(current.length > 0)
                    {
                        current[0].className = current[0].className.replace(" active", "");
                    }
                    this.className += " active";
                });
            }            
            </script>
        </div>
    </div>
    <div class="row">
        <div class="col">
        <input type="hidden" name="staff[id]" value="<?=$staff['id']?>">
        <input class="hvr-sink" type="submit" name="submit">
        </div>
    </div>
    </form>
</div>