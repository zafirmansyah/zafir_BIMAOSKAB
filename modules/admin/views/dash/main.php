  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?=$Jumlah['JmlSuratMasuk']?></h3>

          <p>Surat Masuk</p>
        </div>
        <div class="icon">
          <i class="ion ion-ios-email"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?=$Jumlah['JmlM02']?></h3>

          <p>M02</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?=$Jumlah['JmlIKU']?></h3>

          <p>IKU</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?=$Jumlah['JmlWO']?></h3>

          <p>Work Order</p>
        </div>
        <div class="icon">
          <i class="ion ion-briefcase"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Daftar Work Order</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <?php
            //var_dump($DataWO);
          ?>
          <table id="tableWO" class="table table-bordered table-super-condensed table-striped">
            <thead>
              <tr>
                <th>Judul</th>
                <th>Dari</th>
                <th>Tgl</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(!empty($DataWO)){
                foreach($DataWO as $key=>$value){
                  $dTgl = s_2date($value['Tgl']);
             ?>
                <tr>
                  <td><?=$value['Subject']?></td>
                  <td><?=$value['UserName']?></td>
                  <td><?=$dTgl?></td>
                  <td><?=$value['TextStatus']?></td>
                </tr>
              <?php
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Daftar IKU</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <?php
            //($DataIKU);
          ?>
          <table id="tableIKU" class="table table-bordered table-super-condensed table-striped">
            <thead>
              <tr>
                <th>Kode</th>
                <th>Judul</th>
                <th>Periode</th>
                <th>Dari</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(!empty($DataIKU)){
                foreach($DataIKU as $key=>$value){
              ?>
                <tr>
                  <td><?=$value['Kode']?></td>
                  <td><?=$value['Subject']?></td>
                  <td><?=$value['Periode']?></td>
                  <td><?=$value['UserName']?></td>
                </tr>
              <?php
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script>
  $(function () {
    $('#tableWO').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
    $('#tableIKU').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
    
  })
</script>