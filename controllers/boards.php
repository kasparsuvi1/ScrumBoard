<?php namespace Halo;

class boards extends Controller
{

    function index()
    {
        $this->tasks_todo = get_all("SELECT * FROM tasks WHERE Status = 'todo' AND deleted = 0");
        $this->tasks_doing = get_all("SELECT * FROM tasks WHERE Status = 'doing' AND deleted = 0");
        $this->tasks_done = get_all("SELECT * FROM tasks WHERE Status = 'done' AND deleted = 0");

    }
    function logi(){
        $this->tasks = get_all("SELECT * FROM tasks WHERE deleted = 1");
    }

    function add_task()
    {
        $name = htmlentities($_POST['name']);
        $description = htmlentities($_POST['description']);
        $time = get_one("SELECT NOW()");
        $status = $_POST['status'];
        $data = array("name"=>$name, "description"=>$description, "added"=>$time,"Status"=>$status);
        insert("tasks", $data);
    }

    function update_db(){
        //Get data from AJAX
        $id = $_POST['taski_id'];
        $status = $_POST['status'];

        if ($status == 'done'){
            $time = get_one("SELECT NOW()");
            $data = array("Status" => $status, "delete_time" => $time);
        }else{
            $data = array("Status" => $status);

        }
        update('tasks',$data,"id = {$id}");
    }
    function delete_task(){
        //Get data from AJAX
        $id = $_POST['taski_id'];
        //Get time to add deleted time
        $time = get_one("SELECT NOW()");
        $data = array('deleted'=>1, "delete_time" => $time);
        update('tasks',$data,"id = {$id}");
    }

    function edit_task(){
        $id = $_POST['id'];
        $name = htmlentities($_POST['name']);
        $description = htmlentities($_POST['description']);
        $data = array('name' => $name,'description' => $description);
        update('tasks',$data,"id = {$id}");
    }

    function get_name(){
        $id = $_POST['task_id'];
        $name = get_one("SELECT name FROM tasks WHERE id = {$id}");
        exit(html_entity_decode($name));
    }
    function get_description(){
        $id = $_POST['task_id'];
        $description = get_one("SELECT description FROM tasks WHERE id = {$id}");
        exit(html_entity_decode($description));
    }

    function AJAX_reset(){
        $id = $_POST['task_id'];
        $data = array("deleted" => 0);
        update("tasks",$data,"id = {$id}");
        exit("ok");
    }

}