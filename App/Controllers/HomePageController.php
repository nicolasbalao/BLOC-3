<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\TaskModel;
use App\Utils\FormBuilder;
use App\Utils\SessionHelper;

class HomePageController extends Controller
{


    public function index()
    {
        $title = "Home page";

        $form = $this->buildForm();

        $taskModel = new TaskModel;

        $tasks = $taskModel->findAll();


        $this->render("homePage", compact("title", "form", "tasks"));
    }


    public function create()
    {
        if (!isset($_POST)) {
            SessionHelper::setError("No data provided");
            http_response_code(400);
            $this->index();
            exit;
        }

        if (!FormBuilder::validate($_POST, ["name"])) {
            SessionHelper::setError("Bad data provided");
            http_response_code(400);
            $this->index();
            exit;
        }

        $name = strip_tags($_POST['name']);

        $task = new TaskModel;

        $task->setName($name);

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
        if (!isset($_POST)) {
            SessionHelper::setError("No data provided");
            http_response_code(400);
            $this->index();
            exit;
        }

        $task = new TaskModel;

        $name = strip_tags($_POST['name']);
        $task->setName($name);

        $done =  false;

        if (isset($_POST["done"])) {
            $done = strip_tags($_POST["done"]);
        }
        $task->setDone($done);

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
            ->addButton("Save", ["onclick" => "test()"])
            ->endForm();

        return $form->generate();
    }
}
