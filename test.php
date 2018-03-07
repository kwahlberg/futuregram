//test 
<?php
if(include_once('/students/kwahlber/public_html/cs130a/SecurityLog/phplib/app/models/LogModel.php')){
    
    echo 'cool';
}

$model = new LogModel();
$model->listTenants();
$db = $model::$db;

?>        
       <table>
  <tr>
    <th>Course</th>
    <th>Section</th>
    <th>Instructor</th>
    <th>Location</th>
    <th>Days</th>
    <th>Start Time</th>

  </tr>

<?php

//print_r($students);
$myquery = '
    SELECT courses.course_name, course_section.sec_num,  faculty.f_last, CONCAT(location.bldg_code, location.room), course_section.c_sec_day, course_section.c_sec_time
        FROM (((course_section
        INNER JOIN faculty ON course_section.f_id = faculty.f_id)
    INNER JOIN courses ON course_section.f_id = courses.course_id)
    INNER JOIN location ON course_section.loc_id = location.loc_id)
    WHERE course_section.term_id ="5"';    


if($rows = $db->select($myquery)){
  
    foreach($rows as $row){
        echo "<tr>";
        if(is_array($row)){
            foreach($row as $datum){
                echo "<td>$datum</td>";
            }
        }
        echo "</tr>";
    }
}
?>

</table>
