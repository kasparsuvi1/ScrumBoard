<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="assets/js/jquery.tablesorter.min.js"></script>

        <style>
            body{
                background-image: url("templates/bg.jpg");
            }
            tr{
                background-color: white;
            }
            
            .table_header{
                background-image: url(views/boards/bg.gif);
                background-repeat: no-repeat;
                padding-top: 20px;
                background-color: #00b3ee;
            }
            .headerSortDown{
                background-image: url(views/boards/asc.gif);
                background-repeat: no-repeat;
                padding-top: 20px;
            }
            .headerSortUp{
                background-image: url(views/boards/desc.gif);
                background-repeat: no-repeat;
                padding-top: 20px;
            }

        </style>
    </head>
    <body>
        <table id="myTable" class="tablesorter table table-bordered">
            <thead>
            <tr>
                <th class="table_header">Task id</th>
                <th class="table_header">Name</th>
                <th class="table_header">Description</th>
                <th class="table_header">Added</th>
                <th class="table_header">Deleted</th>
                <th class="table_header">status</th>
                <th class="table_header">Take up</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tasks as $task): ?>
            <tr data-task_id="<?= $task['id'] ?>">
                <td><?= $task['id'] ?></td>
                <td><?= html_entity_decode($task['name']) ?></td>
                <td><?= html_entity_decode($task['description']) ?></td>
                <td><?= $task['added'] ?></td>
                <td><?= $task['delete_time'] ?></td>
                <td><?= $task['Status'] ?></td>
                <td><button class="btn btn-primary btn_reset">Taasta</button></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pull-right">
            <form action="boards/">
                <button class="btn btn-info">Vaata scrum tabelit</button>
            </form>
        </div>
    </body>
</html>

<script>
    $(document).ready(function() {
        // call the tablesorter plugin
        $("#myTable").tablesorter({
            // sort on the first column and third column, order asc
            sortList: [[0,0]]
        });
    });

    $('th').click(function() {
        handleHeaderClick(this);
    });

    function handleHeaderClick(hdr) {
        if ($(hdr).hasClass('table_header') == true) {
        }
    }

</script>

<script>
    $(".btn_reset").on("click",function () {
            var tr = $(this).parents("tr");
            var task_id = tr.data("task_id");
            $.post("boards/reset", {task_id: task_id}, function (result) {
                if (result == "ok") {
                    tr.find("td").remove();
                }
                else {
                    alert("Error!\nResponse was unexpected:\n" + result);
                }
            })

    })
</script>