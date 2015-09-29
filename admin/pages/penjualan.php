
<?php require_once("_header.php"); ?>
<?php 

$nmr=0;
$trans=0;
$nota = '';
$gtqty = 0;
$gthrgbeli = 0;
$gthrgjual = 0;
$gtlaba = 0;
$gtbonus = 0;
$gtdisc = 0;


    if($objForm->isPost('dafcabang')){
        if($objPenjualan->_result_count){
?>
<div style="height: 260;" class="visible-lg">&nbsp;</div>
<div id="datalist" align="center" class="col-sm-12">
    <div id="summary-lg" class="alert table-responsive visible-lg" >&nbsp;</div>
    <div id="summary-sm" class="alert table-responsive visible-sm visible-md visible-xs" >&nbsp;</div>
<?php   if($group == "part"){ ?>
    <table class="table table-condensed table-striped table-bordered table-hover no-margin">
        <tbody>
            <tr>
                <th colspan="15" style="text-align: center; font-weight: bold;">
                    <div><h3>Laporan Penjualan Berdasarkan Tipe Barang (Part)</h3></div>
                    <div><h4>Cabang : <?php echo $nmcabang;?></h4></div>
                    <div><h4>Tanggal : <?php echo Helper::dateFromMySqlSystem($objPenjualan->_startDate);?> s/d <?php echo Helper::dateFromMySqlSystem($objPenjualan->_endDate);?></h4></div>
                </th>
            </tr>
            <?php
/*                $nmr=0;
                $gtqty = 0;
                $gthrgbeli = 0;
                $gthrgjual = 0;
                $gtdisc = 0;
                $gtlaba = 0;*/

                foreach ($listPenjualan as $key=> $part){
            ?>
            <tr><td colspan="15" height="50"><b>Part.No/Nama :&nbsp;<?php echo $key; ?></b></td></tr>
            <tr><td><div class="table-responsive">
                <table style="font-size: 12" class="table table-condensed table-bordered table-hover no-margin">
                    <thead class="header">
                    <tr>
                        <th style="width: 20">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th style="width: 20">No.</th>
                        <th style="width: 60">Tanggal</th>
                        <th >Invoice #</th>
                        <th >Serial Number</th>
                        <th >Branch</th>
                        <th >Nama Sales</th>
                        <th >Currency</th>
                        <th style="width: 10">Quantity</th>
                        <th style="width: 60">Hrg Beli (IDR)</th>
                        <th style="width: 60">Hrg Beli (USD)</th>
                        <th style="width: 60">Hrg Jual (IDR)</th>
                        <th style="width: 60">Hrg Jual (USD)</th>
                        <th style="width: 60">Disc</th>
                        <th style="width: 20">Bayar</th>
                    </tr>
                    </thead>
                    <tbody>
                <?php             
                    $no=0;
                    $tqty = 0;
                    $thrgbeli = 0;
                    $thrgjual = 0;
                    $tbonus = 0;
                    $tdisc = 0;
                    $tlaba = 0;
                    $background = 'ganjil';

                    foreach ($part as $data){
                        // $no++;
                        // $nmr++;

                        $no++;
                        $nmr++;

                        $background = $no%2?'genap':'ganjil';
                        

                        $qty = (int)$data['qty'];
                        $hrgjualidr = (float)$data['hrgjualidr'];
                        $hrgjualusd = (float)$data['hrgjualusd'];
                        $hrgbeliidr = $hrgjualidr==0?0:(float)$data['hrgbeliidr'];
                        $hrgbeliusd = $hrgjualusd==0?0:(float)$data['hrgbeliusd'];
                        $bonus = (float)$data['bonus'];
                        $disc = (float)$data['disc'];
                        $laba = $qty * ($hrgjualidr - $hrgbeliidr - $disc) - $bonus;

                        $tqty += $qty;
                        $thrgbeli += $qty*$hrgbeliidr;
                        $thrgjual += $qty*$hrgjualidr;
                        $tbonus += $bonus;
                        $tdisc += $qty*$disc;
                        $tlaba += $laba;

                        $gtqty += $qty;
                        $gthrgbeli += $qty*$hrgbeliidr;
                        $gthrgjual += $qty*$hrgjualidr;
                        $gtdisc += $qty*$disc;
                        $gtbonus += $bonus;
                        $gtlaba += $laba;


                ?>
                    <tr class="<?php echo $background;?>">
                        <td><?php echo $nmr; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?php echo $no;?></td>
                        <td><?php echo Helper::dateFromMySqlSystem($data['tgl']);?></td>
                        <td><?php echo $data['nota'];?></td>
                        <td><?php echo $data['iditems'];?></td>
                        <td><?php echo $data['branch_name'];?></td>
                        <td><?php echo $data['nmsales'];?></td>
                        <td class="text-center"><?php echo $data['cur'];?></td>
                        <td class="text-right"><?php echo Helper::number($qty);?></td>
                        <td class="text-right"><?php echo Helper::currency($qty*$hrgbeliidr);?></td>
                        <td class="text-right"><?php echo Helper::currency($qty*$hrgbeliusd);?></td>
                        <td class="text-right"><?php echo Helper::currency($qty*$hrgjualidr);?></td>
                        <td class="text-right"><?php echo Helper::currency($qty*$hrgjualusd);?></td>
                        <td class="text-right"><?php echo Helper::currency($qty*$disc);?></td>
                        <td><?php echo $data['bayar'];?></td>
                    </tr>
                <?php 
/*                        $qty = (int)$data['qty'];
                        $hrgbeliidr = (float)$data['hrgbeliidr'];
                        $hrgjualidr = (float)$data['hrgjualidr'];
                        $disc = (float)$data['disc'];
                        
                        $tqty += $qty;
                        $thrgbeli += $qty * $hrgbeliidr;
                        $thrgjual += $qty * $hrgjualidr;
                        $tdisc += $qty * $disc;
                        $laba = $thrgjual - $thrgbeli - $tdisc;
                        $gtqty += $qty;
                        $gthrgbeli += $qty * $hrgbeliidr;
                        $gthrgjual += $qty * $hrgjualidr;
                        $gtdisc += $qty * $disc;
                        $gtlaba += $qty * ($hrgjualidr - $hrgbeliidr - $disc);*/
                        flush();
                    }
                ?>
                    </tbody>
                    <tfoot class="footer">
                    <tr>
                        <td colspan="8" align="right">Total &nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td class="text-right"><?php echo Helper::number($tqty);?></td>
                        <td class="text-right"><?php echo Helper::currency($thrgbeli);?></td>
                        <td></td>
                        <td class="text-right"><?php echo Helper::currency($thrgjual);?></td>
                        <td></td>
                        <td class="text-right"><?php echo Helper::currency($tdisc);?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="9" class="text-right">Laba &nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td colspan="6" class="no-margin"><?php echo Helper::currency($tlaba);?></td>
                    </tr>
                    </tfoot>
                </table>
                    </div></td>
            </tr>
            <?php flush();} ?>
        </tbody>
    </table>
<?php   } else if($group=="tanggal"){ ?>
    <table class="table table-condensed table-striped table-bordered table-hover no-margin">
        <thead>
            <tr>
                <th colspan="15" style="text-align: center; font-weight: bold">
                    <div><h3>Laporan Penjualan Berdasarkan Tanggal</h3></div>
                    <div><h4>Cabang : <?php echo $nmcabang;?></h4></div>
                    <div><h4>Tanggal : <?php echo Helper::dateFromMySqlSystem($objPenjualan->_startDate);?> s/d <?php echo Helper::dateFromMySqlSystem($objPenjualan->_endDate);?></h4></div>
                </th>
            </tr>
            <?php
/*                $nmr=0;
                $gtqty = 0;
                $gthrgbeli = 0;
                $gthrgjual = 0;
                $gtdisc = 0;
                $gtlaba = 0;*/

                foreach ($listPenjualan as $key=> $list){
            ?>
            <tr><td colspan="15" height="50"><b>Tanggal :&nbsp;<?php echo Helper::dateFromMySqlSystem($key); ?></b></td></tr>
        </thead>
        <tbody>

            <tr><td><div class="table-responsive">
                <table style="font-size: 12" class="table table-condensed table-bordered table-hover no-margin">
                    <thead  class="header">
                    <tr>
                        <th >&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th >No.</th>
                        <th >Invoice #</th>
                        <th >Part</th>
                        <th >Serial Number</th>
                        <th >Nama Barang</th>
                        <th >Branch</th>
                        <th >Nama Sales</th>
                        <th >Curr</th>
                        <th >Qty</th>
                        <th >Hrg Beli (IDR)</th>
                        <th >Hrg Beli (USD)</th>
                        <th >Hrg Jual (IDR)</th>
                        <th >Hrg Jual (USD)</th>
                        <th >Bonus</th>
                        <th >Disc</th>
                        <th >Bayar</th>
                    </tr>
                    </thead>
                    <tbody>
                <?php             
                    $no=0;
                    $tqty = 0;
                    $thrgbeli = 0;
                    $thrgjual = 0;
                    $tbonus = 0;
                    $tdisc = 0;
                    $tlaba = 0;
                    $background = 'genap';

                    foreach ($list as $data){
                        $no++;
                        $nmr++;
                        if($nota!=$data['nota']){
                            $trans++;
                            $nota = $data['nota'];
                            $background = $background=='genap'?'ganjil':'genap';
                        }

                        $qty = (int)$data['qty'];
                        $hrgjualidr = (float)$data['hrgjualidr'];
                        $hrgjualusd = (float)$data['hrgjualusd'];
                        $hrgbeliidr = $hrgjualidr==0?0:(float)$data['hrgbeliidr'];
                        $hrgbeliusd = $hrgjualusd==0?0:(float)$data['hrgbeliusd'];
                        $bonus = (float)$data['bonus'];
                        $disc = (float)$data['disc'];
                        $laba = $qty * ($hrgjualidr - $hrgbeliidr - $disc) - $bonus;

                        $tqty += $qty;
                        $thrgbeli += $qty*$hrgbeliidr;
                        $thrgjual += $qty*$hrgjualidr;
                        $tbonus += $bonus;
                        $tdisc += $qty*$disc;
                        $tlaba += $laba;

                        $gtqty += $qty;
                        $gthrgbeli += $qty*$hrgbeliidr;
                        $gthrgjual += $qty*$hrgjualidr;
                        $gtdisc += $qty*$disc;
                        $gtbonus += $bonus;
                        $gtlaba += $laba;
                ?>
                    <tr class="<?php echo $background; ?>" >
                        <td><?php echo $nmr; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?php echo $no;?></td>
                        <td><?php echo $data['nota'];?></td>
                        <td><?php echo $data['part'];?></td>
                        <td><?php echo $data['iditems'];?></td>
                        <td><?php echo $data['nmbarang'];?></td>
                        <td><?php echo $data['branch_name'];?></td>
                        <td><?php echo $data['nmsales'];?></td>
                        <td class="text-center"><?php echo $data['cur'];?></td>
                        <td class="text-right"><?php echo Helper::number($qty);?></td>
                        <td class="text-right"><?php echo Helper::currency($qty*$hrgbeliidr);?></td>
                        <td class="text-right"><?php echo Helper::currency($qty*$hrgbeliusd);?></td>
                        <td class="text-right"><?php echo Helper::currency($qty*$hrgjualidr);?></td>
                        <td class="text-right"><?php echo Helper::currency($qty*$hrgjualusd);?></td>
                        <td class="text-right"><?php echo Helper::currency($bonus);?></td>
                        <td class="text-right"><?php echo Helper::currency($qty*$disc);?></td>
                        <td><?php echo $data['bayar'];?></td>
                    </tr>
                <?php  } ?>
                    </tbody>
                    <tfoot  class="footer">
                    <tr>
                        <th colspan="9" align="right">Total &nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th class="text-right"><?php echo Helper::number($tqty);?></th>
                        <th class="text-right"><?php echo Helper::currency($thrgbeli);?></th>
                        <th></th>
                        <th class="text-right"><?php echo Helper::currency($thrgjual);?></th>
                        <th></th>
                        <th class="text-right"><?php echo Helper::currency($tbonus);?></th>
                        <th class="text-right"><?php echo Helper::currency($tdisc);?></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="9" class="text-right">Laba &nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th colspan="8" class="no-margin"><?php echo Helper::currency($tlaba);?></th>
                    </tr>
                    </tfoot>
                </table>
                    </div></td>
            </tr>
            <?php flush();} ?>
        </tbody>
    </table>   
<?php   } else if($group=="sales"){ ?>
    <table class="table table-condensed table-striped table-bordered table-hover no-margin">
        <tbody>
            <tr>
                <th style="text-align: center; font-weight: bold">
                    <div><h3>Laporan Penjualan Berdasarkan Sales</h3></div>
                    <div><h4>Tanggal : <?php echo Helper::dateFromMySqlSystem($objPenjualan->_startDate);?> s/d <?php echo Helper::dateFromMySqlSystem($objPenjualan->_endDate);?></h4></div>
                </th>
            </tr>
            <?php
                foreach ($listPenjualan as $key=> $list){
            ?>
            <tr><td height="50"><b>Sales :&nbsp;<?php echo $key; ?></b></td></tr>
            <tr><td><div class="table-responsive">
                <table style="font-size: 12" class="table table-condensed table-striped table-bordered table-hover no-margin">
                    <tr>
                        <th style="width: 20">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th style="width: 20">No.</th>
                        <th style="width: 60">Invoice #</th>
                        <th >Nama Brg</th>
                        <th >Serial Number</th>
                        <th style="width: 10">Qty</th>
                        <th style="width: 60">Tgl.Jual</th>
                        <th style="width: 60">Sub Total Hrg Beli MD<br/>(IDR)</th>
                        <th style="width: 60">Aktivasi</th>
                        <th style="width: 60">Bonus</th>
                        <th style="width: 60">Sub Total Hrg Jual<br/>(IDR)</th>
                        <th style="width: 60">Sub Total Laba<br/>(IDR)</th>
                        <?php if(strip_tags(isset($_POST['export']))){ ?><th>Komisi</th><?php } ?>
                    </tr>
                <?php             
                    $no=0;
                    $tqty = 0;
                    $thrgbeli = 0;
                    $thrgjual = 0;
                    $tbonus = 0;
                    $tlaba = 0;
                    $laba = 0;

                    foreach ($list as $data){
                        $no++;
                        $nmr++;
                        $hrglaba = $data['hrgjualidr']==0?0:($data['qty']*($data['hrgjualidr']-$data['hrgbeliidr'])-$data['bonus']);
                        $alertstyle=($data['qty']*($data['hrgjualidr']-$data['hrgbeliidr'])-$data['bonus'])<0?"style=\"background:pink;font-weight:bold\"":"";
                ?>
                    <tr name="<?php echo $nmr.'_'.$no;?>" <?php echo $alertstyle;?>>
                        <td><?php echo $nmr;?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?php echo $no;?></td>
                        <td><a href="#<?php echo $nmr.'_'.$no;?>" onclick="window.open('?page=penjualan-detail&detailinvoice=<?php echo $data['nota'];?>','invoice','toolbar=no,location=no,height=600,width=800')"><?php echo $data['nota'];?></a></td>
                        <td><?php echo $data['nmbarang'];?></td>
                        <td><?php echo $data['iditems'];?></td>
                        <td class="text-right"><?php echo Helper::number($data['qty']);?></td>
                        <td class="text-right"><?php echo Helper::dateFromMySqlSystem($data['tgl']);?></td>
                        <td class="text-right"><?php echo Helper::currency($data['qty']*$data['hrgbeliidr']);?></td>
                        <td class="text-right"><?php echo Helper::currency($data['aktivasi']);?></td>
                        <td class="text-right"><?php echo Helper::currency($data['bonus']);?></td>
                        <td class="text-right"><?php echo Helper::currency($data['qty']*$data['hrgjualidr']);?></td>
                        <td class="text-right"><?php echo Helper::currency($hrglaba);?></td>
                        <?php if(strip_tags(isset($_POST['export']))){ ?><td>&nbsp;</td><?php } ?>
                    </tr>
                <?php
                        $qty = (int)$data['qty'];
                        $hrgbeliidr = (float)$data['hrgbeliidr'];
                        $hrgjualidr = (float)$data['hrgjualidr'];
                        $bonus = (float)$data['bonus'];

                        $tqty += $qty;
                        $thrgbeli += $qty * $hrgbeliidr;
                        $thrgjual += $qty * $hrgjualidr;
                        $tbonus += $bonus;
                        $tlaba += $qty*($hrgjualidr - $hrgbeliidr)- $bonus;
                        $gtqty += $qty;
                        $gthrgbeli += $qty * $hrgbeliidr;
                        $gthrgjual += $qty * $hrgjualidr;
                        $gtbonus += $bonus;
                        $gtlaba += $qty * ($hrgjualidr - $hrgbeliidr) - $bonus;
                        flush();
                    }
                ?>
                    <tr style="font-weight: bold">
                        <td colspan="5" align="right">Total &nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td class="text-right"><?php echo Helper::number($tqty);?></td>
                        <td >&nbsp;</td>
                        <td class="text-right"><?php echo Helper::currency($thrgbeli);?></td>
                        <td >&nbsp;</td>
                        <td class="text-right"><?php echo Helper::currency($tbonus);?></td>
                        <td class="text-right"><?php echo Helper::currency($thrgjual);?></td>
                        <td class="text-right"><?php echo Helper::currency($tlaba);?></td>
                        <?php if(strip_tags(isset($_POST['export']))){ ?><td>&nbsp;</td><?php }?>
                    </tr>
                </table>
                    </div></td>
            </tr>
            <?php flush();} ?>
        </tbody>
    </table>   
    
<?php }?>    
</div>
<?php } else { ?>
<div id="datalist" align="center" class="">
    <div>&nbsp;</div>
    <div class="alert alert-danger alert-dismissable" >
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <center><strong>Data Tidak ditemukan</strong></center>
    </div>
</div>
<?php } ?>

<?php } ?>

