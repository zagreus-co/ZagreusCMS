<?php

namespace App\Livewire\Table;

class TableButton
{
    protected string $element = "button";

    public function __construct(
        public string $text = '',
        public string $class = "btn btn-light",
        public string $action = ""
    ) {
    }

    public function icon(string $icon_name): TableButton
    {
        $this->text .= "<ion-icon class=\"hydrated\" name=\"{$icon_name}\"></ion-icon>";

        return $this;
    }

    /**
     * Append or prepend text to button
     * if set $append to false, return this function will prepend your text
     *
     * @param string $text
     * @param boolean $append
     * @return TableButton
     */
    public function text(string $text, bool $append = true): TableButton
    {
        $this->text = $append ? $this->text . $text : $text . $this->text;

        return $this;
    }

    /**
     * Set class of the button
     *
     * @param string $class
     * @return TableButton
     */
    public function class(string $class): TableButton
    {
        $this->class = $class;
        return $this;
    }

    public function livewire(string $value, string $method = 'wire:click'): TableButton
    {
        $this->action = "{$method}=\"$value\"";
        return $this;
    }

    public function link(string $url, string $target = "_blank"): TableButton
    {
        $this->element = 'a';
        $this->action = "href=\"{$url}\" target=\"{$target}\"";

        return $this;
    }

    public function html()
    {
        $button = "<{$this->element} {$this->action} class=\"{$this->class}\">";

        $button .= $this->text;

        return $button . "</{$this->element}>";
    }
}
