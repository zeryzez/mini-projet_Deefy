<?php
namespace iutnc\deefy\render;
interface Renderer{
    const COMPACT = "compact";
    const LONG = "long";
    public function render(String $selector): String;
}  