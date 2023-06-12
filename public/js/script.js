// the drag and drop events :
var nestedSortables = document.getElementById("main");
new Sortable(nestedSortables, {
    group: "shared",
    handle: ".handle-section",
    fallbackTolerance: 3,
    animation: 200,
    nested: true,
    onEnd: function (event) {
        // Get the updated positions of the sections
        console.log("nested Sortables :", nestedSortables);
        var sections = document.getElementsByClassName("section");
        console.log("sections :", sections);
        var sectionPositions = Array.from(sections).map(function (
            section,
            index
        ) {
            return {
                sectionId: section.dataset.sectionId,
                position: index + 1,
            };
        });
        console.log("Section Positions", sectionPositions);
        // Send the updated positions to the server
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: "/updateSectionPosition", // Update with the appropriate URL
            type: "PUT",
            dataType: "json",
            data: JSON.stringify(sectionPositions),
            contentType: "application/json",
            success: function (response) {
                console.log("Section positions updated successfully");
            },
            error: function (xhr, status, error) {
                console.error("Error updating section positions:", error);
            },
        });
    },
});

var nestedSortables = [].slice.call(document.querySelectorAll(".lesson-list"));
for (var i = 0; i < nestedSortables.length; i++) {
    new Sortable(nestedSortables[i], {
        group: "again",
        handle: ".handle",
        animation: 200,
        ghostClass: "selected",
        fallbackTolerance: 3,
        multiDrag: true,
        selectedClass: "selected",
        onEnd: function (event) {
            // Get the updated positions of the lessons within the section

            var sections = document.getElementsByClassName("section");
            var lessonPositions = [];

            Array.from(sections).forEach(function (section) {
                var lessons = section.getElementsByClassName("lesson");
                Array.from(lessons).forEach(function (lesson, index) {
                    var sectionId = section.dataset.sectionId;
                    var lessonId = lesson.dataset.lessonId;
                    lessonPositions.push({
                        sectionId: sectionId,
                        lessonId: lessonId,
                        position: index + 1,
                    });
                });
            });
            console.log(lessonPositions);
            // Send the updated positions to the server
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });
            $.ajax({
                url: "/updateLessonPosition", // Update with the appropriate URL
                type: "PUT",
                dataType: "json",
                data: JSON.stringify(lessonPositions),
                contentType: "application/json",
                success: function (response) {
                    console.log(
                        "Lesson positions updated successfully",
                        response
                    );
                },
                error: function (xhr, status, error) {
                    console.error("Error updating lesson positions:", error);
                },
            });
        },
    });
}

