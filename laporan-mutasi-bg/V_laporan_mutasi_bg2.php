            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEAD-->
                    <div class="page-head">
                        <!-- BEGIN PAGE TITLE -->
                        <div class="page-title">
                            <h1><?php if(isset($title_page)) echo $title_page;?>
                                <small><?php if(isset($title_page2)) echo $title_page2;?></small>
                            </h1>
                        </div>
                        <!-- END PAGE TITLE -->
                        <!-- END PAGE TOOLBAR -->
                    </div>
                    <!-- END PAGE HEAD-->
                    <!-- BEGIN PAGE BREADCRUMB -->
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo base_url();?>"> Dashboard </a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <a href="#"> <?php if(isset($title_page)) echo $title_page;?> </a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active"><?php if(isset($title_page2)) echo $title_page2;?></span>
                        </li>
                    </ul>
                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light portlet-fit portlet-datatable bordered">
                                <div class="portlet-title">
                                        <div class="caption">
                                            <i class=" icon-list font-dark"></i> &nbsp;&nbsp;
                                            <span class="caption-subject font-dark sbold uppercase">Data <?php if(isset($title_page2)) echo $title_page2;?></span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <form action="SPP-Belum-Realisasi/Print-Data" id="formData" class="form-horizontal" method="POST">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Nama Cabang
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <select class="form-control" id="m_cabang_id" name="m_cabang_id" aria-required="true" aria-describedby="select-error">
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- <label class="control-label col-md-2">Periode
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                                            <input type="text" class="form-control" name="from_tanggal" id="from_tanggal" value="<?php echo date('m/01/Y')?>">
                                                            <span class="input-group-addon"> s/d </span>
                                                            <input type="text" class="form-control" name="to_tanggal" id="to_tanggal" value="<?php echo date('m/t/Y')?>"> 
                                                        </div>
                                                    </div> -->
                                                    <!-- /input-group -->
                                                    <!-- <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <select class="form-control" id="month" name="month" aria-required="true" aria-describedby="select-error">
                                                        </select>
                                                    </div> -->
                                                <!-- </div> -->
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2"> Periode 
                                                    <span class="required">  *  </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                                            <input type="text" class="form-control" name="from_tanggal" id="from_tanggal" value="<?php echo date('m/01/Y')?>">
                                                            <span class="input-group-addon"> s/d </span>
                                                            <input type="text" class="form-control" name="to_tanggal" id="to_tanggal" value="<?php echo date('m/t/Y')?>"> 
                                                        </div>
                                                    </div>
                                                    <!-- /input-group -->
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    
                                                    <!-- <button type="button" class="btn green-jungle" onclick="searchDataKartuStokMasuk()" style="display: none;">
                                                        Lihat Laporan
                                                    </button> -->
                                                    <button type="button" class="btn dark" onclick="searchDataLaporan()">
                                                        <span class="fa fa-search"></span> Lihat Laporan
                                                    </button>
                                                    <!-- <button type="button" class="btn blue-sharp" onclick="cetakDataLaporan2()" title="Cetak Laporan Rekap Pembelian">
                                                        <span class="icon-printer"></span> Cetak Rekap
                                                    </button> -->
                                                    <button type="button" class="btn green-jungle" onclick="cetakDataLaporan()">
                                                        <span class="icon-printer"></span> Cetak
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="default-table" style="display: block; overflow: auto; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th> No </th>
                                                    <th> No BG</th>
                                                    <th> Keterangan </th>
                                                    <th> Nama Bank </th>
                                                    <th> No Perkiraan </th>
                                                    <th> Penerimaan </th>
                                                    <th> Pengeluaran </th>
                                                </tr> 
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
    <?php $this->load->view('layout/V_footer');?>

