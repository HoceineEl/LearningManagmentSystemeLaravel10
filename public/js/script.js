//for the elements tha are added by default in the html section
// var buttons = document.querySelectorAll(".save-button");

// buttons.forEach(function (button) {
//     button.addEventListener("click", function () {
//         var row = button.parentNode;
//         var nameInput = row.querySelector("#input");
//         var name = nameInput.value;
//         var link = document.createElement("a");
//         link.href = "#";
//         link.textContent = name;
//         link.className = "lesson-link";
//         row.replaceWith(link);
//     });
// });

// the drag and drop events :
var nestedSortables = document.getElementById("main");
new Sortable(nestedSortables, {
    group: "shared",
    handle: ".handle-section",
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

// creating the elemlents
document.getElementById("btn").addEventListener("click", function () {
    // create the ul element
    var newUls = document.createElement("ul");
    newUls.className = "section-list";

    // create the li element
    var newLi = document.createElement("li");
    newLi.className = "section";

    //
    var header = document.createElement("div");
    header.className = "d-flex justify-content-between header";
    var div = document.createElement("div");

    // create the icon handler:
    var newIcon = document.createElement("i");
    newIcon.className = "fa fa-bars handle-section";
    // create the div element
    var newDiv = document.createElement("div");
    newDiv.id = "section-box";
    newDiv.style = "display: inline;";
    newDiv.innerHTML =
        "<input value='New Section' class='form-control form-control-lg m-2 border border-dark input-section' type='text' ><button class='btn btn-primary button save-button_sec'>Save</button><a href='' class='btn btn-light button cancel-button_sec'>Cancel</a>";

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
    // new Sortable(section_item, {
    //     group: "shared",
    //     handle: ".handle-section",
    //     animation: 200,
    //     nested: true,
    // });
    var newInputSection = newDiv.querySelector(".input-section");
    newInputSection.focus();
    newInputSection.select();
    // Get the section name from the input field
    var sectionName = newInputSection.value;
    var sectionPosition = section_item.querySelectorAll(".section-list").length;
    console.log("existing sections", sectionPosition);

    // ...

    // Create an object with the section data
    var sectionData = {
        sectionName: sectionName,
        position: sectionPosition, // Assign the position
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
            newBtn.addEventListener("click", function () {
                // create the li element
                var newLi1 = document.createElement("li");
                newLi1.className = "lesson d-flex justify-content-between";
                // var header = document.createElement("div");
                // header.className = "header d-flex justify-content-between";
                //create the div that contains the icon in the input Or lesson_name
                var div = document.createElement("div");
                // create the icon and the title of the lesson as a span:
                var newIcon1 = document.createElement("i");
                newIcon1.className = "fa fa-bars handle";
                // create the div element
                var newDiv1 = document.createElement("div");
                newDiv1.id = "lesson-box";
                newDiv1.style = "display: inline;";
                newDiv1.innerHTML =
                    "<input value='New Lesson' class='form-control input m-2 border border-dark' type='text'><button class='btn btn-primary save-button'>Save</button><a href='' class='btn btn-secondary cancel-button'>Cancel</a>";
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

                        // Create an object to send the data
                        var link = document.createElement("a");
                        link.href = "#";
                        link.textContent = name;
                        link.className = "lesson-link";
                        link.style =
                            "text-decoration:none;color:rgb(81, 84, 90)";
                        var dropdown = document.createElement("div");
                        dropdown.innerHTML =
                            " <span id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-ellipsis-v info'></i></span><ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'><li><a class='dropdown-item' href='#'>Edit</a></li><li><a class='dropdown-item' href='#'>Delete</a></li></ul>";

                        row.replaceWith(link);
                        Parent_Li.appendChild(dropdown);

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
                                console.log("suuccessuful update lesson name");
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
            console.log("Bro,that's not even working");
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
            span.id = "section-title";
            var sectionNm = newInputSection.value;
            span.textContent = sectionNm;
            var dropdown = document.createElement("div");
            dropdown.innerHTML =
                " <span id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-ellipsis-v info-section'></i></span><ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'><li><a class='dropdown-item' href='#'>Edit</a></li><li><a class='dropdown-item' href='#'>Delete</a></li></ul>";

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

var editBtns = document.querySelectorAll(".edit-section");
editBtns.forEach(function (btn) {
    btn.addEventListener("click", function () {
        var span = btn.closest(".header").querySelector(".section-title");
        var newDiv = document.createElement("div");
        newDiv.id = "section-box";
        newDiv.style = "display: inline;";
        var sec = btn.closest(".section");
        var section_name = sec.dataset.sectionName;
        console.log("section_name : ", section_name);
        var newInput = document.createElement("input");
        newInput.className =
            "form-control form-control-lg m-2 border border-dark input-section";
        newInput.type = "text";
        newInput.value = section_name;
        var saveBtn = document.createElement("button");
        saveBtn.className = "btn btn-primary button save-button_sec";
        saveBtn.textContent = "Save";
        var cancelBtn = document.createElement("a");
        cancelBtn.href = "";
        cancelBtn.className = "btn btn-light button cancel-button_sec";
        cancelBtn.textContent = "Cancel";
        // newDiv.innerHTML =
        //     "<button class='btn btn-primary button save-button_sec'>Save</button><a href='' class='btn btn-light button cancel-button_sec'>Cancel</a>";
        console.log(span);
        newDiv.append(newInput, saveBtn, cancelBtn);
        span.replaceWith(newDiv);
    });
    var buttons1 = document.querySelectorAll(".save-button_sec");
    buttons1.forEach(function (button) {
        button.addEventListener("click", function () {
            var row = button.parentElement;
            var header = row.closest(".header");
            var span = document.createElement("span");
            span.id = "section-title";
            var sectionNm = newInputSection.value;
            span.textContent = sectionNm;
            var dropdown = document.createElement("div");
            dropdown.innerHTML =
                " <span id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-ellipsis-v info-section'></i></span><ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'><li><a class='dropdown-item' href='#'>Edit</a></li><li><a class='dropdown-item' href='#'>Delete</a></li></ul>";

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

// add elemlents in already exists sections  buttons
var addBtns = document.querySelectorAll(".btn-el");
addBtns.forEach(function (addBtn) {
    addBtn.addEventListener("click", function () {
        console.log(addBtn);
        var ul = addBtn.parentElement;
        var newLi1 = document.createElement("li");
        newLi1.className = "lesson d-flex justify-content-between";
        ////////////////////////:

        // var header = document.createElement("div");
        // header.className = "header d-flex justify-content-between";
        //create the div that contains the icon in the input Or lesson_name
        var div = document.createElement("div");

        // create the icon and the title of the lesson as a span:
        var newIcon1 = document.createElement("i");
        newIcon1.className = "fa fa-bars handle";

        // create the div element
        var newDiv1 = document.createElement("div");
        newDiv1.id = "lesson-box";
        newDiv1.style = "display: inline;";
        newDiv1.innerHTML =
            "<input value='New Lesson' class='form-control input m-2 border border-dark' type='text' name='' ><button class='btn btn-primary save-button'>Save</button><button class='btn btn-secondary cancel-button'>Cancel</button>";
        ul.appendChild(newLi1);
        newLi1.appendChild(div);
        div.append(newIcon1, newDiv1);
        var newInput = newDiv1.querySelector(".input");
        newInput.focus();
        newInput.select();
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
                // Create an object to send the data

                var link = document.createElement("a");
                link.href = "#";
                link.textContent = name;
                link.className = "lesson-link";

                link.style = "text-decoration:none;color:rgb(81, 84, 90)";
                var dropdown = document.createElement("div");
                dropdown.innerHTML =
                    " <span id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-ellipsis-v info'></i></span><ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'><li><a class='dropdown-item' href='#'>Edit</a></li><li><a class='dropdown-item' href='#'>Delete</a></li></ul>";
                row.replaceWith(link);
                parent_li.appendChild(dropdown);
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
                    },
                    error: function (error) {
                        console.error(error);
                    },
                });
            });
        });
    });
});