<?php 
    if($group=='part'){
?>
<script type="text/javascript">
$('#summary-lg').append('<table style="font-size: 12" class="table table-condensed table-striped table-bordered table-hover no-margin">'+
        '<tr><td width="20%">Total Qty </td><td><?php echo Helper::number($gtqty); ?></td></tr>'+        
        '<tr><td>Total Hrg.Beli </td> <td><?php echo Helper::currency($gthrgbeli); ?></td></tr>'+
        '<tr><td>Total Hrg.Jual </td> <td><?php echo Helper::currency($gthrgjual); ?></td></tr>'+
        '<tr><td>Total Discount </td> <td><?php echo Helper::currency($gtdisc); ?></td></tr>'+
        '<tr><td>Total Bonus </td> <td><?php echo Helper::currency($gtbonus); ?></td></tr>'+
        '<tr><td>Total Laba/Rugi </td> <td><?php echo Helper::currency($gtlaba);?></td></tr>'+
        '</table>');
$('#summary-sm').append('<table style="font-size: 12" class="table table-condensed table-striped table-bordered table-hover no-margin">'+
        '<tr><td width="20%">Total Qty </td><td><?php echo Helper::number($gtqty); ?></td></tr>'+        
        '<tr><td>Total Hrg.Beli </td> <td><?php echo Helper::currency($gthrgbeli); ?></td></tr>'+
        '<tr><td>Total Hrg.Jual </td> <td><?php echo Helper::currency($gthrgjual); ?></td></tr>'+
        '<tr><td>Total Discount </td> <td><?php echo Helper::currency($gtdisc); ?></td></tr>'+
        '<tr><td>Total Bonus </td> <td><?php echo Helper::currency($gtbonus); ?></td></tr>'+
        '<tr><td>Total Laba/Rugi </td> <td><?php echo Helper::currency($gtlaba);?></td></tr>'+
        '</table>');
</script>
<?php 
    }else{
?>
<script type="text/javascript">
$('#summary-lg').append('<table style="font-size: 12" class="table table-condensed table-striped table-bordered table-hover no-margin">'+
        '<tr><td width="20%">Jumlah Transaksi </td><td><?php echo Helper::number($trans); ?></td></tr>'+
        '<tr><td width="20%">Total Qty </td><td><?php echo Helper::number($gtqty); ?></td></tr>'+        
        '<tr><td>Total Hrg.Beli </td> <td><?php echo Helper::currency($gthrgbeli); ?></td></tr>'+
        '<tr><td>Total Hrg.Jual </td> <td><?php echo Helper::currency($gthrgjual); ?></td></tr>'+
        '<tr><td>Total Discount </td> <td><?php echo Helper::currency($gtdisc); ?></td></tr>'+
        '<tr><td>Total Bonus </td> <td><?php echo Helper::currency($gtbonus); ?></td></tr>'+
        '<tr><td>Total Laba/Rugi </td> <td><?php echo Helper::currency($gtlaba);?></td></tr>'+
        '</table>');
$('#summary-sm').append('<table style="font-size: 12" class="table table-condensed table-striped table-bordered table-hover no-margin">'+
        '<tr><td width="20%">Jumlah Transaksi </td><td><?php echo Helper::number($trans); ?></td></tr>'+
        '<tr><td width="20%">Total Qty </td><td><?php echo Helper::number($gtqty); ?></td></tr>'+        
        '<tr><td>Total Hrg.Beli </td> <td><?php echo Helper::currency($gthrgbeli); ?></td></tr>'+
        '<tr><td>Total Hrg.Jual </td> <td><?php echo Helper::currency($gthrgjual); ?></td></tr>'+
        '<tr><td>Total Discount </td> <td><?php echo Helper::currency($gtdisc); ?></td></tr>'+
        '<tr><td>Total Bonus </td> <td><?php echo Helper::currency($gtbonus); ?></td></tr>'+
        '<tr><td>Total Laba/Rugi </td> <td><?php echo Helper::currency($gtlaba);?></td></tr>'+
        '</table>');
</script>
<?php } ?>
<?php require_once("_footer.php"); ?>
