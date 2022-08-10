<?php

function imprimirCuadrada($titulo, $texto, $imagen, $prodID) {
    echo '
    <div class="text-center p-2">
        <div class="card text-dark mx-3 mx-sm-auto my-2" style="width: 16rem; height:22rem">
            <a href="producto.php?id=' . $prodID . '" class="noStyle">
                <img class="p-2 mx-auto w-100" src="imagenes/productos/' . $imagen . '" style="object-fit: contain; height:11rem" alt="...">
                <hr class="bg-secondary">
                <div class="card-body" style="color: black;">
                    <h4 class="card-title fw-bold">' . $titulo . '</h4>
                    <p class="card-text">' . $texto . '</p>
                </div>
            </a>
        </div>
    </div>
    ';
}

function imprimirHorizontal($titulo, $texto, $subtexto, $imagen, $prodID) {
    echo '
        
        <div class="card p-1 my-2" style="width: 100%; height: 140px;">
            <a href="producto.php?id='.$prodID.'" class="noStyle">
                <div class="row">
                    <div class="col-3 d-flex" style="max-width: 135px; min-width: ">
                        <img class="p-2 rounded-start" src="imagenes/productos/'.$imagen.'" style="object-fit: contain;max-height: 135px; max-width: 135px;" alt="...">
                    </div>
                    <div class="col-9">
                        <div class="card-body">
                            <p class="card-title">'.$titulo.'</p>
                            <h5 class="card-text">'.$texto.'</h5>
                            <p class="card-text"><small class="text-muted">'.$subtexto.'</small></p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
    ';

}


function imprimirHorizontalCarro($titulo, $texto, $subtexto, $imagen, $prodID) {
    echo '
        
        <div class="card p-1 my-2" style="width: 100%; height: 140px;">
            <div class="row justify-content-between">
                <a href="producto.php?id='.$prodID.'" class="noStyle col-10">
                  <div class="row">
                    <div class="col-3 d-flex" style="max-width: 135px">
                        <img class="p-2 rounded-start" src="imagenes/productos/'.$imagen.'" style="object-fit: contain;max-height: 135px; max-width: 135px;" alt="...">
                    </div>
                    <div class="col-6">
                        <div class="card-body">
                            <p class="card-title">'.$titulo.'</p>
                            <h5 class="card-text">'.$texto.'</h5>
                            <p class="card-text"><small class="text-muted">'.$subtexto.'</small></p>
                        </div>
                    </div>
                    </div>
                </a>
                    <div class="col-1">
                        <a href="procedimientos/carritoBorrar.php?prodID='.$prodID.'"><i class="fa-solid fa-cart-arrow-down btn btn-outline-dark"></i></a>
                    </div>
            </div>
        </div>
        
        
    ';

}


function imprimirDetalle($titulo, $texto, $precio, $imagen, $prodID) {
    echo '
        
    <div class="card p-1 my-2" style="width: 100%; height: 140px;">
        <a href="producto.php?id='.$prodID.'" class="noStyle">
            <div class="row">
                <div class="col-3 d-flex" style="max-width: 135px; min-width: ">
                    <img class="p-2 rounded-start" src="imagenes/productos/'.$imagen.'" style="object-fit: contain;max-height: 135px; max-width: 135px;" alt="...">
                </div>
                <div class="col-9">
                    <div class="card-body">
                        <p class="card-title">'.$titulo.'</p>
                        <h5 class="card-text">'.$texto.'</h5>
                        <p class="card-text"><small class="text-muted">'.$precio.'</small></p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
';
}


