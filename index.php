<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP File Browser</title>

    <!-- Styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <style>
      body { overflow-x: hidden; }
      .z-10 { z-index: 10; }
      .stripes { min-width: 100%; }
      .stripes div:nth-of-type(odd) { background-color: #e8f3fc; }
      .btn:focus, .btn:active { outline: none; box-shadow: none; }
      .dataTables_filter { margin-right: 20px; }
    </style>

  </head>
<body>

<!-- Path -->
<input type="hidden" name="path" value="<?= dirname(__FILE__) ?>">

<!-- Breadcrumb -->
<nav class="fixed-top" aria-label="breadcrumb">
  <ol class="breadcrumb border-bottom flex-nowrap">
    <!-- Logo -->
    <a href="index.php">
      <span class="fa-stack fa-sm mr-2 text-primary">
        <i class="fas fa-circle fa-stack-2x"></i>
        <i class="fas fa-folder-open fa-stack-1x fa-inverse"></i>
      </span>
    </a>

    <span id="breadcrumb" class="d-flex text-truncate"></span>

    <!-- For the next Sprint -->
    <!-- <div class="ml-auto text-nowrap">
      <a href="#" class="btn btn-outline-secondary py-0">Admin Panel <i class="fas fa-cog"></i></a>
      <a href="#" class="btn btn-outline-secondary py-0">Logout <i class="fas fa-sign-out-alt"></i></a>
    </div> -->

  </ol>
</nav>

<div class="pt-3 mt-5">

  <!-- Back button -->
  <button id="back" class="btn ml-3 py-0 btn-outline-secondary z-10 position-absolute"></button>

  <!-- Table -->
  <table id="table" class="table table-striped table-sm table-hover">
  <caption class="ml-3">End of list.</caption>
    <thead>
      <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Size</th>
        <th class="w-25 text-center">Action</th>
      </tr>
    </thead>
  </table>

</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header font-weight-bold">
        <span id="modalHeader"></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div id="modalBody" class="modal-body overflow-auto"></div>

    </div>
  </div>
</div>

<!-- JavaScript -->
<script src="https://kit.fontawesome.com/686684acdc.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="javascript.js"></script>

</body>
</html>