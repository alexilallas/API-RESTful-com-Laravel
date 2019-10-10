<?php
/**
 * Esta função remove todos os acentos de uma string
 *
 * @param string $string A palavra a ser removida os acentos
 *
 * @return string $string A palavra sem os acentos
 */
if (! function_exists('removeAcentos')) {
    function removeAcentos($string)
    {
        return preg_replace(
            array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/",
            "/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/",
            "/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),
            explode(" ", "a A e E i I o O u U n N"), $string);
    }
}
