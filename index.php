<!doctype html>
<html lang="es">

<?php require_once 'componentes/head.php';?>

<body>

  <?php require_once 'componentes/header.php'; ?>

  <section style="width: 100%">
    <div class="row m-0">
      <div class="col-12 col-lg-8 bg-secondary px-5 text-center">
        <h2 class="my-1"><span class="badge bg-danger">Promociones</span></h2>
        <?php require_once 'componentes/promociones.php'; ?>
        <h2 class="my-1"><span class="badge bg-danger">Medios de Pago</span></h2>
      </div>
      <div class="row col-12 col-lg-4 text-center mx-auto">
        <?php require_once 'componentes/categoriasmain.php'; ?>
      </div>
    </div>
  </section>

  <section>
    <div class="container-fluid p-0 mt-5">
      <div class="card bg-dark text-white bor text-center"></video>
        <div class="card-img-overlay">
        </div>
      </div>
    </div>
  </section>





  <?php require_once 'componentes/footer.php'; ?>

  <!-- scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
  <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script type="text/javascript" src="componentes/slick/slick.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $('.slickCarousel').slick({
        speed: 300,
        arrows: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: false,
        responsive: [{
            breakpoint: 1750,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
            }
          },
          {
            breakpoint: 1350,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 650,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
      });
    });
  </script>
</body>

</html>