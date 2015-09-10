<?php require_once("_header.php"); ?>
<div class="col-lg-12">
<?php if (!empty($listCashFlow)){?>
<table class="table table-condensed table-striped table-bordered table-hover no-margin" style="width:100%;font-size: 12;">
    <tr>
        <th colspan="9" style="text-align: center; font-weight: bold;">
            <div><h3>Laporan Cash Flow</h3></div>
            <div><h4>Rekening : <?php echo $nmcabang;?></h4></div>
            <div><h4>Tanggal : <?php echo Helper::dateFromMySqlSystem($objCashFlow->_startDate);?> s/d <?php echo Helper::dateFromMySqlSystem($objCashFlow->_endDate);?></h4></div>
        </th>
    </tr>
    <tr>
        <th>#</th>
        <th>Tgl</th>
        <th>#Rekening</th>
        <th>Bank</th>
        <th>Atas Nama</th>
        <th>Mata Uang</th>
        <th style="width: 300">Keterangan</th>
        <th>Debet</th>
        <th>Kredit</th>
    </tr>
    <?php
    $i=0; 
    foreach($listCashFlow AS $data){
        $i++;
    ?>
    <tr>
        <td><?php echo $i;?></td>
        <td><?php echo Helper::dateFromMySqlSystem($data['tgl']);?></td>
        <td><?php echo $data['rek'];?></td>
        <td><?php echo $data['bank'];?></td>
        <td><?php echo $data['an'];?></td>
        <td><?php echo $data['matauang'];?></td>
        <td><?php echo $data['ket'];?></td>
        <td style="text-align: right"><?php echo Helper::currency($data['debet']);?></td>
        <td style="text-align: right"><?php echo Helper::currency($data['kredit']);?></td>
    </tr>
    <?php } ?>
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
