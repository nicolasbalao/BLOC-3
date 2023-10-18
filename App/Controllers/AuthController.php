<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Utils\FormBuilder;
use App\Utils\SessionHelper;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->cssFile = "auth";
    }

    public function loginPage()
    {
        $title = "login";

        $form = $this->generateForm("Sign in");
        $this->render("auth", ["title" => $title, "form" => $form->generate(), "formTitle" => "login"]);
    }

    public function registerPage()
    {
        $title = "register";

        $form = $this->generateForm("Sign up");
        $this->render("auth", ["title" => $title, "form" => $form->generate(), "formTitle" => "register"]);
    }

    public function login()
    {
        if (!isset($_POST)) {
            http_response_code(400);
            SessionHelper::setError("No data provided");
            $this->loginPage();
            exit;
        }

        if (!FormBuilder::validate($_POST, ["email", "password"])) {
            http_response_code(400);
            SessionHelper::setError("Invalide data");
            $this->loginPage();
            exit;
        }

        $userModel = new UserModel;
        $userInfo = $userModel->findOneByEmail(strip_tags($_POST["email"]));

        if (!$userInfo) {
            SessionHelper::setError("Email or password is invalid");
            $this->loginPage();
            exit;
        }

        $user = $userModel->hydrate($userInfo);


        if (!password_verify(strip_tags($_POST["password"]), $user->getPassword())) {
            SessionHelper::setError("Email or password is invalid");
            $this->loginPage();
            exit;
        }

        $user->setSession();
        SessionHelper::setSuccessMessage("Succes");
        header("Location: /");
        // exit();
    }

    public function logout()
    {
        SessionHelper::destroy();
    }

    public function register()
    {
        if (!isset($_POST)) {
            SessionHelper::setError("No data provided");
            http_response_code(400);
            $this->registerPage();
            exit;
        }

        if (!FormBuilder::validate($_POST, ["email", "password"])) {
            SessionHelper::setError("Bad data provided");
            http_response_code(400);
            $this->registerPage();
            exit;
        }

        $email = strip_tags($_POST["email"]);
        $password = password_hash(strip_tags($_POST["password"]), PASSWORD_BCRYPT);

        $user = new UserModel;

        $user->setEmail($email);
        $user->setPassword($password);

        $success = $user->create();

        if (!$success) {
            http_response_code(500);
            SessionHelper::setError("An error occured");
            $this->registerPage();
            exit;
        }

        SessionHelper::setSuccessMessage("User created !");
        header("Location: /login");
        exit();
    }



    // UTILS
    private function generateForm(string $buttonTitle)
    {
        $form = new FormBuilder;
        $form->startForm(["class" => "auth_form"])
            ->addLabelFor("email", "Email")
            ->addInput("email", "email", ['required' => true])
            ->addLabelFor("password", "Password")
            ->addInput("password", "password", ["required" => true])
            ->addButton($buttonTitle)
            ->endForm();

        return $form;
    }
}
