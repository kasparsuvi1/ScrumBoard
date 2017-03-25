<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="views/boards/style.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <style>
        body{
            background-image: url("templates/bg.jpg");
            background-repeat: no-repeat;
        }
    </style>
</head>
<body>

<!-- Body wrap -->
<div align="center">
    <!-- Button to show popup form-->
    <button class="btn btn-primary" onclick="show_form()">Lisa uus task</button>

    <!-- Table to show tasks -->
    <table class="table">
        <thead>
            <tr>
                <td align="center"><h3><b>Todo</b></h3></td>
                <td align="center"><h3><b>Doing</b></h3></td>
                <td align="center"><h3><b>Done</b></h3></td>
            </tr>
        </thead>

        <tbody>
        <tr>
            <td class="column" id="todo_column">
        <?php foreach ($tasks_todo as $task):?>
                <div class="task" id="todo_task">
                    <h3><?= html_entity_decode($task['name']) ?></h3>
                    <!-- Wll get task id from pre id, to edit db -->
                    <pre id="<?= $task['id'] ?>"><code><?= html_entity_decode($task['description']) ?></code></pre>
                    <div class="delete_btn">
                        <div class="edit_btn">
                            <button onclick="show_edit(<?= $task['id'] ?>)" class="btn btn-primary" style="width: 80px;">Edit</button>
                        </div>
                        <button onclick="delete_task(<?= $task['id'] ?>)" class="btn btn-danger" style="width: 80px;">Kustuta</button>
                    </div>
                </div>
        <?php endforeach; ?>
            </td>

            <td class="column" id="doing_column">
                <?php foreach ($tasks_doing as $task):?>

                    <div class="task" id="doing_task">
                        <h3><?= html_entity_decode($task['name']) ?></h3>
                        <!-- Wll get task id from pre id, to edit db -->
                        <pre id="<?= $task['id'] ?>"><code><?= html_entity_decode($task['description']) ?></code></pre>
                        <div class="delete_btn">
                            <div class="edit_btn">
                                <button onclick="show_edit(<?= $task['id'] ?>)" class="btn btn-primary" style="width: 80px;">Edit</button>
                            </div>
                            <button onclick="delete_task(<?= $task['id'] ?>)" class="btn btn-danger" style="width: 80px;">Kustuta</button>
                        </div>
                    </div>

                <?php endforeach; ?>
            </td>

            <td class="column" id="done_column">
                <?php foreach ($tasks_done as $task):?>
                    <div class="task" id="done_task">
                        <h3><?= html_entity_decode($task['name']) ?></h3>
                        <!-- Wll get task id from pre id, to edit db -->
                        <pre id="<?= $task['id'] ?>"><code><?= html_entity_decode($task['description']) ?></code></pre>
                        <div class="delete_btn">
                            <div class="edit_btn">
                                <button onclick="show_edit(<?= $task['id'] ?>)" class="btn btn-primary" style="width: 80px;">Edit</button>
                            </div>
                                <button onclick="delete_task(<?= $task['id'] ?>)" class="btn btn-danger" style="width: 80px;">Kustuta</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </td>
        </tr>
        </tbody>
    </table>
    <!-- Table to show tasks END-->

    <!-- Popup form div -->
    <div align="center" class="form-group" id="popup">
        <form>
            <label for="name">Taski nimi:</label>
            <input type="text" class="form-control" id="name">

            <label for="description">Taski kirjeldus:</label>
            <textarea class="form-control" rows="5" id="description"></textarea>

            <div class="pull-left" id="radio">
                <input id="Status" type="radio" value="todo" name="Status" checked>To-Do<br>
                <input id="Status" type="radio" value="doing" name="Status">Doing<br>
                <input id="Status" type="radio" value="done" name="Status">Done
            </div>
        </form>
        <div class="pull-right">
            <button id="form_submit_btn" onclick="add_task()" class="btn btn-primary" type="submit">Lisa uus Task</button>
            <button id="form_cancel_btn" onclick="hide_form()" class="btn btn-default">Sulge</button>
        </div>
    </div>
    <!-- Popup form end -->

    <!-- Edit form start -->
    <div align="center" class="form-group" id="editup">
        <form>

            <label for="name1">Taski nimi:</label>
            <input type="text" class="form-control" id="name1" value="">

            <label for="description1">Taski kirjeldus:</label>
            <textarea class="form-control" rows="5" id="description1"></textarea>
        </form>
        <div class="pull-right">
            <p id="needed" class="teretali">
                <button id="form_edit_btn" onclick="edit_task(this.id)" class="btn btn-primary" type="submit">Muuda</button>
                <button id="form_cancel_btn" onclick="hide_edit()" class="btn btn-default">Sulge</button>
            </p>
        </div>
    </div>
    <!-- Edit form end -->
