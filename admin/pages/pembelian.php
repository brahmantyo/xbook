
<?php require_once("_header.php"); ?>
<?php
    if($objForm->isPost('dafcabang')){
        if($objPembelian->_result_count){
?>


<div style="height: 200;" class="visible-lg">&nbsp;</div>

<div id="datalist" align="center" class="col-sm-12">
    <div id="summary-lg" class="well table-responsive visible-lg" >&nbsp;</div>
    <div id="summary-sm" class="well table-responsive visible-sm visible-md visible-xs" >&nbsp;</div>

<?php   if($group == "part"){ ?>
    <table class="table table-condensed table-striped table-bordered table-hover no-margin">
        <tbody>
            <tr>
                <th colspan="15" style="text-align: center; font-weight: bold;">
                    <div><h3>Laporan Pembelian Berdasarkan Tipe Barang (Part)</h3></div>
                    <div><h4>Cabang : <?php echo $nmcabang;?></h4></div>
                    <div><h4>Tanggal : <?php echo Helper::dateFromMySqlSystem($objPembelian->_startDate);?> s/d <?php echo Helper::dateFromMySqlSystem($objPembelian->_endDate);?></h4></div>
                </th>
            </tr>            
            <?php
                $nmr=0;
                $gtqty = 0;
                $gthrgbeli = 0;

                foreach ($listPembelian as $key=> $part){
            ?>
            <tr><td colspan="15" height="50"><b>Part.No/Nama :&nbsp;<?php echo $key; ?></b></td></tr>
            <tr><td><div class="table-responsive">
                <table style="font-size: 12" class="table table-condensed table-striped table-bordered table-hover no-margin">
                    <tr>
                        <th style="width: 1%">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th style="width: 1%">No.</th>
                        <th style="width: 1%">Tanggal</th>
                        <th style="width: 1%">Invoice #</th>
                        <th style="width: 1%">Serial Number</th>
                        <th style="width: 1%">Tipe</th>
                        <th style="width: 1%">Qty</th>
                        <th style="width: 1%">Hrg Beli (IDR)</th>
                        <th style="width: 1%">Hrg Beli (USD)</th>
                        <th style="width: 1%">Pembayaran</th>
                        <th style="width: 1%">Currency</th>
                        <th style="width: 1%">Nama Pegawai</th>
                        <th >Cabang</th>
                    </tr>
                <?php             
                    $no=0;
                    $tqty = 0;
                    $thrgbeli = 0;

                    foreach ($part as $data){
                        $no++;
                        $nmr++;
                ?>
                    <tr>
                        <td><?php echo $nmr; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?php echo $no;?></td>
                        <td><?php echo Helper::dateFromMySqlSystem($data['tgl']);?></td>
                        <td><?php echo $data['nota'];?></td>
                        <td><?php echo $data['sn'];?></td>
                        <td><?php echo $data['tipe'];?></td>
                        <td class="text-center"><?php echo $data['qty'];?></td>
                        <td class="text-right"><?php echo Helper::currency($data['hrgbeliidr']);?></td>
                        <td class="text-right"><?php echo Helper::currency($data['hrgbeliusd']);?></td>
                        <td class="text-right"><?php echo $data['bayar'];?></td>
                        <td><?php echo $data['cur'];?></td>
                        <td><?php echo $data['pegawai'];?></td>
                        <td><?php echo $data['cabang'];?></td>

                    </tr>
                <?php 
                    $qty = $data['qty'];
                    $hrgbeliidr=$data['hrgbeliidr'];
                    $tqty += $qty;
                    $thrgbeli += $qty * $hrgbeliidr;

                    $gtqty += $qty;    
                    $gthrgbeli += $qty * $hrgbeliidr;
                    flush();
                    }
                ?>
                    <tr>
                        <td colspan="8" align="right">Total &nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td class="text-right"><?php echo Helper::number($tqty);?></td>
                        <td class="text-right"><?php echo Helper::currency($thrgbeli);?></td>
                    </tr>
                </table>
                </div></td>
            </tr>
            <?php flush();} ?>
        </tbody>
    </table>

<?php } else if($group=="tanggal") { ?>
        <table class="table table-condensed table-striped table-bordered table-hover no-margin">
        <tbody>
            <tr>
                <th colspan="15" style="text-align: center; font-weight: bold;">
                    <div><h3>Laporan Pembelian Berdasarkan Tanggal</h3></div>
                    <div><h4>Cabang : <?php echo $nmcabang;?></h4></div>
                    <div><h4>Tanggal : <?php echo Helper::dateFromMySqlSystem($objPembelian->_startDate);?> s/d <?php echo Helper::dateFromMySqlSystem($objPembelian->_endDate);?></h4></div>
                </th>
            </tr>             <?php
                $nmr=0;
                $gtqty = 0;
                $gthrgbeli = 0;

                foreach ($listPembelian as $key=> $list){
            ?>
            <tr><td colspan="15" height="50"><b>Tanggal :&nbsp;<?php echo Helper::dateFromMySqlSystem($key); ?></b></td></tr>
            <tr><td><div class="table-responsive">
                <table style="font-size: 12" class="table table-condensed table-striped table-bordered table-hover no-margin">
                    <tr>
                        <th style="width: 1%">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th style="width: 1%">No.</th>
                        <th style="width: 1%">Invoice #</th>
                        <th style="width: 1%">Part</th>
                        <th style="width: 1%">Serial Number</th>
                        <th >Nama Barang</th>
                        <th style="width: 1%">Tipe</th>
                        <th style="width: 1%">Qty</th>
                        <th style="width: 1%">Hrg Beli (IDR)</th>
                        <th style="width: 1%">Hrg Beli (USD)</th>
                        <th style="width: 1%">Pembayaran</th>
                        <th style="width: 1%">Currency</th>
                        <th style="width: 1%">Nama Pegawai</th>
                        <th style="width: 1%">Cabang</th>
                    </tr>
                <?php             
                    $no=0;
                    $tqty = 0;
                    $thrgbeli = 0;

                    foreach ($list as $data){
                        $no++;
                        $nmr++;
                ?>
                    <tr>
                        <td><?php echo $nmr; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?php echo $no;?></td>
                        <td><?php echo $data['nota'];?></td>
                        <td><?php echo $data['part'];?></td>
                        <td><?php echo $data['sn'];?></td>
                        <td><?php echo $data['nmbarang'];?></td>
                        <td><?php echo $data['tipe'];?></td>
                        <td class="text-right"><?php echo $data['qty'];?></td>
                        <td class="text-right"><?php echo Helper::currency($data['hrgbeliidr']);?></td>
                        <td class="text-right"><?php echo Helper::currency($data['hrgbeliusd']);?></td>
                        <td class="text-right"><?php echo $data['bayar'];?></td>
                        <td><?php echo $data['cur'];?></td>
                        <td><?php echo $data['pegawai'];?></td>
                        <td><?php echo $data['cabang'];?></td>

                    </tr>
                <?php 
                    $qty = $data['qty'];
                    $hrgbeliidr=$data['hrgbeliidr'];
                    $tqty += $qty;
                    $thrgbeli += $qty * $hrgbeliidr;

                    $gtqty += $qty;    
                    $gthrgbeli += $qty * $hrgbeliidr;

                    }
                ?>
                    <tr>
                        <td colspan="6" align="right">Total &nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td class="text-right"><?php echo Helper::number($tqty);?></td>
                        <td class="text-right"><?php echo Helper::currency($thrgbeli);?></td>
                    </tr>
                </table>
                    </div></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
<?php }?>
</div>
<?php } else { ?>
<div id="datalist" align="center" class="col-lg-10">
    <div>&nbsp;</div>
    <div class="alert alert-danger alert-dismissable" >
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <center><strong>Data Tidak ditemukan</strong></center>
    </div>
</div>
<?php } ?>

<?php } ?>

<script type="text/javascript">
$('#summary-lg').append('<table style="font-size: 12;" class="table table-condensed table-striped table-bordered table-hover no-margin" border="1" width="100%">'+
        '<tr><td width="20%">Jumlah Transaksi </td><td><?php echo Helper::number($nmr); ?></td></tr>'+
        '<tr><td width="20%">Total Qty </td><td><?php echo Helper::number($gtqty); ?></td></tr>'+        
        '<tr><td>Total Hrg.Beli </td> <td><?php echo Helper::currency($gthrgbeli); ?></td></tr>'+
        '</table>');
$('#summary-sm').append('<table style="font-size: 12;" class="table table-condensed table-striped table-bordered table-hover no-margin" border="1" width="100%">'+
        '<tr><td width="20%">Jumlah Transaksi </td><td><?php echo Helper::number($nmr); ?></td></tr>'+
        '<tr><td width="20%">Total Qty </td><td><?php echo Helper::number($gtqty); ?></td></tr>'+        
        '<tr><td>Total Hrg.Beli </td> <td><?php echo Helper::currency($gthrgbeli); ?></td></tr>'+
        '</table>');
</script>
<?php require_once("_footer.php"); ?>