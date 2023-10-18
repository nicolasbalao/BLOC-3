<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\TaskModel;
use App\Utils\FormBuilder;
use App\Utils\SessionHelper;

class HomePageController extends Controller
{


    public function __construct()
    {
        // TODO: REFACTOR: search something like nest js UseGuard()
        if (!SessionHelper::isAuth()) {
            header("Location: /login");
        }
        $this->cssFile = "homePage";
    }

    public function index()
    {
        $title = "Home page";

        $form = $this->buildForm();

        $taskModel = new TaskModel;

        $tasks = $taskModel->findBy(["userId" => $_SESSION["user"]["id"]]);


        $this->render("homePage", compact("title", "form", "tasks"));
    }


    public function create()
    {
        // Retrieve the raw POST data
        $post_data = file_get_contents("php://input");

        // Decode the JSON data
        $json_data = json_decode($post_data, true);

        if (!$json_data) {
            SessionHelper::setError("Invalid JSON data provided");
            http_response_code(400);
            $this->index();
            exit;
        }

        if (!isset($json_data)) {
            SessionHelper::setError("No data provided");
            http_response_code(400);
            $this->index();
            exit;
        }

        if (!FormBuilder::validate($json_data, ["name"])) {
            SessionHelper::setError("Bad data provided");
            http_response_code(400);
            $this->index();
            exit;
        }

        $name = strip_tags($json_data['name']);

        $task = new TaskModel;

        $task->setName($name);
        $task->setUserId($_SESSION["user"]["id"]);

        $success = $task->create();

        if (!$success) {
            $this->handleErrorBehviour("An error occured", 500);
        }

        SessionHelper::setSuccessMessage("Task created !");
        $this->index();
        exit;
    }

    public function update($id)
    {
        $put_data = file_get_contents("php://input");

        // Decode the JSON data
        $json_data = json_decode($put_data, true);

        if (!isset($json_data)) {
            SessionHelper::setError("No data provided");
            http_response_code(400);
            $this->index();
            exit;
        }

        $task = new TaskModel;

        $name = strip_tags($json_data['name']);
        $task->setName($name);

        $done =  $done = isset($json_data["done"]) && $json_data["done"] ? 1 : 0;
        $task->setDone($done);

        var_dump($task);

        $success = $task->update($id);


        if (!$success) {
            $this->handleErrorBehviour("An error occured", 500);
        }

        $this->index();
        exit;
    }

    public function delete($id)
    {
        $taskModel = new TaskModel;

        $success = $taskModel->delete($id);
        if (!$success) {
            $this->handleErrorBehviour("An Error occured while deleting", 500);
        }

        $this->index();
        exit;
    }




    private function handleErrorBehviour(string $message, int $statusCode)
    {
        SessionHelper::setError($message);
        http_response_code($statusCode);
        $this->index();
        exit;
    }

    private function buildForm(): string
    {
        $form = new FormBuilder;
        $form->startForm()
            ->addLabelFor("name", "Name")
            ->addInput("name", "name", ["required" => true])
            ->addButton("Save")
            ->endForm();

        return $form->generate();
    }
}
