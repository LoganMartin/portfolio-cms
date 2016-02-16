/**
 *  cms.js
 *  javascript functions that handles our ajax transactions between the interface/database
 */

$(document).ready(function() {
    $("#add-btn").click(function() {
        clearProjectForm();
        $("#project-modal").modal('show');
    });
});

function clearProjectForm() {
    $("#projNum").html("");
    $("#projImgs").val("");
    $("#projName").val("");
    $("#projDate").val("");
    $("#projType").val("");
    $("#projLink").val("");
    $("#projDesc").val("");
}

//Sends project info to controller based on if it's new or updated information
function saveProject() {
    var filepaths = $("#projImgs").val();
    var name = $("#projName").val();
    var date = $("#projDate").val();
    var type = $("#projType").val();
    var link = $("#projLink").val();
    var desc = $("#projDesc").val();


    if($("#projNum").html() === "") {
        //Save New
        $.ajax({
            type: "POST",
            url: "cms_controller.php",
            data: {
                "action": "saveNewProject", "projName": name, "projDate": date,
                "projType": type, "projLink": link, "projDesc": desc, "projImgs": filepaths
            },
            success: function(data) {
                if(data=="success") {
                    alert("project saved successfully!");
                    clearProjectForm();
                    $("#project-modal").modal("hide");
                }
                else {
                    alert(data);
                }
            },
            error: function(xhr) {
                alert("An error occured: " + xhr.status + " " + xhr.statusText);
            }

        });
    }
    else{
        var projNum = $("#projNum").html();
        $.ajax({
            type: "POST",
            url: "cms_controller.php",
            data: {
                "action": "updateProject", "projID": projNum, "projName": name, "projDate": date,
                "projType": type, "projLink": link, "projDesc": desc, "projImgs": filepaths
            },
            success: function(data) {
                if(data=="success") {
                    alert("project udpated successfully!");
                    clearProjectForm();
                    $("#project-modal").modal("hide");
                }
                else {
                    alert(data);
                }
            },
            error: function(xhr) {
                alert("An error occured: " + xhr.status + " " + xhr.statusText);
            }

        });
    }
    refreshProjects();
}

function editProject(projID) {
    $.ajax({
        type: "POST",
        url: "cms_controller.php",
        data: {
            "action": "getProject", "projID": projID
        },
        success: function(data) {
            var info = JSON.parse(data);
            $("#projNum").html(info.proj_id);
            $("#projImgs").val(info.proj_imgs);
            $("#projName").val(info.proj_name);
            $("#projDate").val(info.proj_date);
            $("#projType").val(info.proj_type);
            $("#projLink").val(info.proj_link);
            $("#projDesc").val(info.proj_desc);
            $("#project-modal").modal('show');
        },
        error: function(xhr) {
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    });
}

function refreshProjects() {
    $.ajax({
        type: "POST",
        url: "cms_controller.php",
        data: {
            "action": "getProjects"
        },
        success: function(data) {
            $("#project-list-container").html(data);
        },
        error: function(xhr) {
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    });
}

function disableProject(projID) {
    $.ajax({
        type: "POST",
        url: "cms_controller.php",
        data: {
            "action": "changeProjStatus", "projID": projID, "status": 0
        },
        success: function(data) {
            if(data=="success") {
                refreshProjects();
            }
            else {
                alert(data);
            }
        },
        error: function(xhr) {
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    });
}

function enableProject(projID) {
    $.ajax({
        type: "POST",
        url: "cms_controller.php",
        data: {
            "action": "changeProjStatus", "projID": projID, "status": 1
        },
        success: function(data) {
            if(data=="success") {
                refreshProjects();
            }
            else {
                alert(data);
            }
        },
        error: function(xhr) {
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    });
}