var cour = document.getElementById("btn").dataset.courId;
console.log("cour id : ", cour);
// creating the elemlents
document.getElementById("btn").addEventListener("click", function () {
    // create the ul element
    var newUls = document.createElement("ul");
    newUls.className = "section-list";

    // create the li element
    var newLi = document.createElement("li");
    newLi.className = "section card bg-light text-dark";

    //
    var header = document.createElement("div");
    header.className = "d-flex justify-content-between header";
    var div = document.createElement("div");
    div.className = "d-flex flex-row align-items-baseline";

    // create the icon handler:
    var newIcon = document.createElement("i");
    newIcon.className = "fa fa-bars handle-section";
    // create the div element
    var newDiv = document.createElement("div");
    newDiv.id = "section-box";
    newDiv.className = "d-flex align-items-center";
    newDiv.innerHTML =
        "<input value='New Section' class='form-control form-control-lg m-2 border border-dark input-section' type='text' ><button class='btn btn-primary me-2 button save-button_sec d-box'>Save</button><a href='' class='btn btn-secondary button d-box me-2' >Cancel</a>";

    // create the button to add a lesson:
    var newBtn = document.createElement("button");
    newBtn.id = "btn-el";
    newBtn.className = "btn btn-outline-dark";
    newBtn.innerHTML = "+ Add Lesson";

    // create the ul that will take the lessons
    var newUl = document.createElement("ul");
    newUl.className = "lesson-list";

    // add all the elements to the ul element with id section-list.
    var section_item = document.getElementById("main");

    // var lastSection = document.getElementById("body");
    section_item.appendChild(newUls);
    newUls.appendChild(newLi);
    newLi.append(header, newUl);
    header.appendChild(div);
    div.append(newIcon, newDiv);
    newUl.appendChild(newBtn);

    new Sortable(newUl, {
        group: "again",
        handle: ".handle",
        animation: 200,
        ghostClass: "selected",
        fallbackTolerance: 3,
        multiDrag: true,
        selectedClass: "selected",
        onEnd: function (event) {
            // Get the updated positions of the lessons within the section

            var sections = document.getElementsByClassName("section");
            var lessonPositions = [];

            Array.from(sections).forEach(function (section) {
                var lessons = section.getElementsByClassName("lesson");
                Array.from(lessons).forEach(function (lesson, index) {
                    var sectionId = section.dataset.sectionId;
                    var lessonId = lesson.dataset.lessonId;
                    lessonPositions.push({
                        sectionId: sectionId,
                        lessonId: lessonId,
                        position: index + 1,
                    });
                });
            });
            console.log(lessonPositions);
            // Send the updated positions to the server
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });
            $.ajax({
                url: "/updateLessonPosition", // Update with the appropriate URL
                type: "PUT",
                dataType: "json",
                data: JSON.stringify(lessonPositions),
                contentType: "application/json",
                success: function (response) {
                    console.log(
                        "Lesson positions updated successfully",
                        response
                    );
                },
                error: function (xhr, status, error) {
                    console.error("Error updating lesson positions:", error);
                },
            });
        },
    });

    var newInputSection = newDiv.querySelector(".input-section");
    newInputSection.focus();
    newInputSection.select();
    // Add event listener for "Enter" key press
    newInputSection.addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent form submission

            var saveButton = newDiv.querySelector(".save-button_sec");
            saveButton.click(); // Trigger click event on the save button
        }
    });
    newLi.scrollIntoView({ behavior: "smooth", block: "center" });
    // Get the section name from the input field
    var sectionName = newInputSection.value;
    var sectionPosition = section_item.querySelectorAll(".section-list").length;
    console.log("existing sections", sectionPosition);

    // ...

    // Create an object with the section data
    var sectionData = {
        sectionName: sectionName,
        position: sectionPosition,
        courId: cour, // Assign the position
    };

    var sectionId;
    console.log("section Name : ", sectionName);
    console.log("section Position : ", sectionPosition);
    // Send the section data to the server
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: "/saveSection", // Update with the appropriate URL
        type: "POST",
        dataType: "json",
        data: JSON.stringify(sectionData),
        contentType: "application/json",
        success: function (response) {
            // Handle the response from the server
            sectionId = response.sectionId;
            console.log("section saved successfully", sectionId);
            newLi.setAttribute("data-section-id", sectionId);
            newLi.setAttribute("data-section-name", sectionName);
            newBtn.addEventListener("click", function () {
                // create the li element
                var newLi1 = document.createElement("li");
                newLi1.className = "d-flex justify-content-between card lesson";
                newLi1.style =
                    "display:flex;flex-direction:row ;background-color:  rgba(231, 235, 240, 0.795);";
                // var header = document.createElement("div");
                // header.className = "header d-flex justify-content-between";
                //create the div that contains the icon in the input Or lesson_name
                var div = document.createElement("div");
                div.className = "d-flex flex-row align-items-baseline";

                // create the icon and the title of the lesson as a span:
                var newIcon1 = document.createElement("i");
                newIcon1.className = "fa fa-bars handle";
                // create the div element
                var newDiv1 = document.createElement("div");
                newDiv1.id = "lesson-box";
                newDiv1.className = "d-flex align-items-center";
                newDiv1.innerHTML =
                    "<input value='New Lesson' class='form-control input m-2 border border-dark' type='text'><button class='btn btn-primary me-2 save-button'>Save</button><a href='' class='btn btn-secondary cancel-button'>Cancel</a>";
                // add all the elements to the ul element with id section-list.
                var currentLi = newUl.parentElement;
                var lessonList =
                    currentLi.getElementsByClassName("lesson-list");
                var lastLesson = lessonList[lessonList.length - 1];
                lastLesson.appendChild(newLi1);
                newLi1.appendChild(div);
                div.append(newIcon1, newDiv1);
                // newDiv1.append(newInput, newBtn1, newBtn2);
                var newInput = newDiv1.querySelector(".input");
                newInput.focus();
                newInput.select();
                // Add event listener for "Enter" key press
                newInput.addEventListener("keydown", function (event) {
                    if (event.key === "Enter") {
                        event.preventDefault(); // Prevent form submission

                        var saveButton = newDiv1.querySelector(".save-button");
                        saveButton.click(); // Trigger click event on the save button
                    }
                });
                newLi1.scrollIntoView({ behavior: "smooth", block: "center" });
                // Get the lesson name from the input field

                var lessonName = newInput.value;
                console.log(lessonName);
                console.log(sectionId);
                // Create an object with the lesson data

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                });
                var lessonPosition = newUl.querySelectorAll(".lesson").length;

                // Create an object with the lesson data
                var lessonData = {
                    lessonName: lessonName,
                    sectionId: sectionId,
                    position: lessonPosition, // Assign the position
                };
                var lessonId;
                // Send the lesson data to the server

                $.ajax({
                    url: "/saveLesson", // Update with the appropriate URL
                    type: "POST",
                    dataType: "json",
                    data: JSON.stringify(lessonData),
                    contentType: "application/json",
                    success: function (response) {
                        // Handle the response from the server
                        lessonId = response.lessonId;
                        console.log("Lesson saved", lessonId);
                        newLi1.setAttribute("data-lesson-id", lessonId);
                        newLi1.setAttribute("data-lesson-name", lessonName);
                    },
                    error: function (xhr, status, error) {
                        // Handle any errors
                        console.log("xhr", xhr);
                        console.log("status", status);
                        console.error("Error saving lesson:", error);
                    },
                });

                var buttons = document.querySelectorAll(".save-button");
                buttons.forEach(function (button) {
                    button.addEventListener("click", function () {
                        var row = button.parentNode;
                        var nameInput = row.querySelector(".input");
                        var name = nameInput.value;
                        var Parent_Li = row.closest(".lesson");
                        newLi1.setAttribute("data-lesson-name", name);

                        // Create an object to send the data
                        var link = document.createElement("a");
                        link.href = "#";
                        link.textContent = name;
                        link.id = "lesson-link";
                        link.className = "card-title ms-1";
                        link.style =
                            "text-decoration:none;color:rgb(81, 84, 90);margin-left=1px;";
                        link.setAttribute("data-bs-toggle", "modal");
                        link.setAttribute(
                            "data-bs-target",
                            "#deleteLesson" + lessonId
                        );
                        var dropdown = document.createElement("div");
                        dropdown.className = "dropDownL";
                        dropdown.innerHTML =
                            "<span id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-ellipsis-v info'></i></span><ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1' style='padding: 0%'><li><button type='button' class='btn btn-primary dropdown-item edit-lesson' >Edit</button></li><li><button class='btn btn-danger dropdown-item delete' data-bs-toggle='modal'>Delete</button></li></ul>";
                        var deleteBtn = dropdown.querySelector(".delete");
                        console.log("delete btn : ", deleteBtn);
                        deleteBtn.setAttribute(
                            "data-bs-target",
                            "#deleteLesson" + lessonId
                        );
                        console.log("delete btn : ", deleteBtn);
                        var modal = document.createElement("div");
                        modal.className = "modal fade";
                        modal.id = "deleteLesson" + lessonId;
                        modal.setAttribute("data-lesson-id", lessonId);
                        modal.setAttribute("tabindex", "-1");
                        modal.setAttribute(
                            "aria-labelledby",
                            "exampleModalLabel"
                        );
                        modal.setAttribute("aria-hidden", "true");
                        modal.innerHTML = `<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">Supprimer Un Leçon</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><p>Voulez-vous Supprimez Le Leçcon ?</p></div><div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button><button type="button" class="btn btn-danger delete-lesson">Suppimer</button></div></div></div>`;
                        deleteBtn.addEventListener("click", function () {
                            var myModal = new bootstrap.Modal(modal);
                            myModal.show();
                        });
                        ///////////////////////////////////////

                        var modal2 = document.createElement("div");
                        modal2.className = "modal fade";
                        modal2.id = "addContentModal" + lessonId;
                        modal2.setAttribute("data-lesson-id", lessonId);
                        modal2.setAttribute("tabindex", "-1");
                        modal2.setAttribute(
                            "aria-labelledby",
                            "exampleModalLabel"
                        );
                        modal2.setAttribute("aria-hidden", "true");

                        var modal2 = document.createElement("div");
                        modal2.className = "modal fade";
                        modal2.id = "addContentModal" + lessonId;
                        modal2.setAttribute("data-lesson-id", lessonId);
                        modal2.setAttribute("tabindex", "-1");
                        modal2.setAttribute(
                            "aria-labelledby",
                            "exampleModalLabel"
                        );
                        modal2.setAttribute("aria-hidden", "true");
                        // Create the outermost div element

                        // Create the modal-dialog div element
                        var dialogDiv = document.createElement("div");
                        dialogDiv.className = "modal-dialog";
                        dialogDiv.setAttribute("role", "document");

                        // Create the modal-content div element
                        var contentDiv = document.createElement("div");
                        contentDiv.className = "modal-content";

                        // Create the modal-header div element
                        var headerDiv = document.createElement("div");
                        headerDiv.className = "modal-header";

                        // Create the h5 element for the modal title
                        var titleH5 = document.createElement("h5");
                        titleH5.className = "modal-title";
                        titleH5.id = "addContentModalLabel" + lessonId;
                        titleH5.textContent = "Add Content for " + lessonId;

                        // Create the button element for closing the modal
                        var closeButton = document.createElement("button");
                        closeButton.type = "button";
                        closeButton.className = "btn-close";
                        closeButton.setAttribute("data-bs-dismiss", "modal");
                        closeButton.setAttribute("aria-label", "Close");

                        // Append the title and close button to the header div
                        headerDiv.appendChild(titleH5);
                        headerDiv.appendChild(closeButton);

                        // Create the modal-body div element
                        var bodyDiv = document.createElement("div");
                        bodyDiv.className = "modal-body";

                        // Create the ul element for the content list
                        var ul = document.createElement("ul");
                        ul.className = "content-list d-flex";

                        // Create the first li element for adding a video
                        var videoLi = document.createElement("li");
                        videoLi.className = "m-4";
                        var videoLink = document.createElement("a");
                        videoLink.className = "btn btn-success";
                        videoLink.href = "/videos/create/" + lessonId;
                        var videoIcon = document.createElement("i");
                        videoIcon.className = "fa fa-video-camera me-2";
                        videoLink.append(videoIcon, "Add Video");
                        // videoLink.textContent = " Add Video";
                        videoLi.appendChild(videoLink);
                        ul.appendChild(videoLi);

                        // Create the second li element for adding a quiz
                        var quizLi = document.createElement("li");
                        quizLi.className = "m-4";
                        var quizLink = document.createElement("a");
                        quizLink.className = "btn btn-primary";
                        quizLink.href = "/admin/quizzes/create/" + lessonId;
                        var quizIcon = document.createElement("i");
                        quizIcon.className = "fa fa-question-circle me-2";
                        quizLink.append(quizIcon, "Add Quiz");
                        quizLi.appendChild(quizLink);
                        ul.appendChild(quizLi);

                        // Append the ul to the modal-body div
                        bodyDiv.appendChild(ul);

                        // Append the header and body divs to the modal-content div
                        contentDiv.appendChild(headerDiv);
                        contentDiv.appendChild(bodyDiv);

                        // Append the modal-content div to the modal-dialog div
                        dialogDiv.appendChild(contentDiv);

                        // Append the modal-dialog div to the outermost div
                        modal2.appendChild(dialogDiv);

                        link.addEventListener("click", function () {
                            var myModal = new bootstrap.Modal(modal2);
                            myModal.show();
                        });
                        ////////////////////////////////////////////////:
                        row.replaceWith(link);
                        Parent_Li.appendChild(dropdown, modal);

                        console.log("lesson id : ", lessonId);
                        console.log("lesson name :", name);
                        $.ajax({
                            url: "/lessons/" + lessonId,
                            type: "PUT",
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),
                            },
                            dataType: "json",
                            data: {
                                name: name,
                            },
                            success: function (data) {
                                // Update the section name in the UI
                                console.log("successful update lesson name");
                                var edit =
                                    dropdown.querySelector(".edit-lesson");
                                edit.addEventListener("click", function () {
                                    var link = edit
                                        .closest(".lesson")
                                        .querySelector("#lesson-link");
                                    console.log("edit : ", edit);
                                    var newDiv = document.createElement("div");
                                    newDiv.id = "lesson-box";
                                    var dropDown = edit.closest(".dropDownL");
                                    console.log("dropdown : ", dropDown);
                                    // newDiv.style = "display: inline;";
                                    newDiv.className =
                                        "d-flex align-items-center";
                                    var less = edit.closest(".lesson");
                                    console.log("lesson : ", less);
                                    var lesson_name = less.dataset.lessonName;
                                    var lessonId = less.dataset.lessonId;

                                    console.log("lesson_name : ", lesson_name);
                                    var newInput =
                                        document.createElement("input");
                                    newInput.className =
                                        "form-control input m-2 border border-dark";
                                    newInput.type = "text";
                                    newInput.value = lesson_name;
                                    var saveBtn =
                                        document.createElement("button");
                                    saveBtn.className =
                                        "btn btn-primary button save-button me-2";
                                    saveBtn.textContent = "Save";
                                    var cancelBtn = document.createElement("a");
                                    cancelBtn.href = "";
                                    cancelBtn.className =
                                        "btn btn-secondary button cancel-button me-2";
                                    cancelBtn.textContent = "Cancel";
                                    var div = link.parentElement;
                                    div.className =
                                        "d-flex flex-row align-items-baseline";
                                    console.log(link);
                                    dropDown.remove();
                                    newInput.addEventListener(
                                        "keydown",
                                        function (event) {
                                            if (event.key === "Enter") {
                                                event.preventDefault(); // Prevent form submission

                                                var saveButton =
                                                    newDiv.querySelector(
                                                        ".save-button"
                                                    );
                                                saveButton.click(); // Trigger click event on the save button
                                            }
                                        }
                                    );
                                    newDiv.append(newInput, saveBtn, cancelBtn);
                                    link.replaceWith(newDiv);
                                    newInput.focus();
                                    newInput.select();

                                    var buttons =
                                        document.querySelectorAll(
                                            ".save-button"
                                        );
                                    buttons.forEach(function (button) {
                                        button.addEventListener(
                                            "click",
                                            function () {
                                                var row = button.parentNode;
                                                var name = newInput.value;

                                                // Create an object to send the data
                                                var link =
                                                    document.createElement("a");
                                                link.href = "#";
                                                link.textContent = name;
                                                link.id = "lesson-link";
                                                link.className =
                                                    "card-title ms-1";
                                                link.style =
                                                    "text-decoration:none;color:rgb(81, 84, 90);margin-left=1px;";
                                                var dropdown =
                                                    document.createElement(
                                                        "div"
                                                    );
                                                dropdown.className =
                                                    "dropDownL";

                                                dropdown.innerHTML =
                                                    "<span id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-ellipsis-v info'></i></span><ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1' style='padding:0%'><li><button class='btn btn-primary dropdown-item edit-lesson' >Edit</button></li><li><button class='btn btn-danger dropdown-item delete-lesson' >Delete</button></li></ul>";

                                                row.replaceWith(link);
                                                less.appendChild(dropdown);

                                                console.log(
                                                    "lesson id : ",
                                                    lessonId
                                                );
                                                console.log(
                                                    "lesson name :",
                                                    name
                                                );
                                                $.ajax({
                                                    url: "/lessons/" + lessonId,
                                                    type: "PUT",
                                                    headers: {
                                                        "X-CSRF-TOKEN": $(
                                                            'meta[name="csrf-token"]'
                                                        ).attr("content"),
                                                    },
                                                    dataType: "json",
                                                    data: {
                                                        name: name,
                                                    },
                                                    success: function (data) {
                                                        // Update the section name in the UI
                                                        console.log(
                                                            "suuccessuful update lesson name"
                                                        );
                                                        location.reload();
                                                    },
                                                    error: function (error) {
                                                        console.error(error);
                                                    },
                                                });
                                            }
                                        );
                                    });
                                });
                                var deleteBtn =
                                    modal.querySelector(".delete-lesson");
                                deleteBtn.addEventListener(
                                    "click",
                                    function () {
                                        var lessonId =
                                            Parent_Li.dataset.lessonId;
                                        console.log("lesson id : ", lessonId);
                                        console.log(
                                            "CSRF token",
                                            $('meta[name="csrf-token"]').attr(
                                                "content"
                                            )
                                        );

                                        $.ajax({
                                            url: "/lessons/delete/" + lessonId,
                                            type: "DELETE",
                                            headers: {
                                                "X-CSRF-TOKEN": $(
                                                    'meta[name="csrf-token"]'
                                                ).attr("content"),
                                            },
                                            dataType: "json",
                                            data: {
                                                lessonId: lessonId,
                                            },
                                            success: function (
                                                xhr,
                                                status,
                                                response
                                            ) {
                                                // Update the section name in the UI

                                                console.log(
                                                    "suuccessuful delete lesson"
                                                );
                                                $(
                                                    "#deleteLesson" + lessonId
                                                ).modal("hide");
                                                Parent_Li.remove();
                                                var sections =
                                                    document.getElementsByClassName(
                                                        "section"
                                                    );
                                                var lessonPositions = [];

                                                Array.from(sections).forEach(
                                                    function (section) {
                                                        var lessons =
                                                            section.getElementsByClassName(
                                                                "lesson"
                                                            );
                                                        Array.from(
                                                            lessons
                                                        ).forEach(function (
                                                            lesson,
                                                            index
                                                        ) {
                                                            var sectionId =
                                                                section.dataset
                                                                    .sectionId;
                                                            var lessonId =
                                                                lesson.dataset
                                                                    .lessonId;
                                                            lessonPositions.push(
                                                                {
                                                                    sectionId:
                                                                        sectionId,
                                                                    lessonId:
                                                                        lessonId,
                                                                    position:
                                                                        index +
                                                                        1,
                                                                }
                                                            );
                                                        });
                                                    }
                                                );
                                                console.log(lessonPositions);
                                                // Send the updated positions to the server
                                                $.ajaxSetup({
                                                    headers: {
                                                        "X-CSRF-TOKEN": $(
                                                            'meta[name="csrf-token"]'
                                                        ).attr("content"),
                                                    },
                                                });
                                                $.ajax({
                                                    url: "/updateLessonPosition", // Update with the appropriate URL
                                                    type: "PUT",
                                                    dataType: "json",
                                                    data: JSON.stringify(
                                                        lessonPositions
                                                    ),
                                                    contentType:
                                                        "application/json",
                                                    success: function (
                                                        response
                                                    ) {
                                                        console.log(
                                                            "Lesson positions updated successfully",
                                                            response
                                                        );
                                                    },
                                                    error: function (
                                                        xhr,
                                                        status,
                                                        error
                                                    ) {
                                                        console.error(
                                                            "Error updating lesson positions:",
                                                            error
                                                        );
                                                    },
                                                });

                                                console.log(
                                                    "response : ",
                                                    response
                                                );
                                            },
                                            error: function (
                                                xhr,
                                                status,
                                                error
                                            ) {
                                                console.log("xhr", xhr);
                                                console.log("status", status);
                                                console.error(
                                                    "Error deleting lesson:",
                                                    error
                                                );
                                            },
                                        });
                                    }
                                );

                                // location.reload();
                                // console.log("reloaded");
                            },
                            error: function (error) {
                                console.error(error);
                            },
                        });
                    });
                });
            });
        },

        error: function (xhr, status, error) {
            // Handle any errors
            console.log("xhr", xhr);
            console.log("status", status);
            console.error("Error saving section:", error);
        },
    });

    // ///////////////////////////////////////////////////////////////::
    // to save the name of the section inserted by the user
    var buttons1 = document.querySelectorAll(".save-button_sec");
    buttons1.forEach(function (button) {
        button.addEventListener("click", function () {
            var row = button.parentElement;
            var header = row.closest(".header");
            var span = document.createElement("span");
            span.className = "card-title section-title";
            span.style = "font-size: 30px;margin-left: 5px;";
            var sectionNm = newInputSection.value;
            span.textContent = sectionNm;
            var dropdown = document.createElement("div");
            dropdown.className = "dropDown";
            dropdown.innerHTML =
                "<span id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-ellipsis-v info-section'></i></span><ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1' style='padding: 0%'><li><button class='btn btn-primary dropdown-item edit-section' >Edit</button></li><li><button class='btn btn-danger dropdown-item deleteS' data-bs-toggle='modal' >Delete</button></li></ul>";
            var deleteBtn = dropdown.querySelector(".deleteS");
            deleteBtn.setAttribute(
                "data-bs-target",
                "#deleteSection" + sectionId
            );
            console.log("delete btn : ", deleteBtn);
            var modal = document.createElement("div");
            modal.className = "modal fade";
            modal.id = "deleteSection" + sectionId;
            modal.setAttribute("data-lesson-id", sectionId);
            modal.setAttribute("tabindex", "-1");
            modal.setAttribute("aria-labelledby", "exampleModalLabel");
            modal.setAttribute("aria-hidden", "true");
            modal.innerHTML =
                "<div class='modal-dialog'><div class='modal-content'><div class='modal-header'><h5 class='modal-title' id='exampleModalLabel'>Supprimer Une Section</h5><button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button></div><div class='modal-body'><p>Voulez-vous Supprimez La Section ?</p></div><div class='modal-footer'><button type='button'class='btn btn-outline-secondary'data-bs-dismiss='modal'>Close</button><button type='button'class='btn btn-danger delete-section'>Suppimer</button></div></div></div>";
            deleteBtn.addEventListener("click", function () {
                var myModal = new bootstrap.Modal(modal);
                myModal.show();
            });
            row.replaceWith(span);
            header.appendChild(dropdown, modal);
            var li = header.parentElement;
            li.setAttribute("data-section-name", sectionNm);
            console.log("section id for update : ", sectionId);
            $.ajax({
                url: "/sections/" + sectionId,
                type: "PUT",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                dataType: "json",
                data: {
                    name: sectionNm,
                },
                success: function (data) {
                    // Update the section name in the UI
                    console.log("suuccessuful update section name again");
                    var edit = dropdown.querySelector(".edit-section");
                    var deleteSec = modal.querySelector(".delete-section");
                    console.log("section", li);
                    console.log("header", header);
                    console.log("button", edit);
                    console.log("button delete", deleteSec);
                    console.log("modal", modal);

                    edit.addEventListener("click", function () {
                        var span = edit
                            .closest(".header")
                            .querySelector(".section-title");
                        var newDiv = document.createElement("div");
                        newDiv.id = "section-box";

                        var dropDown = edit.closest(".dropDown");

                        newDiv.className = "d-flex align-items-center";
                        var sec = edit.closest(".section");
                        var section_name = sec.dataset.sectionName;
                        console.log("section_name : ", section_name);
                        var newInput = document.createElement("input");
                        newInput.className =
                            "form-control form-control-lg m-2 border border-dark input-section";
                        newInput.type = "text";
                        newInput.value = section_name;
                        var saveBtn = document.createElement("button");
                        saveBtn.className =
                            "btn btn-primary button save-button_sec me-2";
                        saveBtn.textContent = "Save";
                        var cancelBtn = document.createElement("a");
                        cancelBtn.href = "";
                        cancelBtn.className =
                            "btn btn-secondary button cancel-button_sec me-2";
                        cancelBtn.textContent = "Cancel";
                        var div = span.parentElement;
                        div.className = "d-flex flex-row align-items-baseline";
                        console.log("span", span);
                        newInput.addEventListener("keydown", function (event) {
                            if (event.key === "Enter") {
                                event.preventDefault(); // Prevent form submission

                                var saveButton =
                                    newDiv.querySelector(".save-button_sec");
                                saveButton.click(); // Trigger click event on the save button
                            }
                        });
                        dropDown.remove();
                        newDiv.append(newInput, saveBtn, cancelBtn);
                        span.replaceWith(newDiv);
                        newInput.focus();
                        newInput.select();
                        var buttons1 =
                            document.querySelectorAll(".save-button_sec");
                        buttons1.forEach(function (button) {
                            button.addEventListener("click", function () {
                                var row = button.parentElement;
                                var header = row.closest(".header");
                                var section = header.parentElement;
                                var sectionId = section.dataset.sectionId;
                                var span = document.createElement("span");
                                span.className = "card-title section-title";
                                span.style =
                                    "font-size: 30px;margin-left: 5px;";

                                var sectionNm = newInput.value;
                                span.textContent = sectionNm;
                                var dropdown = document.createElement("div");
                                dropdown.className = "dropDown";
                                dropdown.innerHTML =
                                    "<span id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-ellipsis-v info-section'></i></span><ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'><li><button class='dropdown-item edit-section' >Edit</button></li><li><button class='dropdown-item deleteS' data-bs-toggle='modal' >Delete</button></li></ul>";
                                var deleteBtn =
                                    dropdown.querySelector(".deleteS");
                                deleteBtn.setAttribute(
                                    "data-bs-target",
                                    "#deleteSection" + sectionId
                                );
                                deleteBtn.addEventListener(
                                    "click",
                                    function () {
                                        $("#deleteSection" + sectionId).modal(
                                            "show"
                                        );
                                    }
                                );
                                row.replaceWith(span);
                                header.appendChild(dropdown);
                                console.log(
                                    "section id for update : ",
                                    sectionId
                                );
                                $.ajax({
                                    url: "/sections/" + sectionId,
                                    type: "PUT",
                                    headers: {
                                        "X-CSRF-TOKEN": $(
                                            'meta[name="csrf-token"]'
                                        ).attr("content"),
                                    },
                                    dataType: "json",
                                    data: {
                                        name: sectionNm,
                                    },
                                    success: function (data) {
                                        // Update the section name in the UI
                                        console.log(
                                            "suuccessuful update section name"
                                        );
                                        location.reload();
                                    },
                                    error: function (xhr, status, error) {
                                        console.log("xhr", xhr);
                                        console.log("status", status);
                                        console.error(
                                            "Error saving section:",
                                            error
                                        );
                                    },
                                });
                            });
                        });
                    });
                    deleteSec.addEventListener("click", function () {
                        console.log("section : ", li);
                        var sectionId = li.dataset.sectionId;
                        console.log("section id : ", sectionId);

                        $.ajax({
                            url: "/sections/delete/" + sectionId,
                            type: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),
                            },
                            dataType: "json",
                            data: {
                                sectionId: sectionId,
                            },
                            success: function (data) {
                                // Update the section name in the UI
                                console.log("suuccessuful section delete");
                                $("#deleteSection" + sectionId).modal("hide");
                                li.remove();
                                var sections =
                                    document.getElementsByClassName("section");
                                console.log("sections :", sections);
                                var sectionPositions = Array.from(sections).map(
                                    function (section, index) {
                                        return {
                                            sectionId:
                                                section.dataset.sectionId,
                                            position: index + 1,
                                        };
                                    }
                                );
                                console.log(
                                    "Section Positions",
                                    sectionPositions
                                );
                                // Send the updated positions to the server
                                $.ajaxSetup({
                                    headers: {
                                        "X-CSRF-TOKEN": $(
                                            'meta[name="csrf-token"]'
                                        ).attr("content"),
                                    },
                                });
                                $.ajax({
                                    url: "/updateSectionPosition", // Update with the appropriate URL
                                    type: "PUT",
                                    dataType: "json",
                                    data: JSON.stringify(sectionPositions),
                                    contentType: "application/json",
                                    success: function (response) {
                                        console.log(
                                            "Section positions updated successfully"
                                        );
                                    },
                                    error: function (xhr, status, error) {
                                        console.error(
                                            "Error updating section positions:",
                                            error
                                        );
                                    },
                                });

                                // console.log("response : ", response);
                                location.reload();
                            },
                            error: function (xhr, status, error) {
                                console.log("xhr", xhr);
                                console.log("status", status);
                                console.error("Error saving section:", error);
                            },
                        });
                    });
                },
                error: function (xhr, status, error) {
                    console.log("xhr", xhr);
                    console.log("status", status);
                    console.error("Error saving section:", error);
                },
            });
        });
    });
});

