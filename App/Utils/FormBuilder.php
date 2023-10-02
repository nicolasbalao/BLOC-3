<?php

namespace App\Utils;

/**
 * FormBuilder handle creation of form
 * @package App\Utils
 */
class FormBuilder
{

    private $formCode = "";


    /**
     * Generate the form
     */
    public function generate(): string
    {
        return $this->formCode;
    }

    /**
     * Handle the validation of a form
     * 
     * @param array $form the form to validate
     * @param array $fields the fields who are required for validate the form
     * @return boolean
     */
    public static function validate(array $form, array $fields): bool
    {

        foreach ($fields as $field) {
            if (!isset($form[$field]) || empty($form[$field])) {
                return false;
            }
        }
        return true;
    }

    /**
     * For adding attribut to an html element
     * @param array $attributs list of attributs  to add
     * @return string 
     */
    private function addAttributs(array $attributs): string
    {
        $str = '';

        $shortAttributs = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];

        foreach ($attributs as $attribut => $value) {
            if (in_array($attribut, $shortAttributs) && $value == true) {
                $str .= "$attribut ";
            } else {
                $str .= "$attribut='$value' ";
            }
        }
        return $str;
    }


    /**
     * Build the start of form
     * @param string $method http methode of the form by default is post
     * @param string $action the form action by default #
     * @param array $attributs attributs to add to the form
     * @return self 
     */
    public function startForm(array $attributs = [], string $action = '#', string $method = 'post'): self
    {

        $this->formCode .= "<form action='$action' method='$method'";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        return $this;
    }

    /**
     * Build the end of the form
     * @return self
     */
    public function endForm(): self
    {
        $this->formCode .= '</form>';
        return $this;
    }

    /**
     * Build label for form
     * @param string $for attribut for html
     * @param string $text text of the label
     * @param array $attributs attributs to add to the label
     * @return self
     */
    public function addLabelFor(string $for, string $text, array $attributs = []): self
    {
        $this->formCode .= "<label for='$for'";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        $this->formCode .= "$text</label>";
        return $this;
    }

    /**
     * Build input for the form
     * @param string $type 
     */
    public function addInput(string $type, string $name, array $attributs = []): self
    {

        $this->formCode .= "<input type='$type' name='$name'";
        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';
        return $this;
    }

    public function addSelect(string $name, array $options, array $attributs = []): self
    {

        $this->formCode .= "<select name='$name'";

        $this->formCode .= $attributs ? $this->addAttributs($attributs) . '>' : '>';

        foreach ($options as $value => $text) {
            $this->formCode .= "<option value='$value'>$text</option>";
        }

        $this->formCode .= '</select>';
        return $this;
    }

    public function addButton(string $text, array $attributs = []): self
    {
        $this->formCode .= '<button ';
        $this->formCode .= $attributs ? $this->addAttributs($attributs) : '';
        $this->formCode .= ">$text</button>";
        return $this;
    }
}
