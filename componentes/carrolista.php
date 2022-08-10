<?php

function dibujarCarroLista ($configVistas) {
echo '
<div class="dropdown '.$configVistas.'">
        <a class="btn btn-outline-light" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
          aria-expanded="false" data-bs-auto-close="outside">
          <i class="fa-solid fa-cart-arrow-down"></i>

        </a>
        


        <ul class="dropdown-menu dropdown-menu-end p-0 shadow" style="max-height: 400px;" aria-labelledby="dropdownMenuLink">';
        
        require_once './includes/conector.php';
        $conn = new Conector();
        $result = $conn->CargarCarrito();
           
          
             if($result->num_rows>0){
              echo '<li style="overflow-y: scroll; max-height: 300px">';
              $total = 0;
              $cantidadProductos = 0;

              foreach($result as $row){
                $total += $row['precio'] * $row['cantidad'];
                $cantidadProductos += $row['cantidad'];
                echo'
                
                    <div class="card" style="width: 300px;">
                      <div class="row g-0">
                        <div class="col-3 my-2">
                          <img src="./imagenes/productos/'.$row['rutaImagen'].'" style="object-fit: contain; height:60px" class="ms-2" alt="...">
                        </div>
                        <div class="col-9">
                          <div class="card-body">
                            <p class="card-text m-0">'. $row['cantidad'] .'x ' .$row['marca'].' '.$row['modelo'].'</p>
                            <p class="card-text">$ '.number_format($row['precio'], 0, ",", ".").'</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  
                ';

                
              }
              echo '</li>';
              echo'
                <li>
                  <p class="mt-3 ms-1">Total: $ '.number_format($total, 0, ",", ".").' </p>
                </li>
                <div class="text-center mb-3">
                  <li><a href="./carrito.php" class="btn btn-outline-dark" style="width: 80%;">Ir al
                      Carrito</a></li>
                </div>
              ';

             } else {
              echo '
              <li>
                <p class="mt-3 ms-1">Nada por aqui</p>
              </li>';
               
             }
             echo '
              </ul>  ';
                if($result->num_rows > 0){
                echo '
                <span class="position-relative top-0 start-0 translate-middle badge rounded-pill bg-danger">
                '.$cantidadProductos.'
                <span class="visually-hidden">unread messages</span>
                </span>
                ';
             }
              echo'
              </div>
              ';
             
           

            



          
         
       
}