<script type="text/javascript">
            $(document).ready(function(){
                jmlKoLom = 0;
                var table = '';
                // searchDataStok();
                // $('#default-table').DataTable();
                $('#m_cabang_id').css('width', '100%');
                $('#default-table').addClass('no-wrap');
                selectList_cabang();
                $('.date-picker').datepicker();
            });

            // function format ( d ) {
            //     // `d` is the original data object for the row
            //     // alert(d.detail);
            //     var tableDetails = '<table class="table table-hover table-bordered table-striped" width="100%">\
            //     <thead>\
            //         <tr>\
            //             <th style="text-align:center;" width="10%"> Nama Barang </th>\
            //             <th style="text-align:center;" width="10%"> Qty Order </th>\
            //             <th style="text-align:center;" width="10%"> Qty Surat Jalan </th>\
            //             <th style="text-align:center;" width="10%"> Qty Faktur </th>\
            //         </tr>\
            //     </thead>';
            //     for(var i = 0; i < d.detail.val2.length; i++) {
            //         tableDetails = tableDetails + '<tr>\
            //             <td align="left">'+d.detail.val2[i].po_customer_nomor+'</td>\
            //             <td align="left">'+d.detail.val2[i].po_customer_tanggal+'</td>\
            //             <td align="left">'+d.detail.val2[i].barang_nama+' '+d.detail.val2[i].barang_ukuran+'</td>\
            //             <td align="right" class="money">'+d.detail.val2[i].surat_jalandet_qty_kirim+'</td>\
            //             <td align="left">'+d.detail.val2[i].satuan_nama+'</td>\
            //             <td align="right">\
            //                 <table>\
            //                     <tr>\
            //                         <td>Rp.</td>\
            //                         <td class="money">'+d.detail.val2[i].po_customerdet_harga_satuan+'</td>\
            //                     </tr>\
            //                 </table>\
            //             </td>\
            //             <td align="right">\
            //                 <table>\
            //                     <tr>\
            //                         <td>Rp.</td>\
            //                         <td class="money">'+(d.detail.val2[i].surat_jalandet_qty_kirim*d.detail.val2[i].po_customerdet_harga_satuan)+'</td>\
            //                     </tr>\
            //                 </table>\
            //             </td>\
            //         </tr>';
            //     }
            //     tableDetails = tableDetails + '</table>';
            //     return tableDetails;
            // }

            function searchDataLaporan() { 
                // $('#default-table tbody').empty();
                // // var table = $('#default-table').DataTable();
                // // table.clear();
                // // inp = document.getElementById('periode').value;
                // // periods = inp.split("/");
                // // var dataSet = [];
                // $.ajax({
                //   type : "GET",
                //   url  : '<?php echo base_url();?>Laporan/Penjualan/loadData/',
                //   data : { id_cabang : document.getElementById("m_cabang_id").value, from_tanggal : document.getElementById("from_tanggal").value, to_tanggal : document.getElementById("to_tanggal").value },
                //   dataType : "json",
                //   success:function(data){
                //     // getWeek();
                //     for(var i=0; i < data.val.length; i++) {
                //         $('#default-table tbody').append('<tr>\
                //             <td>'+data.val[i].no+'</td>\
                //             <td>'+data.val[i].faktur_penjualan_nomor+'</td>\
                //             <td>'+data.val[i].faktur_penjualan_tanggal+'</td>\
                //             <td>'+data.val[i].tanggal_kirim+'</td>\
                //             <td>'+data.val[i].faktur_penjualan_jatuh_tempo+'</td>\
                //             <td>'+data.val[i].customer_nama+'</td>\
                //             <td align="right">'+data.val[i].faktur_penjualan_sub_total+'</td>\
                //             <td align="right">'+data.val[i].faktur_penjualan_potongan+'</td>\
                //             <td align="right">'+data.val[i].faktur_penjualan_uang_muka+'</td>\
                //             <td align="right">'+data.val[i].faktur_penjualan_total+'</td>\
                //             <td>'+data.val[i].faktur_penjualan_catatan+'</td>\
                //         </tr>');
                //         // alert(data.val[i]);
                //         // dataSet.push(data.val[i].split(','));
                //         // data = data.val[i].split(",");
                //         // strData = '';
                //         // for(var j=0; j<data.val[i].length; j++) {
                //         //     strData = strData + '<td>'+data.val[i][j]+'</td>';
                //         // }
                //         // $('#default-table tbody').append('<tr>\
                //         //     '+strData+'\
                //         // </tr>');
                //         // alert(jmlKoLom);
                //     }
                //     // table.draw();
                //     // alert(dataSet[0]); 
                //     $('#default-table').DataTable();
                //   }
                // });
                
                $('#default-table').DataTable({
                    destroy: true,
                    "processing": true,
                    "serverSide": true,
                    ajax: {
                      url: '<?php echo base_url();?>Laporan/Mutasi-BG/loadData/',
                      data: { id_cabang : document.getElementById("m_cabang_id").value , from_tanggal : document.getElementById("from_tanggal").value, to_tanggal : document.getElementById("to_tanggal").value  }
                    },
                    "columns": [
                      {"data": "no","orderable": false,"searchable": false,  "className": "text-center", "width": "5%"},
                      {"data": "bukti_bgcek_nomor"},
                      {"data": "bukti_bgcek_catatan"},
                      {"data": "bank_nama"},
                      {"data": "coa_kode"},
                      {"data": "payment_request_piutangdet_jumlah", "className":"text-right"},
                      {"data": "payment_requestdet_jumlah", "className":"text-right"}
                      // {"data": "po_customerdet_qty", "className":"text-right"},
                      // {"data": "retur_penjualandet_qty", "className":"text-right"},
                      // {"data": "qty_kirim", "className":"text-right"},
                      // {"data": "qty_nota", "className":"text-right"}
                    ],
                    // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                    "language": {
                        "aria": {
                            "sortAscending": ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        },
                        "emptyTable": "No data available in table",
                        "info": "Showing _START_ to _END_ of _TOTAL_ records",
                        "infoEmpty": "No records found",
                        "infoFiltered": "(filtered _TOTAL_ from _MAX_ total records)",
                        "lengthMenu": "Show _MENU_",
                        "search": "Search:",
                        "zeroRecords": "No matching records found",
                        "paginate": {
                            "previous":"Prev",
                            "next": "Next",
                            "last": "Last",
                            "first": "First"
                        }
                    },

                    // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                    // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
                    // So when dropdowns used the scrollable div should be removed. 
                    //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

                    "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
                    "pagingType": "bootstrap_extended",

                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100] // change per page values here
                    ],
                    // set the initial value
                    "pageLength": 10,
                    "columnDefs": [{  // set default column settings
                        'orderable': false,
                        'targets': [0]
                    }, {
                        "searchable": false,
                        "targets": [0]
                    }],
                    "order": [
                        [1, "asc"]
                    ],
                    "iDisplayLength": 10
                });
            }

            // $('#default-table tbody').on('click', 'td.details-control', function () {
            //     var tr = $(this).closest('tr');
            //     var row = table.row( tr );
         
            //     if ( row.child.isShown() ) {
            //         // This row is already open - close it
            //         row.child.hide();
            //         tr.removeClass('shown');
            //     }
            //     else {
            //         // Open this row
            //         row.child( format(row.data()) ).show();
            //         $('.money').number( true, 2, '.', ',' );
            //         $('.money').css('text-align', 'right');
            //         tr.addClass('shown');
            //     }
            // } );

            // function getWeek() {
            //     $('#default-table thead').empty();
            //     inp = document.getElementById('periode').value;
            //     periods = inp.split("/");
            //     kolomWeeks = '';
            //     kolomWeekswithDate = '';
            //     kolomtabel = [];
            //     kolomtabel.push('Marketing');
            //     // var weeks=[],
            //    firstDate=new Date(periods[1], periods[0]-1, 1);
            //    lastDate=new Date(periods[1], periods[0], 0);
            //    numDays= lastDate.getDate();
            //    console.log('firstDate : '+firstDate);
            //    console.log('lastDate : '+lastDate);

            //    var start=1;
            //    var end=7-firstDate.getDay()+1;
            //    // console.log('end : '+firstDate.getDay());
            //    var weeks = 1;
            //    while(start<=numDays){
            //        // weeks.push({start:start,end:end});
            //         kolomWeeks = kolomWeeks + '<th>Minggu '+weeks+' (Rp.) </th>';
            //         kolomWeekswithDate = kolomWeekswithDate + '<th>'+start+'/'+periods[0]+'/'+periods[1]+' - '+end+'/'+periods[0]+'/'+periods[1]+' </th>';
            //         jmlKoLom++;
            //         kolomtabel.push('Minggu '+weeks+' (Rp.)<br>'+start+'/'+periods[0]+'/'+periods[1]+' - '+end+'/'+periods[0]+'/'+periods[1]);
            //         start = end + 1;
            //         end = end + 7;
            //         weeks++;
            //         if(end>numDays)
            //            end=numDays;    
            //     }
            //     kolomtabel.push('Total Profit / Mkt<br>Total Omzet');
            //     kolomtabel.push('Komisi');
            //     jmlKoLom = jmlKoLom+3;
            //     $('#default-table thead').append('\
            //         <tr>\
            //             <th rowspan="2" style="width:30%;">Marketing</th>\
            //             '+kolomWeeks+'\
            //             <th>Total Profit / Mkt</th>\
            //             <th rowspan="2">Komisi</th>\
            //         </tr>\
            //         <tr>\
            //             '+kolomWeekswithDate+'\
            //             <th>Total Omzet</th>\
            //         </tr>\
            //     ');
            //     // return kolomtabel;
            //    // alert(weeks[0]['start'] + ' - ' + weeks[0]['end']);
            //    //  return weeks;
            // }

            function cetakDataLaporan()
            {
                window.open('<?php echo base_url();?>Laporan/Mutasi-BG/Print-Data/'+document.getElementsByName("m_cabang_id")[0].value);
            }

            // function cetakDataLaporan2()
            // {
            //     window.open('<?php echo base_url();?>Laporan/Penjualan/Print-Rekap/'+document.getElementsByName("m_cabang_id")[0].value+'/'+document.getElementsByName("from_tanggal")[0].value+'/'+document.getElementsByName("to_tanggal")[0].value);
            // }

        </script>   