//exists already
// section Update and delete :
var editBtns = document.querySelectorAll(".edit-section");
editBtns.forEach(function (btn) {
    btn.addEventListener("click", function () {
        var span = btn.closest(".header").querySelector(".section-title");
        var newDiv = document.createElement("div");
        newDiv.id = "section-box";
        newDiv.className = "d-flex align-items-center";
        var dropDown = btn.closest(".dropDown");
        var sec = btn.closest(".section");
        var section_name = sec.dataset.sectionName;
        console.log("section_name : ", section_name);
        var newInput = document.createElement("input");
        newInput.className =
            "form-control form-control-lg m-2 border border-dark input-section";
        newInput.type = "text";
        newInput.value = section_name;
        var saveBtn = document.createElement("button");
        saveBtn.className = "btn btn-primary button save-button_sec me-2";
        saveBtn.textContent = "Save";
        var cancelBtn = document.createElement("a");
        cancelBtn.href = "";
        cancelBtn.className = "btn btn-secondary button cancel-button_sec me-2";
        cancelBtn.textContent = "Cancel";
        console.log(span);
        var div = span.parentElement;
        div.className = "d-flex flex-row align-items-baseline";
        dropDown.remove();
        newDiv.append(newInput, saveBtn, cancelBtn);
        newInput.addEventListener("keydown", function (event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Prevent form submission

                var saveButton = newDiv.querySelector(".save-button_sec");
                saveButton.click(); // Trigger click event on the save button
            }
        });
        span.replaceWith(newDiv);
        newInput.focus();
        newInput.select();
        var buttons1 = document.querySelectorAll(".save-button_sec");
        buttons1.forEach(function (button) {
            button.addEventListener("click", function () {
                var row = button.parentElement;
                var header = row.closest(".header");
                var section = header.parentElement;
                var sectionId = section.dataset.sectionId;
                var span = document.createElement("span");
                span.className = "card-title section-title";
                span.style = "font-size: 30px;margin-left: 5px;";

                var sectionNm = newInput.value;
                span.textContent = sectionNm;
                var dropdown = document.createElement("div");
                dropdown.className = "dropDown";
                dropdown.innerHTML =
                    "<span id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-ellipsis-v info-section'></i></span><ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1' style:'padding:0%'><li><button class='btn btn-primary dropdown-item edit-section' >Edit</button></li><li><button class='btn btn-danger dropdown-item deleteS' data-bs-toggle='modal' >Delete</button></li></ul>";
                var deleteBtn = dropdown.querySelector(".deleteS");
                deleteBtn.setAttribute(
                    "data-bs-target",
                    "#deleteSection" + sectionId
                );
                deleteBtn.addEventListener("click", function () {
                    $("#deleteSection" + sectionId).modal("show");
                });
                row.replaceWith(span);
                header.appendChild(dropdown);
                console.log("section id for update : ", sectionId);
                $.ajax({
                    url: "/sections/" + sectionId,
                    type: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    dataType: "json",
                    data: {
                        name: sectionNm,
                    },
                    success: function (data) {
                        // Update the section name in the UI
                        console.log("suuccessuful update section name");
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.log("xhr", xhr);
                        console.log("status", status);
                        console.error("Error saving section:", error);
                    },
                });
            });
        });
    });
});
var deleteBtns = document.querySelectorAll(".delete-section");
deleteBtns.forEach(function (btn) {
    btn.addEventListener("click", function () {
        var section = btn.closest(".section");
        var sectionId = section.dataset.sectionId;
        console.log("section id : ", sectionId);
        console.log("CSRF token", $('meta[name="csrf-token"]').attr("content"));

        $.ajax({
            url: "/sections/delete/" + sectionId,
            type: "DELETE",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            data: {
                sectionId: sectionId,
            },
            success: function (xhr, status, response) {
                // Update the section name in the UI

                console.log("suuccessuful delete section");
                // location.reload();
                $("#deleteSection" + sectionId).modal("hide");
                section.remove();
                var sections = document.getElementsByClassName("section");
                console.log("sections :", sections);
                var sectionPositions = Array.from(sections).map(function (
                    section,
                    index
                ) {
                    return {
                        sectionId: section.dataset.sectionId,
                        position: index + 1,
                    };
                });
                console.log("Section Positions", sectionPositions);
                // Send the updated positions to the server
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                });
                $.ajax({
                    url: "/updateSectionPosition", // Update with the appropriate URL
                    type: "PUT",
                    dataType: "json",
                    data: JSON.stringify(sectionPositions),
                    contentType: "application/json",
                    success: function (response) {
                        console.log("Section positions updated successfully");
                    },
                    error: function (xhr, status, error) {
                        console.error(
                            "Error updating section positions:",
                            error
                        );
                    },
                });
                console.log("response : ", response);
            },
            error: function (xhr, status, error) {
                console.log("xhr", xhr);
                console.log("status", status);
                console.error("Error deleting section:", error);
            },
        });
    });
});

