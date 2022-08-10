<?php

function dibujarAcordeon($identificador) {


    require_once './includes/conector.php';        
    $conn = new Conector();
    $result = $conn->CargarEspecialLateral();

    $lastCategoria = "";
    $conteoFilas = 0;

    echo '<div class="accordion" id="accordion'.$identificador.'">';

    foreach ($result as $row) {
        if ($row['categoriaPlural'] != $lastCategoria) {
            if ($lastCategoria != "")
                echo'</ul></div></div></div>';

            echo '
            
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading'.$identificador.$conteoFilas.'">
                        <button class="accordion-button collapsed py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$identificador.$conteoFilas.'"
                            aria-expanded="false" aria-controls="collapse'.$identificador.$conteoFilas.'">
                            '.$row['categoriaPlural'].'
                        </button>
                    </h2>
                
                    <div id="collapse'.$identificador.$conteoFilas.'" class="accordion-collapse collapse" aria-labelledby="heading'.$identificador.$conteoFilas.'"
                    data-bs-parent="#accordion'.$identificador.'">
                        <div class="accordion-body py-1">
                        <ul class="m-1 p-0">
                            <li><a href="lista.php?categoria='.$row['categoria'].'" class="btn btn-outline-dark btn-sm w-100">VER TODOS</a></li>
                            </br>
                            <li><a href="lista.php?categoria='.$row['categoria'].'&subcategoria='.$row['subcategoria'].'" class="btn btn-outline-dark btn-sm w-100">'.$row['subcategoriaPlural'].'</a></li>
            ';
        } else {
            echo '<li><a href="lista.php?categoria='.$row['categoria'].'&subcategoria='.$row['subcategoria'].'" class="btn btn-outline-dark btn-sm w-100">'.$row['subcategoriaPlural'].'</a></li>';
        }
        $lastCategoria = $row['categoriaPlural'];
        $conteoFilas++;
    }
    echo'</ul></div></div></div></div>';
}

?>