</div>

<div class="pull-right">
    <form action="boards/logi">
        <button class="btn btn-info">Vaata vanu taske</button>
    </form>
</div>

</body>
</html>
<script>
    //Make tasks draggable to other column
    $(function(){
        $(".column").sortable({
            connectWith:"td",
            //when table is updated:
            update: function (event, ui) {
                //Column_id = column where item is dropped
                var column_id = ui.item.closest('td').attr('id');
                if ( column_id == "todo_column"){
                    //Change task div id to new column task id -> to change color of the divs
                    ui.item.attr("id","todo_task");
                    //Every task pre id is equal to task_id from db --> ise panin, et id kätte saada
                    var taski_id = $(ui.item).find('pre').attr('id');
                    var new_status = "todo";
                    update_db(taski_id, new_status);
                }
                else if (column_id == "doing_column"){
                    //Change task div id to new column task id -> to change color of the divs
                    ui.item.attr("id","doing_task");
                    //Every task div pre id is equal to task_id from db
                    var taski_id = $(ui.item).find('pre').attr('id');
                    var new_status = "doing";
                    update_db(taski_id, new_status);
                }
                else if(column_id == "done_column"){
                    //Change task div id to new column task id -> to change color of the divs
                    ui.item.attr("id","done_task");
                    //Every task div pre id is equal to task_id from db
                    var taski_id = $(ui.item).find('pre').attr('id');
                    var new_status = "done";
                    update_db(taski_id, new_status);
                }
            }
        }).disableSelection();
    });


    //To hide popup at first
    $("#popup").hide();
    $("#editup").hide();

    function add_task() {
        var name = $("#name").val();
        var description = $("#description").val();
        var status = $('input[name=Status]:checked').val();
        $.post("<?=BASE_URL?>boards/add_task", {name: name,description:description,status:status}, function (result) {
        });
        // add manually same div so page do not need refresh
        window.location.reload();
    }
    //Change task info
    function edit_task(id) {
        //Get task id, from <p> tags id around button
        var task_id = $('#'+id).parent().attr('id');
        var name = $("#name1").val();
        var description = $("#description1").val();
        $.post("<?=BASE_URL?>boards/edit_task",{id : task_id, name:name,description:description}, function (result) {
        });
        // add manually same div so page do not need refresh
        window.location.reload();

    }

    //Called when btn "Add task" is clicked
    function show_form() {
        $("#popup").show();
    }

    function show_edit(task_id) {
        $("#editup").show();
        //get with class, so you can always rewrite it, change id
        $('.teretali').attr('id',task_id);

        //to get value to inputs
        $.post("<?=BASE_URL?>boards/get_name",{task_id : task_id}, function (result) {
            $('#name1').attr('value',result);
        });
        $.post("<?=BASE_URL?>boards/get_description",{task_id : task_id}, function (result) {
            $('#description1').val(result);
        })
    }

    //Called when btn "close" is clicked
    function hide_form() {
        $("#popup").hide();
    }
    function hide_edit() {
        $("#editup").hide();
    }


    function update_db(taski_id,new_status) {
        //Send request to update task status
        $.post("<?=BASE_URL?>boards/update_db",{taski_id : taski_id, status: new_status}, function (result) {
        })
    }

    function delete_task(taski_id) {
        //Send request to delete data from db
        $.post("<?=BASE_URL?>boards/delete_task",{taski_id : taski_id}, function (result) {
        });
        //delete div from page without refresh
        $("#" + taski_id).parent().remove();
    }
</script>