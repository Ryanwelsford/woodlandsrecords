<div class="container container-center justify-content-md-center">
    <div class="row therow justify-content-md-center">
        <div class="col columns justify-content-md-center">
            <div class="top-report">
                <div class="w3-bar report-tab-bar" id="mydiv">
                    <!--Each tab button opens the corresponding tab -->
                    <button class="w3-bar-item w3-button hvr-pulse-shrink active" onclick="openContent('Timetable')">Timetable</button>
                    <button class="w3-bar-item w3-button hvr-pulse-shrink" onclick="openContent('Personal-Tutor')">Personal Tutor</button>
                    <button class="w3-bar-item w3-button hvr-pulse-shrink" onclick="openContent('Grades')">Grades</button>
                    <button class="w3-bar-item w3-button hvr-pulse-shrink" onclick="openContent('Attendance')">Attendance</button>
                    <button class="w3-bar-item w3-button hvr-pulse-shrink" onclick="openContent('Student')">Student</button>
                    <button class="w3-bar-item w3-button hvr-pulse-shrink" onclick="openContent('Staff')">Staff</button>
                    <button class="w3-bar-item w3-button hvr-pulse-shrink" onclick="openContent('Module')">Module</button>
                    <button class="w3-bar-item w3-button hvr-pulse-shrink" onclick="openContent('Assignment')">Assignment</button>
                </div>
            </div>
            <div class="bottom-report form-colour-background-opaque">
                <div>
                    <div id="Timetable" class="w3-container city ">
                        <div class="report-grid">

                        <a <?=$target ?? '';?> href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Current Tutor Timetable</div>
                        </div></a>
                        <a href="/report/timetable/student<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Current Student Timetable</div>
                        </div></a>
                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Current Timetable by Year</div>
                        </div></a>

                        </div>    
                    </div>

                    <div id="Personal-Tutor" class="w3-container city" style="display:none">
                        <div class="report-grid">

                        <a href="/construction<?=$linkAddition ?? '';?>"div class="report-tab">
                            <div>Tutees by Tutor</div>
                        </div></a>
                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Tutees by Tutor and Year</div>
                        </div></a>
                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Tutorial outcomes by student by year</div>
                        </div></a>

                        </div>   
                    </div>

                    <div id="Grades" class="w3-container city" style="display:none">
                        <div class="report-grid">

                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Grade Profile by Student</div>
                        </div></a>
                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Grade List by Module</div>
                        </div></a>
                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Outstanding Grades by Module</div>
                        </div></a>
                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Grades by Module Year by Year</div>
                        </div></a>

                        </div>   
                    </div>

                    <div id="Attendance" class="w3-container city" style="display:none">
                        <div class="report-grid">

                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Attendance by Module</div>
                        </div></a>
                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Attendance by Student</div>
                        </div></a>
                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Poor Attendance</div>
                        </div></a>

                        </div>   
                    </div>
                    <div id="Student" class="w3-container city" style="display:none">
                        <div class="report-grid">

                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Contacts by ID</div>
                        </div></a>
                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Contacts by Name</div>
                        </div></a>

                        </div>   
                    </div>
                    <div id="Staff" class="w3-container city" style="display:none">
                        <div class="report-grid">

                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Contacts by ID</div>
                        </div></a>
                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Contacts by Name</div>
                        </div></a>

                        </div>   
                    </div>
                    <div id="Module" class="w3-container city" style="display:none">
                        <div class="report-grid">

                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Current Modules by Year</div>
                        </div></a>

                        </div>   
                    </div>
                    <div id="Assignment" class="w3-container city" style="display:none">
                        <div class="report-grid">

                        <a href="/construction<?=$linkAddition ?? '';?>"><div class="report-tab">
                            <div>Assignments Scheduled by Year</div>
                        </div></a>

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
</div>