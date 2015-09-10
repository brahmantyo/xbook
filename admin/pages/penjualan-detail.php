<?php 
    Login::restrictAdmin();
    $objPenjualan = new Penjualan();
    $id = Helper::encodeHTML($_GET['detailinvoice']);
    $header = $objPenjualan->getInvoice($id);
    $noinvoice = $header['noinvoice'];
    $tgl = Helper::dateFromMySqlSystem($header['tgl']);
    $sales = $header['sales'];	

    $invoice = $objPenjualan->getPenjualanInvoice($noinvoice);
    
 ?>
<?php ?>
<html>
    <head>
        <title>XBook Control Panel</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrap-theme.min.css">

        <link href="css/Core.css" rel="stylesheet" type="text/css" />
        <link href="css/Menu.css" rel="stylesheet" type="text/css" />

        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/bootstrap-datepicker.js"></script>


    </head>
    <body>
		<div class="table-responsive">
			<table style="font-size: 12" class="table table-condensed table-striped table-bordered table-hover no-margin">
				<tr>
					<td colspan="8">
					<table width="100%">
						<tr><td style="text-align: center" colspan="2"><h3><b>Detail Invoice</b></h3></td></tr>
						<tr><td style="text-align: center" colspan="2">No : <?php echo $noinvoice;?></td></tr>
						<tr><td colspan="2"></td></tr>
						<tr><td style="width: 60">Tanggal </td><td>: <?php echo $tgl;?></td></tr>
						<tr><td style="width: 60">Sales </td><td>: <?php echo $sales;?></td></tr>
					</table>
					</td>
				</tr>
				<tr>
					<td>No.</td>
					<td>Part No.</td>
					<td>SN</td>
					<td>Nama Barang</td>
					<td>Qty</td>
					<td>Harga</td>
					<td>Disc</td>
					<td>Jumlah</td>
				</tr>
				<?php 
					$no=1;
					foreach($invoice as $i){ 
				?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?php echo $i['part']; ?></td>
					<td><?php echo $i['sn']; ?></td>
					<td><?php echo $i['nama']; ?></td>
					<td><?php echo $i['qty']; ?></td>
					<td style="text-align: right"><?php echo Helper::currency($i['harga']); ?></td>
					<td style="text-align: right"><?php echo Helper::currency($i['disc']); ?></td>
					<td style="text-align: right"><?php echo Helper::currency($i['jumlah']); ?></td>
				</tr>
				
				<?php $no++; }  ?>	
			</table>
		</div>
	</body>
</html>