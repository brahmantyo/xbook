<?php 
    Login::restrictAdmin();

    $objCabang = new Cabang();
    $cabang = $objCabang->getData();
    $objBank = new Bank();
    $listBank = $objBank->getData();

    $objForm = new Form();
    $objValidation = new Validation($objForm);

    //Penjualan
    $objPenjualan = new Penjualan();
    $tglPenjualan =  $objPenjualan->getTanggalPenjualan();

    //Pembelian
    $objPembelian = new Pembelian();
    $tglPembelian = $objPembelian->getTanggalPembelian();

    //Laba Rugi
    $labarugi = new LabaRugi();
        
    //Cash Flow
    $objCashFlow = new CashFlow();
    $objCashFlow->getTanggal();

    //Biaya Operasional
    $objBiayaOperasional = new BiayaOperasional();
    $objBiayaOperasional->getTanggal();

    if(isset($_GET['detailinvoice'])){
        $noinvoice = $_GET['detailinvoice'];
        $invoice = $objPenjualan->getPenjualanInvoice($noinvoice);
    }

    if($objForm->isPost('dafcabang')){
        $admin = new Admin();
        //if($objForm->getPost("dafcabang")!='cashflow'){
        //    $nmcabang = $objCabang->getNama($objForm->getPost("dafcabang"))?$objCabang->getNama($objForm->getPost("dafcabang")):"Semua Cabang";
        //}
        switch($objForm->getPost('form')){
            case 'penjualan' :
                //Penjualan
                //$tglAwal = Helper::dateToMySqlSystem($objForm->getPost('tglawaljual'));
                //$tglAkhir = Helper::dateToMySqlSystem($objForm->getPost('tglakhirjual')); 
                $group = $objForm->getPost("group_by");
                $dir=$objForm->getPost("direction");
                $direction = isset($_POST['direction'])?$dir:"DESC";
                $objPenjualan->_cabang = $objForm->getPost('dafcabang');
                $objPenjualan->_startDate = Helper::dateToMySqlSystem($objForm->getPost("tglawaljual"));
                $objPenjualan->_endDate = Helper::dateToMySqlSystem($objForm->getPost("tglakhirjual"));
                $listPenjualan = $objPenjualan->getDataByGroup($group,$direction);
                $nmcabang = $objCabang->getNama($objForm->getPost("dafcabang"));
                break;
            case 'pembelian' :
                //Pembelian
                $group = $objForm->getPost("group_by");
                $dir=$objForm->getPost("direction");
                $direction = isset($_POST['direction'])?$dir:"DESC";
                $objPembelian->_cabang = $objForm->getPost('dafcabang');
                $objPembelian->_startDate = Helper::dateToMySqlSystem($objForm->getPost("tglawalbeli"));
                $objPembelian->_endDate = Helper::dateToMySqlSystem($objForm->getPost("tglakhirbeli"));            
                $listPembelian = $objPembelian->getDataByGroup($group,$direction);
                $nmcabang = $objCabang->getNama($objForm->getPost("dafcabang"));
                break;
            case 'labarugi' :
                $tglAwal = Helper::dateToMySqlSystem($objForm->getPost('tglawaljual'));
                $tglAkhir = Helper::dateToMySqlSystem($objForm->getPost('tglakhirjual'));
                $data = $labarugi->getData($tglAwal,$tglAkhir,$objForm->getPost('dafcabang'));
                $nmcabang = $objCabang->getNama($objForm->getPost("dafcabang"));
                break;
            case 'cashflow' :
                $bank=$objForm->getPost('bank');
                $objCashFlow->_startDate = Helper::dateToMySqlSystem($objForm->getPost('tglawalcashflow'));
                $objCashFlow->_endDate = Helper::dateToMySqlSystem($objForm->getPost('tglakhircashflow'));
                $objCashFlow->_cabang = $objForm->getPost('dafcabang');
                if(!empty($bank)){
                    $listCashFlow = $objCashFlow->getCashFlowByBank($bank);
                } else { 
                    $listCashFlow = $objCashFlow->getCashFlow();
                }
                $nmcabang = $objBank->getNama($objForm->getPost("bank"));
                break;
            case 'biayaoperasional' :
                $objBiayaOperasional->_startDate = Helper::dateToMySqlSystem($objForm->getPost('tglawalcashflow'));
                $objBiayaOperasional->_endDate = Helper::dateToMySqlSystem($objForm->getPost('tglakhircashflow'));
                $objBiayaOperasional->_cabang = $objForm->getPost('dafcabang');
                $listBiayaOperasional = $objBiayaOperasional->getBiayaOperasional();
                $nmcabang = $objCabang->getNama($objForm->getPost("dafcabang"))?:'Semua Cabang';
                break;
        }
        $money = new Money();
    }

    if(strip_tags(isset($_POST['export']))){
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=".$objForm->getPost('form').".xls");
    }
