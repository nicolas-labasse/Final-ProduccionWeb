

<div class="row text-center p-2 mx-auto">
  <?php 
        
        require_once './includes/conector.php';        
        $conn = new Conector();
        $result = $conn->CargarCategorias();

    while($row = $result->fetch_assoc()) {
      echo '
      
      <div class="col-12 col-md-6 mb-2">
        <a href="lista.php?categoria='.$row['categoria'].'" class="pro">
          <div class="card flotar sombrear p-1 bg-body rounded">
            <i class="text-violeta iconospro fa-solid '.$row['rutaIcono'].' display-4 mt-1"></i>
            <div class="card-body">
              <p class="card-title">'.$row['plural'].'</p>
            </div>
          </div>
        </a>
      </div>
      
      ';
    }
    
    ?>
</div>