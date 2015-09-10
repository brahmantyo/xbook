<?php require_once("_header.php"); ?>
<?php
 if($objForm->isPost('dafcabang')){
?>
<table class="well col-lg-12 table table-condensed table-striped table-bordered table-hover no-margin">
    <tr>
        <th colspan="9" style="text-align: center; font-weight: bold;">
            <div><h3>Laporan Laba Rugi</h3></div>
            <div><h4>Rekening : <?php echo $nmcabang;?></h4></div>
            <div><h4>Tanggal : <?php echo Helper::dateFromMySqlSystem($labarugi->_startDate);?> s/d <?php echo Helper::dateFromMySqlSystem($labarugi->_endDate);?></h4></div>
        </th>
    </tr>
    <tr>
        <th width="50%">Pengeluaran</th>
        <th width="50%">Pemasukan</th>
    </tr>
    <tr valign="top">
        <td>
            <table class="col-lg-11 table table-condensed table-striped table-bordered table-hover no-margin">
                <tr><td>Harga Pokok Pembelian</td><td style="text-align: right"><?php echo Helper::currency($data['hpp'],0,"id");?></td></tr>
                <tr><td>Aktivasi</td><td style="text-align: right"><?php echo Helper::currency($data['aktivasi'],0,"id");?></td></tr>    
                <tr><td>Bonus Penjualan</td><td style="text-align: right"><?php echo Helper::currency($data['bonus'],0,"id");?></td></tr>
                <tr><td>Biaya Operasional</td><td style="text-align: right"><?php echo Helper::currency($data['biaya'],0,"id");?></td></tr>
                <tr><td>Gaji Pegawai</td><td style="text-align: right"><?php echo Helper::currency($data['gaji'],0,"id");?></td></tr>
                <tr class="bg-danger"><td>Total Pengeluaran</td><td style="text-align: right"><?php echo Helper::currency($data['totkeluar'],0,"id");?></td></tr>
            </table>            
        </td>
        <td>
            <table class="col-lg-11 table table-condensed table-striped table-bordered table-hover no-margin">
                <tr><td>Nilai Penjualan</td><td style="text-align: right"><?php echo Helper::currency($data['jual'],0,"id");?></td></tr>
                <tr><td>Pendapatan Lain</td><td style="text-align: right"><?php echo Helper::currency($data['incomelain'],0,"id");?></td></tr>
                <tr><td>Pendapatan Service</td><td style="text-align: right"><?php echo Helper::currency($data['service'],0,"id");?></td></tr>
                <tr class="bg-danger"><td>Total Pemasukan</td><td style="text-align: right"><?php echo Helper::currency($data['totmasuk'],0,"id");?></td></tr>
            </table>            
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="table table-condensed table-bordered no-margin">
                <tr><td>Laba/Rugi</td><td style="text-align: right"><?php echo Helper::currency($data['rl'],0,"id");?></td></tr>
            </table>
        </td>
    </tr>
</table>
<?php } ?>
<?php require_once("_footer.php"); ?>