<?php include('cms_controller.php'); ?>
<html>
<head>
    <title>Logan Martin - CMS</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/cms.css">
</head>
<body>

<div id="project-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
                <h4 class="modal-title">Enter Project Information:</h4>
            </div>
            <div class="modal-body">
                <div id="modal-alert" class="hidden"></div>
                <label id="proj-num">Project #<p id="projNum"></p></label>
                <div class="form-group">
                    <label for="projName" class="control-label">Name:</label>
                    <input type="text" class="form-control" id="projName">
                </div>
                <div class="form-group">
                    <label for="projDate" class="control-label">Date:</label>
                    <input type="text" class="form-control" id="projDate">
                </div>
                <div class="form-group">
                    <label for="projType" class="control-label">Type:</label>
                    <input type="text" class="form-control" id="projType">
                </div>
                <div class="form-group">
                    <label for="projLink" class="control-label">link:</label>
                    <input type="text" class="form-control" id="projLink">
                </div>
                <div class="form-group">
                    <label for="projImgs" class="control-label">Upload Images:</label>
                    <input type="text" class="form-control" id="projImgs">
                </div>
                <div class="form-group">
                    <label for="projDesc" class="control-label">Description:</label>
                    <textarea rows="3" cols="200" class="form-control" id="projDesc"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveProject()">Save Project</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div id="header">
        <button id="add-btn" class="btn btn-success btn-lg">+ Add Project</button>
        <h1>Portfolio CMS</h1>
    </div>
    <div id="projects-panel" class="panel panel-primary">
        <div class="panel-heading">Projects:</div>
        <div id="project-list-container" class="panel-body">
            <?php echo getProjects();?>
        </div>
    </div>
</div>


<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="js/cms.js"></script>
</body>
</html>