?>
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
        <script src="../js/highcharts.js"></script>
        <script src="../js/exporting.js"></script>


        <script src="js/Menu.js" type="text/javascript" ></script>
        <script src="" type="text/css" ></script>

    </head>
    <body>
        <?php if(strip_tags(!isset($_POST['export']))){ ?>
 
        <div id="header" class="col-xs-12 col-sm-12 col-lg-12">
            <div id="header_in" class="text-uppercase">
                <h5><a href="#">XBook Control Panel</a></h5>
            </div>
            <div class="pull-right">
                User : <?php echo strtoupper($_SESSION['first_name']." ".$_SESSION['last_name']);?>
            </div>
        </div>
        <div id="blank" class="col-sm-12">&nbsp;</div>
        <div id="info"></div>
        <div id="container" class="col-sm-12">
            <!--<div class=""><input type="button" value="Menu" data-bind="#menu"/></div>-->
            <div  class="well col-sm-12 col-md-3 col-lg-3">
                <!-- Panel Penjualan -->
                <div class="panel-group col-sm-12 col-lg-12" id="accordion">
                    <div class="panel">
                        <div class="panel-heading panel-heading-custom" style="cursor: pointer">
                            <div class="panel-title text-center" data-toggle="collapse" data-parent="#accordion" data-target="#Penjualan">Penjualan
                                <!--<div class="form-group">
                                    <form action="./?page=penjualan" method="post" name="penjualan">
                                        <input id="searchPenjualan" type="text" class="form-control col-md-12"/>
                                    </form>
                                </div>-->
                            </div>
                        </div>
                        <div id="Penjualan" class="panel-collapse collapse out">
                            <div class="panel-body">
                            <form action="./?page=penjualan" method="post" id="penjualan">
                            <input type="hidden" name="form" value="penjualan" />
                            <div class="form-group">
                                <label for="cabang">Pilih Cabang</label>
                                <select id="dafcabang" name="dafcabang" class="form-control">
                                    <option value="0" <?php echo $objForm->getPost("dafcabang")==0?"selected":"";?>>-- Semua Cabang --</option>
                                    <?php foreach ($cabang as $cab) { ?>
                                    <option value="<?php echo $cab['branch_id'];?>" <?php echo $cab['branch_id']==$objForm->getPost("dafcabang")?"selected":"";?> ><?php echo $cab['branch_name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="alert alert-danger alert-dismissable" id="alertPenjualan">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>&nbsp;</strong>
                            </div>
                            <div class="form-group">
                                <label for="tglawaljual">Tanggal Awal</label>
                                <input id="tglawaljual" name="tglawaljual" type="text" class="form-control datepicker" value="<?php echo Helper::dateFromMySqlSystem($tglPenjualan['awal']);?>" />
                            </div>
                            <div class="form-group">
                                <label for="tglakhirjual">Tanggal Akhir</label>
                                <input id="tglakhirjual" name="tglakhirjual" type="text" class="form-control datepicker" value="<?php echo Helper::dateFromMySqlSystem($tglPenjualan['akhir']);?>"/>
                            </div>
                            <div class="radio bg-danger">
                                <label><input type="radio" name="group_by" value="tanggal" checked/>Berdasarkan Tanggal</label>
                                <label><input type="radio" name="group_by" value="part" />Berdasarkan Part</label>
                                <label><input type="radio" name="group_by" value="sales" />Berdasarkan Sales</label>
                            </div>
                            <div class="checkbox bg-danger">
                                <label>
                                    <input type="checkbox" name="direction" value="asc" />Urutkan Dari Transaksi Awal
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="export" value="">Export to Excel
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                            </form>                
                            </div>
                        </div>
                    </div>

                    <!-- Panel Pembelian -->
                    <div class="panel">
                        <div class="panel-heading panel-heading-custom" style="cursor: pointer">
                            <div class="panel-title  text-center" data-toggle="collapse" data-parent="#accordion" data-target="#Pembelian">Pembelian</div>
                        </div>
                        <div id="Pembelian" class="panel-collapse collapse out">
                            <div class="panel-body">
                            <form action="./?page=pembelian" method="post" id="penjualan">
                            <input type="hidden" name="form" value="pembelian" />
                            <div class="form-group">
                                <label for="cabang">Pilih Cabang</label>
                                <select id="dafcabang" name="dafcabang" class="form-control">
                                    <option value="0" <?php echo $objForm->getPost("dafcabang")==0?"selected":"";?>>-- Semua Cabang --</option>
                                    <?php foreach ($cabang as $cab) { ?>
                                    <option value="<?php echo $cab['branch_id'];?>" <?php echo $cab['branch_id']==$objForm->getPost("dafcabang")?"selected":"";?> ><?php echo $cab['branch_name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="alert alert-danger alert-dismissable" id="alertPembelian">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>&nbsp;</strong>
                            </div>
                            <div class="form-group">
                                <label for="tglawalbeli">Tanggal Awal</label>
                                <input id="tglawalbeli" name="tglawalbeli" type="text" class="form-control datepicker" value="<?php echo Helper::dateFromMySqlSystem($tglPembelian['awal']);?>" />
                            </div>
                            <div class="form-group">
                                <label for="tglakhirbeli">Tanggal Akhir</label>
                                <input id="tglakhirbeli" name="tglakhirbeli" type="text" class="form-control datepicker" value="<?php echo Helper::dateFromMySqlSystem($tglPembelian['akhir']);?>" />
                            </div>
                            <div class="radio bg-danger">
                                <label>
                                    <input type="radio" name="group_by" value="tanggal" checked/>Berdasarkan Tanggal
                                </label>
                                <label><input type="radio" name="group_by" value="part" />Berdasarkan Part</label>
                            </div>
                            <div class="checkbox bg-danger">
                                <label>
                                    <input type="checkbox" name="direction" value="asc" />Urutkan Dari Transaksi Awal
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="export" value="">Export to Excel
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                            </form>                
                            </div>
                        </div>
                    </div>

                    <!-- Panel Cash Flow -->
                    <div class="panel text-center">
                        <div class="panel-heading panel-heading-custom" style="cursor: pointer">
                            <div class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#CashFlow">Cash Flow</div>
                        </div>
                        <div id="CashFlow" class="panel-collapse collapse">
                            <div class="panel-body">
                            <form action="./?page=cashflow" method="post" id="cashflow">
                            <input type="hidden" name="dafcabang" value="cashflow" />
                            <input type="hidden" name="form" value="cashflow" />
                            <!-- <div class="form-group">
                                <label for="cabang">Pilih Lokasi</label>
                                <select id="dafcabang" name="dafcabang" class="form-control">
                                    <option value="10000" <?php echo $objForm->getPost("dafcabang")==0?"selected":"";?>>-- Tampilkan Semua --</option>
                                    <?php foreach ($cabang as $cab) { ?>
                                    <option value="<?php echo $cab['branch_id'];?>" <?php echo $cab['branch_id']==$objForm->getPost("dafcabang")?"selected":"";?> ><?php echo $cab['branch_name'];?></option>
                                    <?php } ?>
                                </select>
                            </div> -->
                            <div class="form-group">
                                <label for="bank">Pilih Rekening</label>
                                <select id="bank" name="bank" class="form-control">
                                    <option value="0" <?php echo $objForm->getPost("bank")==0?"selected":"";?>>-- Semua Rekening --</option>
                                    <?php foreach ($listBank as $bank) { ?>
                                    <option value="<?php echo $bank['norek'];?>" <?php echo $bank['norek']==$objForm->getPost("bank")?"selected":"";?> ><?php echo $bank['bank'];?>-<?php echo $bank['an'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="alert alert-danger alert-dismissable" id="alertCashFlow">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>&nbsp;</strong>
                            </div>
                            <div class="form-group">
                                <label for="tglawalcashflow">Tanggal Awal</label>
                                <input id="tglawalcashflow" name="tglawalcashflow" type="text" class="form-control datepicker" value="<?php echo Helper::dateFromMySqlSystem($objCashFlow->_startDate); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="tglakhircashflow">Tanggal Akhir</label>
                                <input id="tglakhircashflow" name="tglakhircashflow" type="text" class="form-control datepicker" value="<?php echo Helper::dateFromMySqlSystem($objCashFlow->_endDate); ?>" />
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="export" value="">Export to Excel
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                            </form>
                            </div>
                        </div>
                    </div>

                    <!-- Panel Biaya Operasional -->
                    <div class="panel text-center">
                        <div class="panel-heading panel-heading-custom" style="cursor: pointer">
                            <div class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#BiayaOperasional">Biaya Operasional</div>
                        </div>
                        <div id="BiayaOperasional" class="panel-collapse collapse">
                            <div class="panel-body">
                            <form action="./?page=biayaoperasional" method="post" id="biayaoperasional">
                            <input type="hidden" name="form" value="biayaoperasional" />
                            <div class="form-group">
                                <label for="cabang">Pilih Lokasi</label>
                                <select id="dafcabang" name="dafcabang" class="form-control">
                                    <option value="10000" <?php echo $objForm->getPost("dafcabang")==0?"selected":"";?>>-- Tampilkan Semua --</option>
                                    <?php foreach ($cabang as $cab) { ?>
                                    <option value="<?php echo $cab['branch_id'];?>" <?php echo $cab['branch_id']==$objForm->getPost("dafcabang")?"selected":"";?> ><?php echo $cab['branch_name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="alert alert-danger alert-dismissable" id="alertBiayaOperasional">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>&nbsp;</strong>
                            </div>
                            <div class="form-group">
                                <label for="tglawalbo">Tanggal Awal</label>
                                <input id="tglawalbo" name="tglawalcashflow" type="text" class="form-control datepicker" value="<?php echo Helper::dateFromMySqlSystem($objBiayaOperasional->_startDate); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="tglakhirbo">Tanggal Akhir</label>
                                <input id="tglakhirbo" name="tglakhircashflow" type="text" class="form-control datepicker" value="<?php echo Helper::dateFromMySqlSystem($objBiayaOperasional->_endDate); ?>" />
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="export" value="">Export to Excel
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                            </form>
                            </div>
                        </div>
                    </div>

                    <!-- Panel Laba Rugi -->
                    <?php if(!($_SESSION['level']=='STAFF')){?>
                    <div class="panel">
                        <div class="panel-heading panel-heading-custom" style="cursor: pointer">
                            <div class="panel-title  text-center" data-toggle="collapse" data-parent="#accordion" data-target="#LabaRugi">Laba Rugi</div>
                        </div>
                        <div id="LabaRugi" class="panel-collapse collapse out">
                            <div class="panel-body">
                            <form action="./?page=labarugi" method="post" id="labarugi">
                            <input type="hidden" name="form" value="labarugi" />
                            <div class="form-group">
                                <label for="cabang">Pilih Cabang</label>
                                <select id="dafcabang" name="dafcabang" class="form-control">
                                    <option value="0" <?php echo $objForm->getPost("dafcabang")==0?"selected":"";?>>-- Semua Cabang --</option>
                                    <?php foreach ($cabang as $cab) { ?>
                                    <option value="<?php echo $cab['branch_id'];?>" <?php echo $cab['branch_id']==$objForm->getPost("dafcabang")?"selected":"";?> ><?php echo $cab['branch_name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="alert alert-danger alert-dismissable" id="alertLabaRugi">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>&nbsp;</strong>
                            </div>
                            <div class="form-group">
                                <label for="tglawalrl">Tanggal Awal</label>
                                <input id="tglawalrl" name="tglawaljual" type="text" class="form-control datepicker" value="<?php echo Helper::dateFromMySqlSystem($tglPenjualan['awal']);?>" />
                            </div>
                            <div class="form-group">
                                <label for="tglakhirrl">Tanggal Akhir</label>
                                <input id="tglakhirrl" name="tglakhirjual" type="text" class="form-control datepicker" value="<?php echo Helper::dateFromMySqlSystem($tglPenjualan['akhir']);?>" />
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="export" value="">Export to Excel
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                            </form>                
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <br />
                    <div class="col-xs-12 col-lg-12 btn btn-danger text-center" style="font-size: 14">
                        <div data-parent="#accordion" onclick="window.location='./?page=logout';" style="text-decoration: none; cursor: pointer">
                            LOGOUT
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
            <!--<div class="col-sm-8">space kosong</div>-->
            <div class="col-sm-12 col-md-9 col-lg-9">
<script type="text/javascript">
    // About date field
var startDate = new Date("1945-08-17");
var endDate = new Date();

$('#alertPenjualan').hide();
/*
$('#searchPenjualan').keypress(function(ev){
        if(!(ev.keyCode == 13 || ev.keyCode == 8 || ev.keyCode == 46)){
            $('#info').html($('#searchPenjualan').val()+ev.keyCode);
        }
    }
);
*/
$('#tglawaljual')
    .datepicker({ format: "dd-mm-yyyy" })
    .on('changeDate', function(ev){
        var tEnd = new Array();
        if($('#tglakhirjual').val()){
            tEnd = ($('#tglakhirjual').val()).split("-");
        }
        tglAkhir = new Date(tEnd[2]+"-"+tEnd[1]+"-"+tEnd[0]);
        if (ev.date.valueOf() > endDate.valueOf()){
            $('#alert').show().find('strong').text('Tanggal tidak boleh melebihi dari hari ini');
        } else if (ev.date.valueOf() > tglAkhir.valueOf()) {
            $('#alert').show().find('strong').text('Tanggal awal tidak boleh melebihi tanggal akhir');
        } else {
            $('#alert').hide();
            startDate = new Date(ev.date);
        }
        $('#tglawaljual').datepicker('hide');
     });
$('#tglakhirjual')
    .datepicker({ format: "dd-mm-yyyy" })
    .on('changeDate', function(ev){
        var tStart = new Array();
        if($('#tglawaljual').val()){
            tStart = ($('#tglawaljual').val()).split("-");
        }
        tglAwal = new Date(tStart[2]+"-"+tStart[1]+"-"+tStart[0]);
        if (ev.date.valueOf() < startDate.valueOf()){
            $('#alert').show().find('strong').text('The end date must be after the start date.');
        } else if(ev.date.valueOf() < tglAwal.valueOf()){
            $('#alert').show().find('strong').text('Tanggal akhir tidak sebelum tanggal awal');
        } else {
            $('#alert').hide();
            endDate = new Date(ev.date);
        }
        $('#tglakhirjual').datepicker('hide');
    });
    
//Pembelian
$('#alertPembelian').hide();

$('#tglawalbeli')
    .datepicker({ format: "dd-mm-yyyy" })
    .on('changeDate', function(ev){
        var tEnd = new Array();
        if($('#tglakhirbeli').val()){
            tEnd = ($('#tglakhirbeli').val()).split("-");
        }
        tglAkhir = new Date(tEnd[2]+"-"+tEnd[1]+"-"+tEnd[0]);
        if (ev.date.valueOf() > endDate.valueOf()){
            $('#alertPembelian').show().find('strong').text('Tanggal tidak boleh melebihi dari hari ini');
        } else if (ev.date.valueOf() > tglAkhir.valueOf()) {
            $('#alertPembelian').show().find('strong').text('Tanggal awal tidak boleh melebihi tanggal akhir');
        } else {
            $('#alertPembelian').hide();
            startDate = new Date(ev.date);
        }
        $('#tglawalbeli').datepicker('hide');
     });
$('#tglakhirbeli')
    .datepicker({ format: "dd-mm-yyyy" })
    .on('changeDate', function(ev){
        var tStart = new Array();
        if($('#tglawalbeli').val()){
            tStart = ($('#tglawalbeli').val()).split("-");
        }
        tglAwal = new Date(tStart[2]+"-"+tStart[1]+"-"+tStart[0]);
        if (ev.date.valueOf() < startDate.valueOf()){
            $('#alertPembelian').show().find('strong').text('The end date must be after the start date.');
        } else if(ev.date.valueOf() < tglAwal.valueOf()){
            $('#alertPembelian').show().find('strong').text('Tanggal akhir tidak sebelum tanggal awal');
        } else {
            $('#alertPembelian').hide();
            endDate = new Date(ev.date);
        }
        $('#tglakhirbeli').datepicker('hide');
    });

//Cash Flow
$('#alertCashFlow').hide();
$('#tglawalcashflow')
    .datepicker({ format: "dd-mm-yyyy" })
    .on('changeDate', function(ev){
        var tEnd = new Array();
        if($('#tglakhircashflow').val()){
            tEnd = ($('#tglakhircashflow').val()).split("-");
        }
        tglAkhir = new Date(tEnd[2]+"-"+tEnd[1]+"-"+tEnd[0]);
        if (ev.date.valueOf() > endDate.valueOf()){
            $('#alert').show().find('strong').text('Tanggal tidak boleh melebihi dari hari ini');
        } else if (ev.date.valueOf() > tglAkhir.valueOf()) {
            $('#alert').show().find('strong').text('Tanggal awal tidak boleh melebihi tanggal akhir');
        } else {
            $('#alert').hide();
            startDate = new Date(ev.date);
        }
        $('#tglawalcashflow').datepicker('hide');
     });
$('#tglakhircashflow')
    .datepicker({ format: "dd-mm-yyyy" })
    .on('changeDate', function(ev){
        var tStart = new Array();
        if($('#tglawalcashflow').val()){
            tStart = ($('#tglawalcashflow').val()).split("-");
        }
        tglAwal = new Date(tStart[2]+"-"+tStart[1]+"-"+tStart[0]);
        if (ev.date.valueOf() < startDate.valueOf()){
            $('#alert').show().find('strong').text('The end date must be after the start date.');
        } else if(ev.date.valueOf() < tglAwal.valueOf()){
            $('#alert').show().find('strong').text('Tanggal akhir tidak sebelum tanggal awal');
        } else {
            $('#alert').hide();
            endDate = new Date(ev.date);
        }
        $('#tglakhircashflow').datepicker('hide');
    });
    
//Laba Rugi
$('#alertLabaRugi').hide();
$('#tglawalrl')
    .datepicker({ format: "dd-mm-yyyy" })
    .on('changeDate', function(ev){
        var tEnd = new Array();
        if($('#tglakhirrl').val()){
            tEnd = ($('#tglakhirrl').val()).split("-");
        }
        tglAkhir = new Date(tEnd[2]+"-"+tEnd[1]+"-"+tEnd[0]);
        if (ev.date.valueOf() > endDate.valueOf()){
            $('#alert').show().find('strong').text('Tanggal tidak boleh melebihi dari hari ini');
        } else if (ev.date.valueOf() > tglAkhir.valueOf()) {
            $('#alert').show().find('strong').text('Tanggal awal tidak boleh melebihi tanggal akhir');
        } else {
            $('#alert').hide();
            startDate = new Date(ev.date);
        }
        $('#tglawalrl').datepicker('hide');
     });
$('#tglakhirrl')
    .datepicker({ format: "dd-mm-yyyy" })
    .on('changeDate', function(ev){
        var tStart = new Array();
        if($('#tglawalrl').val()){
            tStart = ($('#tglawalrl').val()).split("-");
        }
        tglAwal = new Date(tStart[2]+"-"+tStart[1]+"-"+tStart[0]);
        if (ev.date.valueOf() < startDate.valueOf()){
            $('#alert').show().find('strong').text('The end date must be after the start date.');
        } else if(ev.date.valueOf() < tglAwal.valueOf()){
            $('#alert').show().find('strong').text('Tanggal akhir tidak sebelum tanggal awal');
        } else {
            $('#alert').hide();
            endDate = new Date(ev.date);
        }
        $('#tglakhirrl').datepicker('hide');
    });

//Biaya Operasional
$('#alertBiayaOperasional').hide();
$('#tglawalbo')
    .datepicker({ format: "dd-mm-yyyy" })
    .on('changeDate', function(ev){
        var tEnd = new Array();
        if($('#tglakhirbo').val()){
            tEnd = ($('#tglakhirbo').val()).split("-");
        }
        tglAkhir = new Date(tEnd[2]+"-"+tEnd[1]+"-"+tEnd[0]);
        if (ev.date.valueOf() > endDate.valueOf()){
            $('#alert').show().find('strong').text('Tanggal tidak boleh melebihi dari hari ini');
        } else if (ev.date.valueOf() > tglAkhir.valueOf()) {
            $('#alert').show().find('strong').text('Tanggal awal tidak boleh melebihi tanggal akhir');
        } else {
            $('#alert').hide();
            startDate = new Date(ev.date);
        }
        $('#tglawalbo').datepicker('hide');
     });
$('#tglakhirbo')
    .datepicker({ format: "dd-mm-yyyy" })
    .on('changeDate', function(ev){
        var tStart = new Array();
        if($('#tglawalbo').val()){
            tStart = ($('#tglawalbo').val()).split("-");
        }
        tglAwal = new Date(tStart[2]+"-"+tStart[1]+"-"+tStart[0]);
        if (ev.date.valueOf() < startDate.valueOf()){
            $('#alert').show().find('strong').text('The end date must be after the start date.');
        } else if(ev.date.valueOf() < tglAwal.valueOf()){
            $('#alert').show().find('strong').text('Tanggal akhir tidak sebelum tanggal awal');
        } else {
            $('#alert').hide();
            endDate = new Date(ev.date);
        }
        $('#tglakhirbo').datepicker('hide');
    });

</script>