// lesson Update and delete :
var editBtnsL = document.querySelectorAll(".edit-lesson");
editBtnsL.forEach(function (btn) {
    btn.addEventListener("click", function () {
        var link = btn.closest(".lesson").querySelector("#lesson-link");
        console.log("btn : ", btn);
        var newDiv = document.createElement("div");
        newDiv.id = "lesson-box";
        var dropDown = btn.closest(".dropDownL");
        console.log("dropdown : ", dropDown);
        newDiv.className = "d-flex align-items-center";
        var less = btn.closest(".lesson");
        console.log("lesson : ", less);
        var lesson_name = less.dataset.lessonName;
        var lessonId = less.dataset.lessonId;

        console.log("lesson_name : ", lesson_name);
        var newInput = document.createElement("input");
        newInput.className = "form-control input m-2 border border-dark";
        newInput.type = "text";
        newInput.value = lesson_name;
        var saveBtn = document.createElement("button");
        saveBtn.className = "btn btn-primary button save-button me-2";
        saveBtn.textContent = "Save";
        var cancelBtn = document.createElement("a");
        cancelBtn.href = "";
        cancelBtn.className = "btn btn-secondary button cancel-button me-2";
        cancelBtn.textContent = "Cancel";
        console.log(link);
        var div = link.parentElement;
        div.className = "d-flex flex-row align-items-baseline";
        dropDown.remove();
        newDiv.append(newInput, saveBtn, cancelBtn);
        newInput.addEventListener("keydown", function (event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Prevent form submission

                var saveButton = newDiv.querySelector(".save-button");
                saveButton.click(); // Trigger click event on the save button
            }
        });
        link.replaceWith(newDiv);
        newInput.focus();
        newInput.select();
        //
        var buttons = document.querySelectorAll(".save-button");
        buttons.forEach(function (button) {
            button.addEventListener("click", function () {
                var row = button.parentNode;
                var name = newInput.value;

                // Create an object to send the data
                var link = document.createElement("a");
                link.href = "#";
                link.textContent = name;
                link.id = "lesson-link";
                link.className = "card-title ms-1";
                link.style =
                    "text-decoration:none;color:rgb(81, 84, 90);margin-left=1px;";
                var dropdown = document.createElement("div");
                dropdown.className = "dropDownL";

                dropdown.innerHTML =
                    "<span id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-ellipsis-v info'></i></span><ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'><li><button class='dropdown-item edit-lesson' >Edit</button></li><li><button class='dropdown-item delete' data-bs-toggle='modal'>Delete</button></li></ul>";
                var deleteBtn = dropdown.querySelector(".delete");
                deleteBtn.setAttribute(
                    "data-bs-target",
                    "#deleteLesson" + lessonId
                );
                deleteBtn.addEventListener("click", function () {
                    $("#deleteLesson" + lessonId).modal("show");
                });
                row.replaceWith(link);
                less.appendChild(dropdown);

                console.log("lesson id : ", lessonId);
                console.log("lesson name :", name);
                $.ajax({
                    url: "/lessons/" + lessonId,
                    type: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    dataType: "json",
                    data: {
                        name: name,
                    },
                    success: function (data) {
                        // Update the section name in the UI
                        console.log("suuccessuful update lesson name");
                        location.reload();
                    },
                    error: function (error) {
                        console.error(error);
                    },
                });
            });
        });
    });
});

