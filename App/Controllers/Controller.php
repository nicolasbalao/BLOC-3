<?php

namespace App\Controllers;

/**
 * Abstract Controller 
 * 
 * @package App\Controller
 */

abstract class Controller
{

    // Template where we render the "component"
    public $template = "default";

    /**
     * render component in the default template page
     * 
     * @param $file path to the file who contain the "component"
     * @param $data array of data for the "component"
     */
    public function render(string $file, array $data = [])
    {

        // Extract data
        extract($data);

        // Start output stream
        ob_start();

        require_once(VIEWS_DIR .  $file . ".php");

        // Set the html of the require_once in the variable $content
        $content = ob_get_clean();

        // Load the template and render the $content
        require_once(VIEWS_DIR . "Templates/" . $this->template . ".php");
    }
}
