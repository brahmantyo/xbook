<?php require_once("_header.php"); ?>
<div class="col-lg-12">
<?php if (!empty($listBiayaOperasional)){?>
<table class="table table-condensed table-striped table-bordered table-hover no-margin" style="width:100%;font-size: 12;">
    <tr>
        <th colspan="10" style="text-align: center; font-weight: bold;">
            <div><h3>Laporan Biaya Operasional</h3></div>
            <div><h4>Cabang : <?php echo $nmcabang;?></h4></div>
            <div><h4>Tanggal : <?php echo Helper::dateFromMySqlSystem($objBiayaOperasional->_startDate);?> s/d <?php echo Helper::dateFromMySqlSystem($objBiayaOperasional->_endDate);?></h4></div>
        </th>
    </tr>
    <tr>
        <th>#</th>
        <th>Tgl</th>
        <th>Cabang</th>
        <th>Keterangan</th>
        <th width="50">Nilai Pengeluaran</th>
    </tr>
    <?php
    $i=0;$total=0;
    foreach($listBiayaOperasional AS $data){
        $i++;
    ?>
    <tr>
        <td><?php echo $i;?></td>
        <td><?php echo Helper::dateFromMySqlSystem($data['tgl']);?></td>
        <td><?php echo $data['branch_name'];?></td>
        <td><?php echo $data['ket'];?></td>
        <td style="text-align: right"><?php echo Helper::currency($data['value']);?></td>
    </tr>
    <?php $total += $data['value'];} ?>
    <tr>
        <th colspan="4">Total</th>
        <th style="text-align: right"><?php echo Helper::currency($total);?></th>
    </tr>
</table>
<div>&nbsp;</div>
<?php } else { ?>
<div id="datalist" align="center" class="col-lg-10">
    <div>&nbsp;</div>
    <div class="alert alert-danger alert-dismissable" >
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <center><strong>Data Tidak ditemukan</strong></center>
    </div>
</div>
<?php }?>
</div>
<?php require_once("_footer.php"); ?>
