<?php

function Paginador($paginaActual, $cantidadRegistros, $rPP) {
    
    $cantidadPaginas = ceil($cantidadRegistros / $rPP);

    $paginacion = array (
        'primera' => ($paginaActual > 1) ? 1 : null,
        'anterior' => ($paginaActual > 1) ? $paginaActual - 1 : null,
        'actual' => $paginaActual,
        'siguiente' => ($paginaActual < $cantidadPaginas) ? $paginaActual + 1 : null,
        'ultima' => ($paginaActual < $cantidadPaginas) ? $cantidadPaginas : null,
        'cantidadPaginas' => $cantidadPaginas
    );

    return $paginacion;
}

function CalcularLimites($pagina, $limite) {
    return ($pagina - 1) * $limite;
}