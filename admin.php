<?php
  $page_title = 'Admin Home Page';
  require_once('includes/load.php');
  page_require_level(1);

  $c_categorie     = count_by_id('categories');
  $c_product       = count_by_id('products');
  $c_sale          = count_by_id('sales');
  $c_user          = count_by_id('users');
  $products_sold   = find_higest_saleing_product('10');
  $recent_products = find_recent_product_added('5');
  $recent_sales    = find_recent_sale_added('5');
?>
<?php include_once('layouts/header.php'); ?>

<style>
  body { background-color: #f8f9fc; font-family: 'Inter', sans-serif; }
  
  /* Smooth Transitions */
  .animate-up {
    transition: all 0.3s cubic-bezier(.25,.8,.25,1);
  }
  .animate-up:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.1) !important;
  }

  /* Glass Card Styling */
  .stat-card {
    border: none;
    border-radius: 16px;
    background: #ffffff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    padding: 25px;
    display: flex;
    align-items: center;
    margin-bottom: 25px;
  }

  .icon-circle {
    width: 55px;
    height: 55px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-right: 15px;
    flex-shrink: 0;
  }

  /* Vibrant Colors */
  .text-indigo { color: #667eea; }
  .bg-soft-green { background: #e8faf0; color: #2ecc71; }
  .bg-soft-blue { background: #eaf4fe; color: #3498db; }
  .bg-soft-red { background: #feecef; color: #e74c3c; }
  .bg-soft-yellow { background: #fff9e6; color: #f1c40f; }

  /* Welcome Banner */
  .welcome-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 50px 30px;
    color: white;
    margin-bottom: 40px;
    position: relative;
    overflow: hidden;
  }
  .welcome-banner::after {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
  }

  /* Data Table Cards */
  .data-card {
    background: #fff;
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    margin-bottom: 30px;
    height: 100%;
  }
  .data-card .panel-heading {
    background: transparent;
    padding: 20px;
    border-bottom: 1px solid #f1f1f1;
    font-weight: 700;
    font-size: 15px;
    display: flex;
    align-items: center;
  }
  .data-card .panel-heading i { margin-right: 10px; }

  /* Small Details */
  .price-tag {
    background: #f1f3f9;
    color: #4a5568;
    padding: 4px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
  }
  .img-product {
    width: 45px;
    height: 45px;
    object-fit: cover;
    border-radius: 10px;
    margin-right: 12px;
  }
  .list-item-hover {
    transition: background 0.2s;
    border-bottom: 1px solid #f8f9fa !important;
    display: flex;
    align-items: center;
    padding: 15px 20px !important;
  }
  .list-item-hover:hover { background: #fcfdff; }
  
  /* Responsive spacing */
  @media (max-width: 768px) {
    .stat-card { padding: 15px; }
    .welcome-banner { padding: 30px 15px; }
  }
</style>

<div class="container-fluid">
  <div class="row">
     <div class="col-md-12"><?php echo display_msg($msg); ?></div>
  </div>

  <div class="row">
    <div class="col-md-12 text-center">
      <div class="welcome-banner animate-up">
         <h1 style="font-weight: 800; letter-spacing: -1px;">Dashboard Overview</h1>
         <p style="font-size: 18px; opacity: 0.9;">Welcome back! Here is what's happening with your inventory today.</p>
      </div>
    </div>
  </div>

  <div class="row">
    <?php 
      $cards = [
        ['Users', $c_user['total'], 'glyphicon-user', 'bg-soft-green'],
        ['Categories', $c_categorie['total'], 'glyphicon-th-list', 'bg-soft-red'],
        ['Products', $c_product['total'], 'glyphicon-shopping-cart', 'bg-soft-blue'],
        ['Sales', $c_sale['total'], 'glyphicon-usd', 'bg-soft-yellow']
      ];
      foreach($cards as $c): 
    ?>
    <div class="col-sm-6 col-lg-3">
      <div class="stat-card animate-up">
        <div class="icon-circle <?php echo $c[3]; ?>">
          <i class="<?php echo $c[2]; ?>"></i>
        </div>
        <div>
          <h3 style="margin:0; font-weight:800;"><?php echo $c[1]; ?></h3>
          <small class="text-muted" style="text-transform: uppercase; letter-spacing: 1px; font-weight: 600; font-size: 11px;"><?php echo $c[0]; ?></small>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="row">
    <div class="col-lg-4 col-md-6">
      <div class="panel data-card">
        <div class="panel-heading">
          <i class="glyphicon glyphicon-signal text-indigo"></i> Highest Selling
        </div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <tr class="text-muted" style="font-size: 12px;">
                <th>Product</th>
                <th class="text-center">Sold</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products_sold as $ps): ?>
              <tr>
                <td style="font-weight: 500;"><?php echo remove_junk(first_character($ps['name'])); ?></td>
                <td class="text-center"><span class="badge" style="background:#667eea;"><?php echo (int)$ps['totalSold']; ?></span></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6">
      <div class="panel data-card">
        <div class="panel-heading">
          <i class="glyphicon glyphicon-time text-indigo"></i> Recent Sales
        </div>
        <div class="panel-body" style="padding:0;">
          <div class="list-group" style="margin:0;">
            <?php foreach ($recent_sales as $rs): ?>
            <a href="edit_sale.php?id=<?php echo (int)$rs['id']; ?>" class="list-group-item list-item-hover">
              <div style="flex-grow: 1;">
                <div style="font-weight:600; color:#2d3748;"><?php echo remove_junk(first_character($rs['name'])); ?></div>
                <small class="text-muted"><?php echo date("d M, Y", strtotime($rs['date'])); ?></small>
              </div>
              <span class="price-tag">$<?php echo (float)$rs['price']; ?></span>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-12">
      <div class="panel data-card">
        <div class="panel-heading">
          <i class="glyphicon glyphicon-plus text-indigo"></i> Recently Added
        </div>
        <div class="panel-body" style="padding:0;">
          <div class="list-group" style="margin:0;">
            <?php foreach ($recent_products as $rp): ?>
            <a href="edit_product.php?id=<?php echo (int)$rp['id'];?>" class="list-group-item list-item-hover">
                <img class="img-product" src="uploads/products/<?php echo ($rp['media_id'] === '0') ? 'no_image.jpg' : $rp['image']; ?>" alt="">
                <div style="flex-grow: 1;">
                  <div style="font-weight:600; color:#2d3748;"><?php echo remove_junk(first_character($rp['name'])); ?></div>
                  <span class="label label-default" style="font-size:10px;"><?php echo remove_junk($rp['categorie']); ?></span>
                </div>
                <span class="text-indigo" style="font-weight:700;">$<?php echo (int)$rp['sale_price']; ?></span>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>