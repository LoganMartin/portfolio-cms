<?php

//Initialize our database connection.
$connection = mysql_connect("localhost", 'root', '');
if(!$connection) {
    die('Error: '.mysql_error());
}
mysql_select_db("portfolio", $connection);

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'getProjects':     getProjects();          break;
        case 'saveNewProject':  saveNewProject();       break;
        case 'getProject':      getProjectInfo();       break;
        case 'updateProject':   updateProject();        break;
        case 'changeProjStatus': changeProjStatus();    break;
        default:                                        break;
    }
}

//Get all of our projects in the database, and return them in an html table.
function getProjects() {
    global $connection;
    $select = "SELECT * FROM project";

    if(!$result = mysql_query($select, $connection)) {
        die('Error:'.mysql_error());
    }

    $num_rows = mysql_num_rows($result);

    if($num_rows==0) {
        return "<h3>No Projects in the Database.</h3>";
    }

    $projectsTable = "<table id='projects-table' class='table table-striped table-hover'>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th></th>
                            </tr>
                        </thead><tbody>";

    while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $projectsTable .= '<tr';
        if($row['proj_enabled'] == 0)
            $projectsTable .= ' class="disabled-project"';
        $projectsTable .= '><td>'.$row['proj_name']."</td>";
        $projectsTable .= '<td>'.$row['proj_date']."</td>";
        $projectsTable .= '<td>'.$row['proj_type']."</td>";
        $projectsTable .= '<td align="right"><button id="edit-btn-'.$row['proj_id'].'" class="btn btn-primary btn-edit" onclick="editProject('.$row['proj_id'].')">Edit</button>';
        if($row['proj_enabled'] == 1) {
            $projectsTable .= '<button id="dis-btn-'.$row['proj_id'].'" class="btn btn-danger" onclick="disableProject('.$row['proj_id'].')">Disable</button></td></tr>';
        }
        else {
            $projectsTable .= '<button id="ena-btn-'.$row['proj_id'].'" class="btn btn-success ena-btn" onclick="enableProject('.$row['proj_id'].')">Enable</button></td></tr>';
        }

    }

    $projectsTable .= '</tbody></table>';

    echo $projectsTable;
}

function saveNewProject() {
    global $connection;
    $name = $_POST['projName'];
    $date = $_POST['projDate'];
    $type = $_POST['projType'];
    $imgs = $_POST['projImgs'];
    $link = $_POST['projLink'];
    $desc = $_POST['projDesc'];

    $projInsert = "INSERT INTO project (proj_name, proj_date, proj_type, proj_desc, proj_link, proj_imgs)".
                    " VALUES ('$name', '$date', '$type', '$desc', '$link', '$imgs')";

    if(!mysql_query($projInsert, $connection)) {
        die("Error:".mysql_error());
    }
    echo 'success';
}

function loadImages($projID) {
    global $connection;
    $select = "SELECT * FROM project_imgs WHERE proj_id=$projID";

    if(!$result = mysql_query($select, $connection)) {
        die('Error:'.mysql_error());
    }

    return $result;
}

function updateImages($id, $paths) {
    global $connection;
    $images = explode(" ",$paths);

    foreach($images as $image) {
        $imgUpdate = "UPDATE project_imgs SET img_path='$image' WHERE proj_id=$id";
        if(!mysql_query($imgUpdate, $connection)) {
            die($imgUpdate);
        }
    }
}

function getProjectInfo() {
    global $connection;
    $id = $_POST['projID'];
    $output = array();
    $select = "SELECT * FROM project WHERE proj_id=$id";

    if(!$result = mysql_query($select, $connection)) {
        die('Error:'.mysql_error());
    }

    $thisProj = mysql_fetch_array($result);
    $data = json_encode($thisProj);
    echo $data;
}

function updateProject() {
    global $connection;
    $id = $_POST['projID'];
    $name = $_POST['projName'];
    $date = $_POST['projDate'];
    $type = $_POST['projType'];
    $imgs = $_POST['projImgs'];
    $link = $_POST['projLink'];
    $desc = $_POST['projDesc'];

    $projUpdate = "UPDATE project SET proj_name='$name', proj_date='$date', proj_type='$type', proj_link='$link', proj_desc='$desc'";
    $projUpdate .= ", proj_imgs='$imgs' WHERE proj_id=$id";

    if(!mysql_query($projUpdate, $connection)) {
        die("Error:".mysql_error());
    }

    echo 'success';
}

function changeProjStatus() {
    global $connection;
    $id = $_POST['projID'];
    $status = $_POST['status'];

    $projUpdate = "UPDATE project SET proj_enabled=$status WHERE proj_id=$id";
    if(!mysql_query($projUpdate, $connection)) {
        die("Error:".mysql_error());
    }
    echo 'success';
}