var deleteBtnsL = document.querySelectorAll(".delete-lesson");
deleteBtnsL.forEach(function (btn) {
    btn.addEventListener("click", function () {
        var lesson = btn.closest(".lesson");
        console.log("lesson ", lesson);
        var lessonId = lesson.dataset.lessonId;
        console.log("lesson id : ", lessonId);
        console.log("CSRF token", $('meta[name="csrf-token"]').attr("content"));

        $.ajax({
            url: "/lessons/delete/" + lessonId,
            type: "DELETE",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            data: {
                lessonId: lessonId,
            },
            success: function (xhr, status, response) {
                // Update the section name in the UI

                console.log("suuccessuful delete lesson");
                // location.reload();
                $("#deleteLesson" + lessonId).modal("hide");
                lesson.remove();

                var sections = document.getElementsByClassName("section");
                var lessonPositions = [];

                Array.from(sections).forEach(function (section) {
                    var lessons = section.getElementsByClassName("lesson");
                    Array.from(lessons).forEach(function (lesson, index) {
                        var sectionId = section.dataset.sectionId;
                        var lessonId = lesson.dataset.lessonId;
                        lessonPositions.push({
                            sectionId: sectionId,
                            lessonId: lessonId,
                            position: index + 1,
                        });
                    });
                });
                console.log(lessonPositions);
                // Send the updated positions to the server
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                });
                $.ajax({
                    url: "/updateLessonPosition", // Update with the appropriate URL
                    type: "PUT",
                    dataType: "json",
                    data: JSON.stringify(lessonPositions),
                    contentType: "application/json",
                    success: function (response) {
                        console.log(
                            "Lesson positions updated successfully",
                            response
                        );
                    },
                    error: function (xhr, status, error) {
                        console.error(
                            "Error updating lesson positions:",
                            error
                        );
                    },
                });

                console.log("response : ", response);
            },
            error: function (xhr, status, error) {
                console.log("xhr", xhr);
                console.log("status", status);
                console.error("Error deleting lesson:", error);
            },
        });
    });
});
// add elemlents in already exists sections  buttons
var addBtns = document.querySelectorAll(".btn-el");
addBtns.forEach(function (addBtn) {
    addBtn.addEventListener("click", function () {
        console.log(addBtn);
        var ul = addBtn.parentElement;
        var newLi1 = document.createElement("li");
        newLi1.className =
            "d-flex justify-content-between card lesson flex-row";
        newLi1.style = "background-color: rgba(231, 235, 240, 0.795);";
        ////////////////////////:

        // var header = document.createElement("div");
        // header.className = "header d-flex justify-content-between";
        //create the div that contains the icon in the input Or lesson_name
        var div = document.createElement("div");
        div.className = "d-flex flex-row align-items-baseline";
        // create the icon and the title of the lesson as a span:
        var newIcon1 = document.createElement("i");
        newIcon1.className = "fa fa-bars handle";

        // create the div element
        var newDiv1 = document.createElement("div");
        newDiv1.id = "lesson-box";
        newDiv1.className = "d-flex align-items-center";
        newDiv1.innerHTML =
            "<input value='New Lesson' class='form-control input m-2 border border-dark' type='text' name='' ><button class='btn btn-primary me-2 save-button'>Save</button><a href='' class='btn btn-secondary cancel-button me-2' >Cancel</a>";
        ul.appendChild(newLi1);
        newLi1.appendChild(div);
        div.append(newIcon1, newDiv1);
        var newInput = newDiv1.querySelector(".input");
        newInput.focus();
        newInput.select();
        // Add event listener for "Enter" key press
        newInput.addEventListener("keydown", function (event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Prevent form submission

                var saveButton = newDiv1.querySelector(".save-button");
                saveButton.click(); // Trigger click event on the save button
            }
        });

        // Scroll
        newLi1.scrollIntoView({ behavior: "smooth", block: "center" });

        // Get the lesson name from the input field
        var lessonName = newInput.value;
        var sectionID = ul.dataset.sectionId;
        console.log("section id : ", sectionID);
        var lessonPosition = ul.querySelectorAll(".lesson").length;
        console.log("position : ", lessonPosition);

        var lessonData = {
            lessonName: lessonName,
            sectionId: sectionID,
            position: lessonPosition,
        };
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        console.log(sectionID);
        var lessonId;
        // Send the lesson data to the server
        $.ajax({
            url: "/saveLesson", // Update with the appropriate URL
            type: "POST",
            dataType: "json",
            data: JSON.stringify(lessonData),
            contentType: "application/json",
            success: function (response) {
                // Handle the response from the server
                lessonId = response.lessonId;
                console.log("Lesson saved", lessonId);
                newLi1.setAttribute("data-lesson-id", lessonId);
                newLi1.setAttribute("data-lesson-name", lessonName);
            },
            error: function (xhr, status, error) {
                // Handle any errors
                console.log("xhr", xhr);
                console.log("status", status);
                console.error("Error saving lesson:", error);
            },
        });

        var buttons = document.querySelectorAll(".save-button");
        buttons.forEach(function (button) {
            button.addEventListener("click", function () {
                var row = button.parentNode;
                var nameInput = row.querySelector(".input");
                var name = nameInput.value;
                var parent_li = row.closest(".lesson");
                parent_li.setAttribute("data-lesson-name", name);

                // Create an object to send the data

                var link = document.createElement("a");
                link.href = "#";
                link.textContent = name;
                link.id = "lesson-link";
                link.className = "card-title ms-1";
                link.style =
                    "text-decoration:none;color:rgb(81, 84, 90);margin-left=1px;";
                var dropdown = document.createElement("div");
                dropdown.className = "dropDownL";
                dropdown.innerHTML =
                    "<span id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-ellipsis-v info'></i></span><ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1' style='padding: 0%'><li><button class='btn btn-primary dropdown-item edit-lesson' >Edit</button></li><li><button class='btn btn-danger dropdown-item delete' data-bs-toggle='modal'>Delete</button></li></ul>";
                var deleteBtn = dropdown.querySelector(".delete");
                deleteBtn.setAttribute(
                    "data-bs-target",
                    "#deleteLesson" + lessonId
                );
                console.log("delete btn : ", deleteBtn);
                var modal = document.createElement("div");
                modal.className = "modal fade";
                modal.id = "deleteLesson" + lessonId;
                modal.setAttribute("data-lesson-id", lessonId);
                modal.setAttribute("tabindex", "-1");
                modal.setAttribute("aria-labelledby", "exampleModalLabel");
                modal.setAttribute("aria-hidden", "true");
                modal.innerHTML = `<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">Supprimer Un Leçon</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><p>Voulez-vous Supprimez Le Leçcon ?</p></div><div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button><button type="button" class="btn btn-danger delete-lesson">Suppimer</button></div></div></div>`;
                deleteBtn.addEventListener("click", function () {
                    var myModal = new bootstrap.Modal(modal);
                    myModal.show();
                });

                ///////////////////////:
                var modal2 = document.createElement("div");
                modal2.className = "modal fade";
                modal2.id = "addContentModal" + lessonId;
                modal2.setAttribute("data-lesson-id", lessonId);
                modal2.setAttribute("tabindex", "-1");
                modal2.setAttribute("aria-labelledby", "exampleModalLabel");
                modal2.setAttribute("aria-hidden", "true");
                // Create the outermost div element

                // Create the modal-dialog div element
                var dialogDiv = document.createElement("div");
                dialogDiv.className = "modal-dialog";
                dialogDiv.setAttribute("role", "document");

                // Create the modal-content div element
                var contentDiv = document.createElement("div");
                contentDiv.className = "modal-content";

                // Create the modal-header div element
                var headerDiv = document.createElement("div");
                headerDiv.className = "modal-header";

                // Create the h5 element for the modal title
                var titleH5 = document.createElement("h5");
                titleH5.className = "modal-title";
                titleH5.id = "addContentModalLabel" + lessonId;
                titleH5.textContent = "Add Content for " + lessonId;

                // Create the button element for closing the modal
                var closeButton = document.createElement("button");
                closeButton.type = "button";
                closeButton.className = "btn-close";
                closeButton.setAttribute("data-bs-dismiss", "modal");
                closeButton.setAttribute("aria-label", "Close");

                // Append the title and close button to the header div
                headerDiv.appendChild(titleH5);
                headerDiv.appendChild(closeButton);

                // Create the modal-body div element
                var bodyDiv = document.createElement("div");
                bodyDiv.className = "modal-body";

                // Create the ul element for the content list
                var ul = document.createElement("ul");
                ul.className = "content-list d-flex";

                // Create the first li element for adding a video
                var videoLi = document.createElement("li");
                videoLi.className = "m-4";
                var videoLink = document.createElement("a");
                videoLink.className = "btn btn-success";
                videoLink.href = "/videos/create/" + lessonId;
                var videoIcon = document.createElement("i");
                videoIcon.className = "fa fa-video-camera me-2";
                videoLink.append(videoIcon, "Add Video");
                // videoLink.textContent = " Add Video";
                videoLi.appendChild(videoLink);
                ul.appendChild(videoLi);

                // Create the second li element for adding a quiz
                var quizLi = document.createElement("li");
                quizLi.className = "m-4";
                var quizLink = document.createElement("a");
                quizLink.className = "btn btn-primary";
                quizLink.href = "/admin/quizzes/create/" + lessonId;
                var quizIcon = document.createElement("i");
                quizIcon.className = "fa fa-question-circle me-2";
                quizLink.append(quizIcon, "Add Quiz");
                quizLi.appendChild(quizLink);
                ul.appendChild(quizLi);

                // Append the ul to the modal-body div
                bodyDiv.appendChild(ul);

                // Append the header and body divs to the modal-content div
                contentDiv.appendChild(headerDiv);
                contentDiv.appendChild(bodyDiv);

                // Append the modal-content div to the modal-dialog div
                dialogDiv.appendChild(contentDiv);

                // Append the modal-dialog div to the outermost div
                modal2.appendChild(dialogDiv);

                link.addEventListener("click", function () {
                    var myModal = new bootstrap.Modal(modal2);
                    myModal.show();
                });

                /////////////////////////////:
                row.replaceWith(link);
                parent_li.appendChild(dropdown, modal, modal2);
                console.log("lesson id for update : ", lessonId);
                $.ajax({
                    url: "/lessons/" + lessonId,
                    type: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    dataType: "json",
                    data: {
                        name: name,
                    },
                    success: function (data) {
                        // Update the section name in the UI
                        console.log("suuccessuful update section name");
                        var edit = dropdown.querySelector(".edit-lesson");
                        var deleteBtn = modal.querySelector(".delete-lesson");
                        console.log("dropdown : ", dropdown);
                        console.log("delete btn : ", deleteBtn);

                        edit.addEventListener("click", function () {
                            var link = edit
                                .closest(".lesson")
                                .querySelector("#lesson-link");
                            console.log("edit : ", edit);
                            var newDiv = document.createElement("div");
                            newDiv.id = "lesson-box";
                            newDiv.className = "d-flex align-items-center";
                            var dropDown = edit.closest(".dropDownL");
                            console.log("dropdown : ", dropDown);
                            newDiv.style = "display: inline;";
                            var less = edit.closest(".lesson");
                            console.log("lesson : ", less);
                            var lesson_name = less.dataset.lessonName;
                            var lessonId = less.dataset.lessonId;

                            console.log("lesson_name : ", lesson_name);
                            var newInput = document.createElement("input");
                            newInput.className =
                                "form-control input m-2 border border-dark";
                            newInput.type = "text";
                            newInput.value = lesson_name;
                            var saveBtn = document.createElement("button");
                            saveBtn.className =
                                "btn btn-primary button save-button me-2";
                            saveBtn.textContent = "Save";
                            var cancelBtn = document.createElement("a");
                            cancelBtn.href = "";
                            cancelBtn.className =
                                "btn btn-secondary button cancel-button me-2";
                            cancelBtn.textContent = "Cancel";
                            console.log(link);
                            var div = link.parentElement;
                            div.className =
                                "d-flex flex-row align-items-baseline";
                            dropDown.remove();
                            newInput.addEventListener(
                                "keydown",
                                function (event) {
                                    if (event.key === "Enter") {
                                        event.preventDefault(); // Prevent form submission

                                        var saveButton =
                                            newDiv.querySelector(
                                                ".save-button"
                                            );
                                        saveButton.click(); // Trigger click event on the save button
                                    }
                                }
                            );
                            newDiv.append(newInput, saveBtn, cancelBtn);
                            link.replaceWith(newDiv);
                            newInput.focus();
                            newInput.select();

                            //
                            var buttons =
                                document.querySelectorAll(".save-button");
                            buttons.forEach(function (button) {
                                button.addEventListener("click", function () {
                                    var row = button.parentNode;
                                    var name = newInput.value;

                                    // Create an object to send the data
                                    var link = document.createElement("a");
                                    link.href = "#";
                                    link.textContent = name;
                                    link.id = "lesson-link";
                                    link.className = "card-title ms-1";
                                    link.style =
                                        "text-decoration:none;color:rgb(81, 84, 90);margin-left=1px;";
                                    var dropdown =
                                        document.createElement("div");
                                    dropdown.className = "dropDownL";

                                    dropdown.innerHTML =
                                        "<span id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-ellipsis-v info'></i></span><ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'><li><button class='dropdown-item edit-lesson' >Edit</button></li><li><button class='dropdown-item delete-lesson' >Delete</button></li></ul>";

                                    row.replaceWith(link);
                                    less.appendChild(dropdown);

                                    console.log("lesson id : ", lessonId);
                                    console.log("lesson name :", name);
                                    $.ajax({
                                        url: "/lessons/" + lessonId,
                                        type: "PUT",
                                        headers: {
                                            "X-CSRF-TOKEN": $(
                                                'meta[name="csrf-token"]'
                                            ).attr("content"),
                                        },
                                        dataType: "json",
                                        data: {
                                            name: name,
                                        },
                                        success: function (data) {
                                            // Update the section name in the UI
                                            console.log(
                                                "suuccessuful update lesson name"
                                            );
                                            location.reload();
                                        },
                                        error: function (error) {
                                            console.error(error);
                                        },
                                    });
                                });
                            });
                        });

                        deleteBtn.addEventListener("click", function () {
                            var lessonId = parent_li.dataset.lessonId;
                            console.log("lesson id : ", lessonId);
                            console.log(
                                "CSRF token",
                                $('meta[name="csrf-token"]').attr("content")
                            );

                            $.ajax({
                                url: "/lessons/delete/" + lessonId,
                                type: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": $(
                                        'meta[name="csrf-token"]'
                                    ).attr("content"),
                                },
                                dataType: "json",
                                data: {
                                    lessonId: lessonId,
                                },
                                success: function (xhr, status, response) {
                                    // Update the section name in the UI

                                    console.log("suuccessuful delete lesson");
                                    // location.reload();
                                    $("#deleteLesson" + lessonId).modal("hide");
                                    parent_li.remove();
                                    var sections =
                                        document.getElementsByClassName(
                                            "section"
                                        );
                                    var lessonPositions = [];

                                    Array.from(sections).forEach(function (
                                        section
                                    ) {
                                        var lessons =
                                            section.getElementsByClassName(
                                                "lesson"
                                            );
                                        Array.from(lessons).forEach(function (
                                            lesson,
                                            index
                                        ) {
                                            var sectionId =
                                                section.dataset.sectionId;
                                            var lessonId =
                                                lesson.dataset.lessonId;
                                            lessonPositions.push({
                                                sectionId: sectionId,
                                                lessonId: lessonId,
                                                position: index + 1,
                                            });
                                        });
                                    });
                                    console.log(lessonPositions);
                                    // Send the updated positions to the server
                                    $.ajaxSetup({
                                        headers: {
                                            "X-CSRF-TOKEN": $(
                                                'meta[name="csrf-token"]'
                                            ).attr("content"),
                                        },
                                    });
                                    $.ajax({
                                        url: "/updateLessonPosition", // Update with the appropriate URL
                                        type: "PUT",
                                        dataType: "json",
                                        data: JSON.stringify(lessonPositions),
                                        contentType: "application/json",
                                        success: function (response) {
                                            console.log(
                                                "Lesson positions updated successfully",
                                                response
                                            );
                                        },
                                        error: function (xhr, status, error) {
                                            console.error(
                                                "Error updating lesson positions:",
                                                error
                                            );
                                        },
                                    });
                                    console.log("response : ", response);
                                },
                                error: function (xhr, status, error) {
                                    console.log("xhr", xhr);
                                    console.log("status", status);
                                    console.error(
                                        "Error deleting lesson:",
                                        error
                                    );
                                },
                            });
                        });
                    },
                    error: function (error) {
                        console.error(error);
                    },
                });
            });
        });
    });
});
