<?php
  $page_title = 'Add Sale';
  require_once('includes/load.php');
  page_require_level(3);
?>
<?php
  if(isset($_POST['add_sale'])){
    $req_fields = array('s_id','quantity','price','total', 'date' );
    validate_fields($req_fields);
    if(empty($errors)){
      $p_id      = $db->escape((int)$_POST['s_id']);
      $s_qty     = $db->escape((int)$_POST['quantity']);
      $s_total   = $db->escape($_POST['total']);
      $s_date    = make_date();

      $sql  = "INSERT INTO sales (product_id,qty,price,date) ";
      $sql .= "VALUES ('{$p_id}','{$s_qty}','{$s_total}','{$s_date}')";

      if($db->query($sql)){
        update_product_qty($s_qty,$p_id);
        $session->msg('s',"Sale added successfully!");
        redirect('add_sale.php', false);
      } else {
        $session->msg('d','Sorry, failed to add!');
        redirect('add_sale.php', false);
      }
    } else {
      $session->msg("d", $errors);
      redirect('add_sale.php',false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>

<style>
  .search-container {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    margin-bottom: 30px;
  }
  #sug_input {
    height: 50px;
    border-radius: 10px 0 0 10px;
    border: 2px solid #667eea;
    font-size: 16px;
  }
  .btn-find {
    height: 50px;
    border-radius: 0 10px 10px 0;
    background: #667eea;
    border: none;
    padding: 0 25px;
  }
  .sale-card {
    background: #fff;
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    overflow: hidden;
  }
  .sale-card .panel-heading {
    background: #f8f9fa;
    padding: 20px;
    border-bottom: 1px solid #eee;
  }
  .table thead th {
    background: #fdfdfd;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 1px;
    color: #718096;
    border: none;
  }
  #result {
    position: absolute;
    width: 93%;
    z-index: 999;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
  }
</style>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12"><?php echo display_msg($msg); ?></div>
  </div>

  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="search-container text-center">
        <h2 style="font-weight: 700; margin-bottom: 20px; color: #2d3748;">New Transaction</h2>
        <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
          <div class="input-group">
            <input type="text" id="sug_input" class="form-control" name="title" placeholder="Type product name to start selling...">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary btn-find">
                <i class="glyphicon glyphicon-search"></i> Find Product
              </button>
            </span>
          </div>
          <div id="result" class="list-group"></div>
        </form>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="panel sale-card">
        <div class="panel-heading">
          <strong><i class="glyphicon glyphicon-shopping-cart" style="color: #667eea;"></i> Sale Details</strong>
        </div>
        <div class="panel-body">
          <form method="post" action="add_sale.php">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th style="width: 35%;">Item Name</th>
                  <th style="width: 15%;">Price</th>
                  <th style="width: 15%;">Qty Available</th>
                  <th style="width: 15%;">Total</th>
                  <th style="width: 15%;">Date</th>
                  <th style="width: 5%;">Action</th>
                </tr>
              </thead>
              <tbody id="product_info">
                </tbody>
            </table>
            
            <div id="empty-state" class="text-center" style="padding: 40px; color: #a0aec0;">
                <i class="glyphicon glyphicon-inbox" style="font-size: 40px; display: block; margin-bottom: 10px;"></i>
                <p>No items added. Search for a product above to start.</p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>