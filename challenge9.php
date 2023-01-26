<?php
include_once('./connection.php');
$database = new Database('127.0.0.1', 'root', 'root', 'CHALLENGES','3306');
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .top-right-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .logo {
            text-align: center;
            margin-top: 20px; /* Add some space between the button and the logo */
        }
        .logo img {
            width: 100px; /* Set the width of the logo to 100px */
            height: 100px; /* Set the height of the logo to 100px */
        }
        /* Container for the form */
        .form-container {
            background-color: #cccccc;
            width: 1300px; /* Set the width of the container */
            height: 100px; /* Set the height of the container */
            margin: 0 auto; /* Center the container horizontally */
            margin-top: 20px; /* Add some space between the logo and the container */
            text-align: center; /* Center the contents of the container */
        }
        /* Form heading */
        .form-container h2 {
            margin-bottom: 20px; /* Add some space between the heading and the form */
        }
        /* Form fields */
        .form-container label {
            display: inline-block; /* Display the labels and fields in a horizontal line */
            margin-right: 8px; /* Add some space between the fields */
        }
        /* Course Number dropdown */
        .form-container select {
            margin-right: 8px; /* Add some space between the fields */
        }
        /* Table styles */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 4px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <button class="top-right-button"> Logout</button>
    <div class="logo">
        <img src="./cnet.png" alt="Logo">
    </div>
    <div class="form-container">
        <h2>Enter Course Grades</h2>
        <form>
            <label>First Name: <input type="text" id="first_name" name="first_name" placeholder="First Name Only"></label>
            <label>Last Name: <input type="text" id="last_name" name="last_name" placeholder="Second Name Only"></label>
            <label>Course Number:
                <?php
                
                echo  '<select id="course_number" name="course_number">';
                $conn = $database->connect();
                $query = 'SELECT CourseId FROM COURSES';
                $result = $conn->query($query);
                while($row = $result->fetch_assoc()) {
                    echo'
                   <option value="'.$row['CourseId'].'">'.$row['CourseId'].'</option>';
                };
                $conn->close();
                ?>
                </select>

            </label>
            <label>Final Grade: <input type="text" id="final_grade" name="final_grade" placeholder="100"></label>
            <input type="submit" value="Submit" onclick="validateAndWrite(); return false;">
            <input type="reset" value="Reset">
        </form>
     </div>
     <br>
     <h3>The table below disdisplays the contents of the FinalGrade.txt located on the WebServer.</h3>
     <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Course#</th>
            <th>Letter Grade</th>
        </tr>
        <tr>
            <?php
            $conn =  $database->connect();
            $sql = 'SELECT STUDENTS.FirstName, STUDENTS.SecondName, COURSES.CourseName, GRADES.Grade FROM STUDENTS JOIN GRADES ON STUDENTS.StudentId = GRADES.StudentID JOIN COURSES ON COURSES.CourseId = GRADES.CourseID;';
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                echo'<td id="first_name_cell">'.$row['FirstName'].'</td>
                <td id="last_name_cell">'.$row['SecondName'].'</td>
                <td id="course_number_cell">'.$row['CourseName'].'</td>
                <td id="final_grade_cell">'.$row['Grade'].'</td>';
            };
            $conn->close();
            ?>
        </tr>
    </table>
    <button>Clear Text File</button>
    <script>
        function validateAndWrite() {
        // Get the form field values
        var firstName = document.getElementById("first_name").value;
        var lastName = document.getElementById("last_name").value;
        var courseNumber = document.getElementById("course_number").value;
        var finalGrade = document.getElementById("final_grade").value;
        
            // Check if any of the fields are blank
            if (firstName == "" || lastName == "" || courseNumber == "" || finalGrade == "") {
                alert("Please fill out all fields");
                return;
                }
        
                // Write the values to the table cells
                document.getElementById("first_name_cell").innerHTML = firstName;
                document.getElementById("last_name_cell").innerHTML = lastName;
                document.getElementById("course_number_cell").innerHTML = courseNumber;
                document.getElementById("final_grade_cell").innerHTML = finalGrade;
            }
    </script>
</body>
</html>