<div class="row">
    <div class="col-md-12">
        <div class="col-sm-23">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Sisa Anggaran PSBI Tahun <?=date('Y')?></h3><br>                    
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-lg-4 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-maroon">
                            <div class="inner">
                                <h3>Rp<?=number_format($SUM['nSaldoAkhirReguler'])?></h3>
                                <p>PSBI Reguler</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-book"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-purple">
                            <div class="inner">
                                <h3>Rp<?=number_format($SUM['nSaldoAkhirTematik'])?></h3>
                                <p>PSBI TEMATIK</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-book"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <h3>Rp<?=number_format($SUM['nSaldoAkhirBeasiswa'])?></h3>
                                <p>PSBI BEASISWA</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-book"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-sm-23">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Total Pencairan Selama Tahun <?=date('Y')?></h3><br>                    
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="panel-body" id="chart_real_byLokasi" style="width:85%"></div>
                </div>
                <div class="box-body">
                    <div class="panel-body" id="chart_real_byGolongan" style="width:85%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?=base_url('bismillah/chart/Chart-2.4.0.min.js')?>"></script>
<script>
$(function () {
    <?=cekbosjs();?>

    bos.dpsbi.loading      	= '<div class="loading-text">Loading...</div>' ;
    bos.dpsbi.loadc          = function(){
        bos.dpsbi.obj.find("#chart_real_byLokasi").html(bos.dpsbi.txt_loading) ;
        bjs.ajax(this.url + "/loadc") ;
        bjs.ajax(this.url + "/load_chart_realByGolongan") ;
    }

    bos.dpsbi.setc  = function(jdata) {
        bos.dpsbi.obj.find("#chart_real_byLokasi").html('<canvas id="vs_chart_real_byLokasi" width="100%"></canvas>') ;
        bos.dpsbi.cchart_real_byLokasi = bos.dpsbi.obj.find("#vs_chart_real_byLokasi")[0].getContext("2d") ;

        bos.dpsbi.chart_real_byLokasi  = new Chart( bos.dpsbi.cchart_real_byLokasi, {
            type : "bar",
            data : jdata,
            options :{
                title : {
                    display: true,
                    text: "Total Realisasi Per Lokasi"
                },
                legend: {
                    display: true,
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            stepSize: 50000000,
                            userCallback: function(value, index, values) {
                                // Convert the number to a string and splite the string every 3 charaters from the end
                                value = value.toString();
                                value = value.split(/(?=(?:...)*$)/);
                    
                                // Convert the array to a string and format the output
                                value = value.join(".");
                                return "Rp. " + value;
                            }
                        },
                        scaleLabel: {
                            display: true,
                            labelString: "Omset"
                          }
                    }],
                },
                tooltips: {
                    mode: "index",
                    podition: "nearest",
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var nominal = tooltipItem.yLabel.toString();
                            nominal = nominal.split(/(?=(?:...)*$)/);
                    
                            // Convert the array to a string and format the output
                            nominal = nominal.join(".");
                            
                            var isi = data.datasets[tooltipItem.datasetIndex].label + " : Rp. " + nominal;
                            return isi ;
                        }
                    }
                },
                // animation: {
                //     onComplete: function() {
                //         const chartInstance = this.chart,
                //         ctx = chartInstance.ctx;
     
                //         ctx.font = Chart.helpers.fontString(
                //             13,
                //             Chart.defaults.global.defaultFontStyle,
                //             Chart.defaults.global.defaultFontFamily
                //         );
                //         ctx.textAlign = "center";
                //         ctx.textBaseline = "bottom";
     
                //         this.data.datasets.forEach(function(dataset, i) {
                //             const meta = chartInstance.controller.getDatasetMeta(i);
                        
                //             meta.data.forEach(function(bar, index) {
                //                 const data = dataset.data[index];

                //                 var nominal = data.toString();
                //                 nominal = nominal.split(/(?=(?:...)*$)/);
                    
                //                 // Convert the array to a string and format the output
                //                 nominal = nominal.join(".");

                //                 ctx.fillStyle = "#000";
                //                 ctx.fillText("Rp. "+nominal, bar._model.x, bar._model.y - 2);
                //             });
                //         });
                //     }
                // }
            }
        });
        this.obj.find("#text_bt").html("") ;
    }

    bos.dpsbi.setChartByGolongan  = function(jdata) {
        bos.dpsbi.obj.find("#chart_real_byGolongan").html('<canvas id="vs_chart_real_byGolongan" width="100%"></canvas>') ;
        bos.dpsbi.cchart_real_byGolongan = bos.dpsbi.obj.find("#vs_chart_real_byGolongan")[0].getContext("2d") ;

        bos.dpsbi.chart_real_byGolongan  = new Chart( bos.dpsbi.cchart_real_byGolongan, {
            type : "horizontalBar",
            data : jdata,
            options :{
                title : {
                    display: true,
                    text: "Total Realisasi Per Golongan PSBI"
                },
                legend: {
                    display: true,
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero:true,
                            stepSize: 100000000,
                            userCallback: function(value, index, values) {
                                // Convert the number to a string and splite the string every 3 charaters from the end
                                value = value.toString();
                                value = value.split(/(?=(?:...)*$)/);
                    
                                // Convert the array to a string and format the output
                                value = value.join(".");
                                return "Rp. " + value;
                            }
                        },
                        scaleLabel: {
                            display: true,
                            labelString: "Omset"
                          }
                    }],
                },
                tooltips: {
                    mode: "index",
                    podition: "nearest",
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var nominal = tooltipItem.xLabel.toString();
                            nominal = nominal.split(/(?=(?:...)*$)/);
                    
                            // Convert the array to a string and format the output
                            nominal = nominal.join(".");
                            
                            var isi = data.datasets[tooltipItem.datasetIndex].label + " : Rp. " + nominal;
                            return isi ;
                        }
                    }
                },
            }
        });
        this.obj.find("#text_bt").html("") ;
    }

    bos.dpsbi.initFunc 		= function(){
        bos.dpsbi.loadc() ;
    }

    $(function(){
        bos.dpsbi.initFunc() ;
    }) ;
})
</script>