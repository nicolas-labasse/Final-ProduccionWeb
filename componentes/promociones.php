<div class="slickCarousel mx-auto" style="width: 95%">
  <?php 
    
    require_once './includes/conector.php';        
    $conn = new Conector();
    $result = $conn->CargarListadoPromociones();

  require_once 'componentes/card.php';

  foreach ($result as $row) {
    imprimirCuadrada("$ " . number_format($row['precio'], 0, ",", "."), $row['nombre'], $row['rutaImagen'], $row['id']);
  }?>
   <div class="text-center p-2">
        <div class="card flotar sombrear text-dark mx-3 mx-sm-auto my-2" style="width: 16rem; height:22rem">
            <a href="lista.php" class="noStyle">
                <i class="fa-solid fa-arrow-right display-4 pt-5" style="object-fit: contain; height:11rem; color: black;"></i>
                <hr class="bg-secondary">
                <div class="card-body" style="color: black;">
                    <h4 class="card-title fw-bold">VER MÁS</h4>
                </div>
            </a>
        </div>
    </div>
</div>