<?php
$page_title = 'Sales Report';
$results = '';
require_once('includes/load.php');
page_require_level(3);
?>
<?php
  if(isset($_POST['submit'])){
    $req_dates = array('start-date','end-date');
    validate_fields($req_dates);

    if(empty($errors)):
      $start_date   = remove_junk($db->escape($_POST['start-date']));
      $end_date     = remove_junk($db->escape($_POST['end-date']));
      
      // Step 1: Get the raw database result
      $db_results   = find_sale_by_dates($start_date,$end_date);
      
      // Step 2: Convert database object to a clean array to fix the PHP Warning
      $results = array();
      while($row = $db->fetch_assoc($db_results)){
        $results[] = $row;
      }
      
    else:
      $session->msg("d", $errors);
      redirect('sales_report.php', false);
    endif;
  } else {
    $session->msg("d", "Select dates");
    redirect('sales_report.php', false);
  }
?>
<!doctype html>
<html lang="en-US">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Sales Report | SmartShelf-Sync</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
   <style>
     body { background: #fdfdfd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; }
     .report-container { width: 950px; margin: 50px auto; background: white; padding: 40px; box-shadow: 0 0 20px rgba(0,0,0,0.05); border-radius: 10px; }
     .report-header { border-bottom: 2px solid #667eea; padding-bottom: 20px; margin-bottom: 30px; }
     .report-header h1 { font-weight: 800; color: #2d3748; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
     .report-header p { color: #718096; margin: 5px 0 0; font-size: 16px; }
     
     .table { margin-bottom: 0; }
     .table thead tr th { background: #f8fafc; border: 1px solid #e2e8f0; color: #4a5568; text-transform: uppercase; font-size: 11px; padding: 12px; }
     .table tbody tr td { border: 1px solid #e2e8f0; padding: 12px; vertical-align: middle; }
     
     .text-right { text-align: right; }
     .total-row { background: #f8fafc; font-weight: bold; }
     .profit-row { background: #e8faf0; color: #2e7d32; font-weight: bold; }
     
     @media print {
       body { background: white; }
       .report-container { box-shadow: none; margin: 0; width: 100%; padding: 20px; }
       .btn-print { display: none; }
     }
     .btn-print { margin-bottom: 20px; background: #667eea; border: none; border-radius: 5px; padding: 10px 20px; color: white; font-weight: 600; cursor: pointer; }
   </style>
</head>
<body>
  <?php if(!empty($results)): ?>
    <div class="report-container">
        <button class="btn-print pull-right" onclick="window.print();">Print Report</button>
        <div class="report-header">
            <h1>SmartShelf-Sync</h1>
            <p>Sales Report: <strong><?php echo $start_date; ?></strong> — <strong><?php echo $end_date; ?></strong></p>
        </div>

      <table class="table table-bordered">
        <thead>
          <tr>
              <th class="text-center">Date</th>
              <th>Product Title</th>
              <th class="text-right">Buying Price</th>
              <th class="text-right">Selling Price</th>
              <th class="text-center">Qty</th>
              <th class="text-right">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($results as $result): ?>
           <tr>
              <td class="text-center"><?php echo remove_junk($result['date']);?></td>
              <td>
                <span style="font-weight:600;"><?php echo remove_junk(ucfirst($result['name']));?></span>
              </td>
              <td class="text-right">$<?php echo number_format((float)$result['buy_price'], 2);?></td>
              <td class="text-right">$<?php echo number_format((float)$result['sale_price'], 2);?></td>
              <td class="text-center"><?php echo (int)$result['total_sales'];?></td>
              <td class="text-right" style="font-weight:600;">$<?php echo number_format((float)$result['total_saleing_price'], 2);?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
          <?php 
            // Corrected Math Logic
            $totals = total_price($results);
            $grand_total = isset($totals[0]) ? $totals[0] : 0;
            $profit = isset($totals[1]) ? $totals[1] : 0;
          ?>
          <tr class="total-row">
            <td colspan="4" style="border:none;"></td>
            <td class="text-right">Grand Total</td>
            <td class="text-right">$<?php echo number_format((float)$grand_total, 2);?></td>
          </tr>
          <tr class="profit-row">
            <td colspan="4" style="border:none;"></td>
            <td class="text-right">Net Profit</td>
            <td class="text-right">$<?php echo number_format((float)$profit, 2);?></td>
          </tr>
        </tfoot>
      </table>
      
      <div style="margin-top:40px; border-top:1px solid #eee; padding-top:20px;">
          <small class="text-muted">Report generated on <?php echo date("F j, Y, g:i a"); ?> by SmartShelf-Sync</small>
      </div>
    </div>
  <?php
    else:
        $session->msg("d", "No sales records found for this period.");
        redirect('sales_report.php', false);
     endif;
  ?>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>