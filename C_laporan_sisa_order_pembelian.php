<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_laporan_sisa_order_pembelian extends MY_Controller {
	private $any_error = array();
	// Define Main Table
	public $tbl = '';

	public function __construct() {
        parent::__construct();
	}

	public function index(){
		// $this->view();
	}

	public function view($type, $id = NULL){
		$this->check_session();
		// $priv = $this->cekUser(20);
		if ($type == 1) {
			$data = array(
				'aplikasi'		=> $this->app_name,
				'title_page' 	=> 'Laporan',
				'title_page2' 	=> 'Laporan Sisa Order Pembelian',
				);
			$this->open_page('manufaktur/laporan-sisa-order-pembelian/V_laporan_sisa_order_pembelian', $data);
		} else if ($type == 2) {
			$data = array(
				'aplikasi'		=> $this->app_name,
				'title_page' 	=> 'Laporan',
				'title_page2' 	=> 'Laporan Sisa Order Pembelian',
				);
			$this->open_page('manufaktur/laporan-sisa-order-pembelian/V_laporan_laba_kotor', $data);
			// $where['data'][] = array(
			// 	'column' => 'partner_id',
			// 	'param'	 => $id
			// );
			// $query = $this->mod->select('*', 'm_partner', NULL, $where);
			// if ($query) {
			// 	foreach ($query->result() as $row) {
			// 		$data = array(
			// 			'aplikasi'		=> $this->app_name,
			// 			'title_page' 	=> 'Accounting',
			// 			'title_page2' 	=> 'Laporan Outstanding Hutang',
			// 			'partner_nama'	=> $row->partner_nama,
			// 			'query_hutang'	=> $this->mod->outstandingHutangDetail($row->partner_id),
			// 		);
			// 	}
			// }
			// $this->open_page('manufaktur/outstanding-hutang/V_outstanding_hutang_detail', $data);
		} else if ($type == 3) {
			$data = array(
				'aplikasi'		=> $this->app_name,
				'title_page' 	=> 'Laporan',
				'title_page2' 	=> 'Laporan Sisa Order Pembelian',
				);
			$this->open_page('manufaktur/laporan-sisa-order-pembelian/V_laporan_sisa_order_pembelian2', $data);
		} 
		// if($priv['read'] == 1)
		// {
		// 	$this->open_page('nota-debet/V_nota_debet', $data);
		// }
		// else
		// {
		// 	$this->load->view('layout/V_404', $data);
		// }
	}

	public function loadData($type){

		$response['data'] = array();
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		 $where['data'][] = array(
		 	'column' => 'cabang_id',
		 	'param'	 => $this->input->get('id_cabang')
		 );
		 $where['data'][] = array(
		 	'column' => 'po_customer_tanggal >=',
		 	'param'	 => date('Y/m/d H:i:s', strtotime($this->input->get('from_tanggal')))
		 );
		 $where['data'][] = array(
		 	'column' => 'po_customer_tanggal <=',
		 	'param'	 => date('Y/m/d H:i:s', strtotime($this->input->get('to_tanggal')))
		 );
		// WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'po_customer_nomor',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][data]'),
			'type'	 => $this->input->get('order[0][dir]')
		);
		$response['order'] = $order;
		if($type == 1){
			$query_total = $this->mod->select('*', 'v_laporan_sisa_order_pembelian', null, $where);
			$query_filter = $this->mod->select('*', 'v_laporan_sisa_order_pembelian', NULL, $where, NULL, $where_like, $order);
			$query = $this->mod->select('*', 'v_laporan_sisa_order_pembelian', NULL, $where, NULL, $where_like, $order, $limit);
			// echo $this->db->last_query();
			// echo "a";
			// $query_total = $this->mod->outstandingHutang();
			// $query_filter = $this->mod->outstandingHutang($where_like, $order);
			//$query = $this->mod->POCReport($this->input->get('id_cabang'), $order, $limit);
			$no = 1;
			// $response['val'] = array();
			if ($query<>false) {
				foreach ($query->result() as $val) {
					// $response['val'] = "masuk";
						$dpp = 0;
					$ppn = 0;
					$total = 0;
					if($val->po_customer_ppn == 1){
						// YA
						$total = $val->po_customerdet_harga_satuan * $val->po_customerdet_qty;
						$dpp = $val->po_customerdet_harga_satuan * 1.1;
						$ppn = $val->po_customerdet_harga_satuan * 10 / 100;
					} else if($val->po_customer_ppn == 2){
						// TIDAK
						$total = $val->po_customerdet_harga_satuan * $val->po_customerdet_qty;
						$dpp = $val->po_customerdet_harga_satuan / 1.1;
						$ppn = $val->po_customerdet_harga_satuan - $dpp;
					}
					$response['data'][] = array(
						'no' => $no,
						'po_customer_nomor' 			=> $val->po_customer_nomor,
						'po_customer_tanggal' 			=> date('d-m-Y', strtotime($val->po_customer_tanggal)),
						'customer_nama' 				=> $val->partner_nama,
						'barang_kode'					=> $val->barang_kode,
						'barang_nama'					=> $val->barang_nama,
						'po_customerdet_qty'			=> number_format($val->po_customerdet_qty, 2, '.', ','),
						'po_customerdet_harga_satuan'	=> number_format($val->po_customerdet_harga_satuan, 2, '.', ','),
						'dpp'							=> 'Rp '.number_format($dpp, 2, '.', ','),
						'ppn'							=> 'Rp '.number_format($ppn, 2, '.', ','),
						'total'							=> 'Rp '.number_format($total, 2, '.', ','),
						'po_customerdet_keterangan'		=> $val->po_customerdet_keterangan,
							
						);
						$no++;
				}
			}
		} else if($type == 2){
			echo "a";
			$query_total = $this->mod->select('*', 'v_laporan_sisa_order_pembelian', null, $where);
			$query_filter = $this->mod->select('*', 'v_laporan_sisa_order_pembelian', NULL, $where, NULL, $where_like, $order);
			$query = $this->mod->select('*', 'v_laporan_sisa_order_pembelian', NULL, $where, NULL, $where_like, $order, $limit);
			if ($query<>false) {
				foreach ($query->result() as $val) {
					//CARI KOTA
					$hasil['val2'] = array();
					$where_kota['data'][] = array(
						'column' => 'id',
						'param'	 => $val2->partner_kota
					);
					$query_kota = $this->mod->select('*','regencies',NULL,$where_kota);
					if ($query_kota) {
						foreach ($query_kota->result() as $val3) {
							$hasil['val3'][] = array(
								'id' 		=> $val3->id,
								'text' 		=> $val3->name,
							);
						}
					}
					// END CARI KOTA
					//HITUNG DPP
					$dpp = 0;
					$ppn = 0;
					$total = 0;
					if($val->po_customer_ppn == 1){
						// YA
						$total = $val->po_customerdet_harga_satuan * $val->po_customerdet_qty;
						$dpp = $val->po_customerdet_harga_satuan * 1.1;
						$ppn = $val->po_customerdet_harga_satuan * 10 / 100;
					} else if($val->po_customer_ppn == 2){
						// TIDAK
						$total = $val->po_customerdet_harga_satuan * $val->po_customerdet_qty;
						$dpp = $val->po_customerdet_harga_satuan / 1.1;
						$ppn = $val->po_customerdet_harga_satuan - $dpp;
					}
					$response['data'][] = array(
						'no' => $no,
						'po_customer_nomor' 			=> $val->po_customer_nomor,
						'po_customer_tanggal' 			=> date('d-m-Y', strtotime($val->po_customer_tanggal)),
						'customer_nama' 				=> $val->partner_nama,
						'barang_kode'					=> $val->barang_kode,
						'barang_nama'					=> $val->barang_nama,
						'po_customerdet_qty'			=> number_format($val->po_customerdet_qty, 2, '.', ','),
						'po_customerdet_harga_satuan'	=> number_format($val->po_customerdet_harga_satuan, 2, '.', ','),
						'dpp'							=> 'Rp '.number_format($dpp, 2, '.', ','),
						'ppn'							=> 'Rp '.number_format($ppn, 2, '.', ','),
						'total'							=> 'Rp '.number_format($total, 2, '.', ','),
						'po_customerdet_keterangan'		=> $val->po_customerdet_keterangan,
					);
					$no++;
				}
			}
		}

		// $response['recordsTotal'] = 0;
		// if ($query_total<>false) {
		// 	$response['recordsTotal'] = $query_total->num_rows();
		// }
		// $response['recordsFiltered'] = 0;
		// if ($query_filter<>false) {
		// 	$response['recordsFiltered'] = $query_filter->num_rows();
		// }
		// print_r($type);
		echo json_encode($response);
	}

	public function cetakPDF($cabang){
		$url = '';
		$this->load->library('pdf');
		// $awal = $tanggalawal.'-'.$bulanawal.'-'.$tahunawal;
		// $akhir =$tanggalakhir.'-'.$bulanakhir.'-'.$tahunakhir;
		$name = 'Laporan Sisa Order Pembelian '.date('d-m-Y');
		// if($type == 1) {
		// 	$name = 'Laporan Penjualan Detail '.date('d-m-Y', strtotime($awal)).' - '.date('d-m-Y', strtotime($akhir)).'';
		// } else {
		// 	$name = 'Laporan Rekap Penjualan '.date('d-m-Y', strtotime($awal)).' - '.date('d-m-Y', strtotime($akhir)).'';
		// }
		$order['data'][] = array(
			'column' => 'po_customer_tanggal',
			'type'	 => 'ASC'
		);
		$query = $this->mod->POCReport($cabang, $order);
		$response['val'] = array();
		if ($query<>false) {
			$no = 1;
			foreach ($query->result() as $val) {
				// $hasil['val2'] = array();
				// if($type == 1) {
				// 	if(@$join_det['data']) {
				// 		unset($join_det['data']);
				// 	} 
				// 	if(@$where_det['data']) {
				// 		unset($where_det['data']);
				// 	} 
				// 	// CARI DETAIL
				// 	$join_det['data'][] = array(
				// 		'table'	=> 't_po_customer b',
				// 		'join'	=> 'b.po_customer_id = a.t_po_customer_id',
				// 		'type'	=> 'left'
				// 	);
				// 	$join_det['data'][] = array(
				// 		'table'	=> 't_surat_jalandet c',
				// 		'join'	=> 'c.surat_jalandet_id = a.t_surat_jalandet_id',
				// 		'type'	=> 'left'
				// 	);
				// 	$join_det['data'][] = array(
				// 		'table'	=> 't_surat_jalan h',
				// 		'join'	=> 'h.surat_jalan_id = c.t_surat_jalan_id',
				// 		'type'	=> 'left'
				// 	);
				// 	$join_det['data'][] = array(
				// 		'table'	=> 't_po_customerdet d',
				// 		'join'	=> 'd.po_customerdet_id = c.t_po_customerdet_id',
				// 		'type'	=> 'left'
				// 	);
				// 	$join_det['data'][] = array(
				// 		'table'	=> 'm_barang e',
				// 		'join'	=> 'e.barang_id = d.m_barang_id',
				// 		'type'	=> 'left'
				// 	);
				// 	$join_det['data'][] = array(
				// 		'table'	=> 'm_jenis_barang f',
				// 		'join'	=> 'f.jenis_barang_id = e.m_jenis_barang_id',
				// 		'type'	=> 'left'
				// 	);
				// 	$join_det['data'][] = array(
				// 		'table'	=> 'm_satuan g',
				// 		'join'	=> 'g.satuan_id = e.m_satuan_id',
				// 		'type'	=> 'left'
				// 	);
				// 	$where_det['data'][] = array(
				// 		'column' => 'a.t_faktur_penjualan_id',
				// 		'param'	 => $val->faktur_penjualan_id
				// 	);
				// 	$query_det = $this->mod->select('a.*, b.*, c.*, d.*, e.*, f.*, g.*, h.*','t_faktur_penjualandet a', $join_det, $where_det);
				// 	if ($query_det) {
				// 		foreach ($query_det->result() as $val2) {
				// 				$konversi = 1;
				// 				$konversi_jual = 1;
				// 				$satuan_konversi = '';
				// 				$satuan_konversi_jual = '';
				// 				if (@$where_konversi['data']) {
				// 					unset($where_konversi['data']);
				// 				}
				// 				if (@$join_satuan['data']) {
				// 					unset($join_satuan['data']);
				// 				}
				// 				$join_satuan['data'][] = array(
				// 					'table' => 'm_satuan b',
				// 					'join'	=> 'b.satuan_id = a.konversi_akhirsatuan',
				// 					'type'	=> 'left'
				// 				);
				// 				$join_satuan['data'][] = array(
				// 					'table' => 'm_satuan c',
				// 					'join'	=> 'c.satuan_id = a.konversi_akhirsatuan_jual',
				// 					'type'	=> 'left'
				// 				);
				// 				$where_konversi['data'][] = array(
				// 					'column' => 'barang_id',
				// 					'param'	 => $val2->m_barang_id
				// 				);
				// 				$queryKonversi = $this->mod->select('a.*, b.satuan_nama AS satuan_konversi, c.satuan_nama AS satuan_konversi_jual', 'm_konversi a', $join_satuan, $where_konversi);
				// 				if($queryKonversi)
				// 				{
				// 					foreach ($queryKonversi->result() as $val3) {
				// 						$konversi = $val3->konversi_akhir;
				// 						$satuan_konversi = $val3->satuan_konversi;
				// 						$konversi_jual = $val3->konversi_akhir_jual;
				// 						$satuan_konversi_jual = $val3->satuan_konversi_jual;
				// 					}
				// 				}
				// 				$hasil['val2'][] = array(
				// 					'faktur_penjualandet_id'		=> $val2->faktur_penjualandet_id,
				// 					't_faktur_penjualan_id'			=> $val2->t_faktur_penjualan_id,
				// 					't_po_customer_id'				=> $val2->t_po_customer_id,
				// 					'po_customer_nomor'				=> $val2->po_customer_nomor,
				// 					'po_customer_tanggal'			=> date('d/m/Y', strtotime($val2->po_customer_tanggal)),
				// 					'po_customer_persentase'		=> $val2->po_customer_persentase,
				// 					'faktur_penjualandet_uraian'	=> $val2->faktur_penjualandet_uraian,
				// 					'faktur_penjualandet_persentase'=> $val2->faktur_penjualandet_persentase,
				// 					'po_customer_total'				=> $val2->po_customer_total,
				// 					'surat_jalandet_qty_kirim'		=> $val2->surat_jalandet_qty_kirim,
				// 					'po_customerdet_harga_satuan'	=> $val2->po_customerdet_harga_satuan,
				// 					'po_customerdet_keterangan'		=> $val2->po_customerdet_keterangan,
				// 					'barang_kode'					=> $val2->barang_kode,
				// 					'barang_nama'					=> $val2->barang_nama,
				// 					'barang_ukuran'					=> $val2->barang_ukuran,
				// 					'barang_merk'					=> $val2->barang_merk,
				// 					'surat_jalandet_id'				=> $val2->surat_jalandet_id,
				// 					'surat_jalan_id'				=> $val2->surat_jalan_id,
				// 					'surat_jalan_nomor'				=> $val2->surat_jalan_nomor,
				// 					'jenis_barang_nama'				=> $val2->jenis_barang_nama,
				// 					'satuan_nama'					=> $val2->satuan_nama,
				// 					'satuan_konversi'				=> $satuan_konversi,
				// 					'konversi'						=> $konversi,
				// 					'satuan_konversi_jual'			=> $satuan_konversi_jual,
				// 					'konversi_akhir_jual'			=> $konversi_jual,
				// 					'faktur_penjualandet_uraian'	=> $val2->faktur_penjualandet_uraian,
				// 					'po_customer_cetak_merk'		=> $val2->po_customer_cetak_merk,
				// 					'po_customer_jasaangkut_bayar'	=> $val2->po_customer_jasaangkut_bayar,
				// 					'po_customer_ekspedisi'			=> $val2->po_customer_ekspedisi,
				// 					'po_customer_catatan'			=> $val2->po_customer_catatan
				// 				);
				// 		}
				// 	}
				// 	// END CARI DETAIL
					$url = 'manufaktur/print/P_laporan_sisa_po';
				// } else {
				// 	$url = 'manufaktur/print/P_laporan_penjualan_rekap';
				// }
				// $SJid = json_decode($val->t_surat_jalan_id);
				// if(@$where_sj['data']) {
				// 	unset($where_sj['data']);
				// }
				// $where_sj['data'][] = array(
				// 	'column' => 'surat_jalan_id',
				// 	'param'	 => $SJid[sizeof($SJid)-1]
				// );
				// $query_sj = $this->mod->select('*', 't_surat_jalan', null, $where_sj);
				// if($query_sj) {
				// 	foreach ($query_sj->result() as $val2) {
				// 		$tanggalkirim = date('d/m/Y', strtotime($val2->surat_jalan_tanggal_kirim));
				// 	}
				// }
				//HITUNG DPP
					$dpp = 0;
					$ppn = 0;
					$total = 0;
					if($val->po_customer_ppn == 1){
						// YA
						$total = $val->po_customerdet_harga_satuan * $val->po_customerdet_qty;
						$dpp = $val->po_customerdet_harga_satuan * 1.1;
						$ppn = $val->po_customerdet_harga_satuan * 10 / 100;
					} else if($val->po_customer_ppn == 2){
						// TIDAK
						$total = $val->po_customerdet_harga_satuan * $val->po_customerdet_qty;
						$dpp = $val->po_customerdet_harga_satuan / 1.1;
						$ppn = $val->po_customerdet_harga_satuan - $dpp;
					}
					$response['data'][] = array(
						'no' => $no,
						'po_customer_nomor' 			=> $val->po_customer_nomor,
						'po_customer_tanggal' 			=> date('d-m-Y', strtotime($val->po_customer_tanggal)),
						'customer_nama' 				=> $val->partner_nama,
						'barang_kode'					=> $val->barang_kode,
						'barang_nama'					=> $val->barang_nama,
						'po_customerdet_qty'			=> number_format($val->po_customerdet_qty, 2, '.', ','),
						'po_customerdet_harga_satuan'	=> number_format($val->po_customerdet_harga_satuan, 2, '.', ','),
						'dpp'							=> 'Rp '.number_format($dpp, 2, '.', ','),
						'ppn'							=> 'Rp '.number_format($ppn, 2, '.', ','),
						'total'							=> 'Rp '.number_format($total, 2, '.', ','),
						'po_customerdet_keterangan'		=> $val->po_customerdet_keterangan,
				);
				$no++;
			}
		}
		$response['title'][] = array(
			'aplikasi'		=> $this->app_name,
			'title_page' 	=> 'Laporan',
			'title_page2' 	=> 'Laporan Sisa Order Pembelian',
		);
				
		// CARI CABANG
		$hasil1['val2'] = array();
		$where_cabang['data'][] = array(
			'column' => 'cabang_id',
			'param'	 => $cabang
		);
		$query_cabang = $this->mod->select('*','m_cabang',NULL,$where_cabang);
		if ($query_cabang) {
			foreach ($query_cabang->result() as $val2) {
				// CARI KOTA
				$hasil2['val2'] = array();
				$where_kota['data'][] = array(
					'column' => 'id',
					'param'	 => $val2->cabang_kota
				);
				$query_kota = $this->mod->select('*','regencies',NULL,$where_kota);
				if ($query_kota) {
					foreach ($query_kota->result() as $val3) {
						$hasil2['val3'][] = array(
							'id' 		=> $val3->id,
							'text' 		=> $val3->name,
						);
					}
				}
				// END CARI KOTA
				$hasil1['val2'][] = array(
					'id' 	=> $val2->cabang_id,
					'text' 	=> $val2->cabang_nama,
					'alamat'=> $val2->cabang_alamat,
					'kota'	=> $hasil2,
					'telp'  => json_decode($val2->cabang_telepon),
					'logo'	=> ""
				);
			}
		}
		$response['val'][] = array(
			'cabang'				=> $hasil1,
		);
		// END CARI CABANG
		// echo json_encode($response);
		$this->pdf->set_paper('A4', 'portrait');
		$this->pdf->load_view($url, $response);
		$this->pdf->render();
		$this->pdf->stream($name,array("Attachment"=>false));
		// $this->load->view($url, $response);
	}

	public function loadDataLabaKotor($type){
		$where['data'][] = array(
			'column' => 'cabang_id',
			'param'	 => $this->input->get('id_cabang')
		);
		$where['data'][] = array(
			'column' => 'faktur_penjualan_tanggal >=',
			'param'	 => date('Y/m/d H:i:s', strtotime($this->input->get('from_tanggal')))
		);
		$where['data'][] = array(
			'column' => 'faktur_penjualan_tanggal <=',
			'param'	 => date('Y/m/d H:i:s', strtotime($this->input->get('to_tanggal')))
		);
		$where['data'][] = array(
			'column' => 'faktur_penjualan_status_pembatalan !=',
			'param'	 => 100
		);
		$query_total = $this->mod->select('*', 'v_laporan_penjualan', null, $where);
		$no = 1;
		$response['val'] = array();
		if ($query_total<>false) {
			foreach ($query_total->result() as $val) {
				$supplier = '';
				$totalBeli = 0;
				$status = '';
				$tanggalkirim = '';
				$SJid = [];
				$SJid = json_decode($val->t_surat_jalan_id);
				for($j=0; $j < sizeof($SJid); $j++) {
					if(@$where_sj['data']) {
						unset($where_sj['data']);
					}
					$where_sj['data'][] = array(
						'column' => 'surat_jalan_id',
						'param'	 => $SJid[$j]
					);
					$query_sj = $this->mod->select('*', 't_surat_jalan', null, $where_sj);
					if($query_sj) {
						foreach ($query_sj->result() as $val2) {
							$DOid = [];
							$DOid = json_decode($val2->t_so_customer_id);
							for($i=0; $i<sizeof($DOid);$i++) {
								if(@$join_do['data']) {
									unset($join_do['data']);
								}
								if(@$where_do['data']) {
									unset($where_do['data']);
								}
								$join_do['data'][] = array(
									'table' => 't_orderdet b',
									'join'  => 'b.orderdet_id = a.t_orderdet_id',
									'type'  => 'left'
								);
								$join_do['data'][] = array(
									'table' => 't_order c',
									'join'  => 'c.order_id = b.t_order_id',
									'type'  => 'left'
								);
								$join_do['data'][] = array(
									'table' => 'm_partner d',
									'join'  => 'd.partner_id = c.m_supplier_id',
									'type'  => 'left'
								);
								$where_do['data'][] = array(
									'column' => 't_so_customer_id',
									'param'	 => $DOid[$i]
								);
								$query_do = $this->mod->select('*', 't_so_customerdet a', $join_do, $where_do);
								if($query_do) {
									foreach ($query_do->result() as $val2) {
										$totalBeli = $totalBeli + ($val2->so_customerdet_qty_kirim * $val2->orderdet_harga_satuan);
										if($supplier == '') {
											$supplier = $val2->partner_nama;
										}
									}
								}
							}
						}
					}
				}
				$persentase_laba = 0;
				if($val->faktur_penjualan_sub_total == 0) {
					$persentase_laba = 0;
				} else {
					$persentase_laba = ($val->faktur_penjualan_sub_total-$totalBeli)/$val->faktur_penjualan_sub_total*100;
				}
				$response['val'][] = array(
					'no' => $no,
					'faktur_penjualan_nomor' 			=> $val->faktur_penjualan_nomor,
					'faktur_penjualan_tanggal' 			=> date('d-m-Y', strtotime($val->faktur_penjualan_tanggal)),
					'faktur_penjualan_jatuh_tempo' 		=> date('d-m-Y', strtotime($val->faktur_penjualan_jatuh_tempo)),
					'tanggal_kirim'						=> $tanggalkirim,
					// 'order_jenis_ppn_nama' 	=> $val->order_jenis_ppn_nama,
					'customer_nama' 					=> $val->customer_nama,
					'faktur_penjualan_sub_total'		=> "RP ".number_format($val->faktur_penjualan_sub_total, 2, '.', ','),
					'faktur_penjualan_potongan' 		=> "RP ".number_format($val->faktur_penjualan_potongan, 2, '.', ','),
					'faktur_penjualan_uang_muka'		=> "RP ".number_format($val->faktur_penjualan_uang_muka, 2, '.', ','),
					'faktur_penjualan_total' 			=> "RP ".number_format($val->faktur_penjualan_total, 2, '.', ','),
					'faktur_penjualan_catatan' 			=> $val->faktur_penjualan_catatan,
					'totalBeli'							=> "RP ".number_format($totalBeli, 2, '.', ','),
					'supplier'							=> $supplier,
					'laba'							=> "RP ".number_format(($val->faktur_penjualan_sub_total-$totalBeli), 2, '.', ','),
					'persentase_laba'					=> number_format($persentase_laba, 2, '.', ','),
					// "RP ".number_format($val->nominal_sisa_hutang, 2, '.', ','),
					// $button
				);
				$no++;
			}
		}

		// $response['recordsTotal'] = 0;
		// if ($query_total<>false) {
		// 	$response['recordsTotal'] = $query_total->num_rows();
		// }
		// $response['recordsFiltered'] = 0;
		// if ($query_filter<>false) {
		// 	$response['recordsFiltered'] = $query_filter->num_rows();
		// }

		echo json_encode($response);
	}

	public function cetakPDFLabaKotor($cabang, $bulanawal, $tanggalawal, $tahunawal, $bulanakhir, $tanggalakhir, $tahunakhir, $type){
		$url = '';
		$this->load->library('pdf');
		$awal = $tanggalawal.'-'.$bulanawal.'-'.$tahunawal;
		$akhir =$tanggalakhir.'-'.$bulanakhir.'-'.$tahunakhir;
		if($type == 1) {
			$name = 'Detail Laporan Analisa Laba Kotor '.date('d-m-Y', strtotime($awal)).' - '.date('d-m-Y', strtotime($akhir)).'';
		} else {
			$name = 'Laporan Analisa Laba Kotor '.date('d-m-Y', strtotime($awal)).' - '.date('d-m-Y', strtotime($akhir)).'';
		}
		$select = '*';
		$where['data'][] = array(
			'column' => 'cabang_id',
			'param'	 => $cabang
		);
		$where['data'][] = array(
			'column' => 'faktur_penjualan_tanggal >=',
			'param'	 => date ("Y-m-d H:i:s", strtotime($awal))
		);
		$where['data'][] = array(
			'column' => 'faktur_penjualan_tanggal <=',
			'param'	 => date ("Y-m-d H:i:s", strtotime($akhir))
		);
		$where['data'][] = array(
			'column' => 'faktur_penjualan_status_pembatalan !=',
			'param'	 => 100
		);
		$query = $this->mod->select($select, 'v_laporan_penjualan', NULL, $where);
		$response['val'] = array();
		if ($query<>false) {
			$no = 1;
			foreach ($query->result() as $val) {
				$supplier = ''; $order_ppn = '';
				$totalBeli = 0; $orderdet_harga_satuan = 0;
				$hasil['val2'] = array();
				if(@$join_det['data']) {
					unset($join_det['data']);
				} 
				if(@$where_det['data']) {
					unset($where_det['data']);
				} 
				// CARI DETAIL
				$join_det['data'][] = array(
					'table'	=> 't_po_customer b',
					'join'	=> 'b.po_customer_id = a.t_po_customer_id',
					'type'	=> 'left'
				);
				$join_det['data'][] = array(
					'table'	=> 't_surat_jalandet c',
					'join'	=> 'c.surat_jalandet_id = a.t_surat_jalandet_id',
					'type'	=> 'left'
				);
				$join_det['data'][] = array(
					'table'	=> 't_surat_jalan h',
					'join'	=> 'h.surat_jalan_id = c.t_surat_jalan_id',
					'type'	=> 'left'
				);
				$join_det['data'][] = array(
					'table'	=> 't_po_customerdet d',
					'join'	=> 'd.po_customerdet_id = c.t_po_customerdet_id',
					'type'	=> 'left'
				);
				$join_det['data'][] = array(
					'table'	=> 'm_barang e',
					'join'	=> 'e.barang_id = d.m_barang_id',
					'type'	=> 'left'
				);
				$join_det['data'][] = array(
					'table'	=> 'm_jenis_barang f',
					'join'	=> 'f.jenis_barang_id = e.m_jenis_barang_id',
					'type'	=> 'left'
				);
				$join_det['data'][] = array(
					'table'	=> 'm_satuan g',
					'join'	=> 'g.satuan_id = e.m_satuan_id',
					'type'	=> 'left'
				);
				$where_det['data'][] = array(
					'column' => 'a.t_faktur_penjualan_id',
					'param'	 => $val->faktur_penjualan_id
				);
				$query_det = $this->mod->select('a.*, b.*, c.*, d.*, e.*, f.*, g.*, h.*','t_faktur_penjualandet a', $join_det, $where_det);
				if ($query_det) {
					foreach ($query_det->result() as $val2) {
						$konversi = 1;
						$konversi_jual = 1;
						$satuan_konversi = '';
						$satuan_konversi_jual = '';
						if (@$where_konversi['data']) {
							unset($where_konversi['data']);
						}
						if (@$join_satuan['data']) {
							unset($join_satuan['data']);
						}
						$join_satuan['data'][] = array(
							'table' => 'm_satuan b',
							'join'	=> 'b.satuan_id = a.konversi_akhirsatuan',
							'type'	=> 'left'
						);
						$join_satuan['data'][] = array(
							'table' => 'm_satuan c',
							'join'	=> 'c.satuan_id = a.konversi_akhirsatuan_jual',
							'type'	=> 'left'
						);
						$where_konversi['data'][] = array(
							'column' => 'barang_id',
							'param'	 => $val2->m_barang_id
						);
						$queryKonversi = $this->mod->select('a.*, b.satuan_nama AS satuan_konversi, c.satuan_nama AS satuan_konversi_jual', 'm_konversi a', $join_satuan, $where_konversi);
						if($queryKonversi)
						{
							foreach ($queryKonversi->result() as $val3) {
								$satuan_konversi = $val3->satuan_konversi;
								$satuan_konversi_jual = $val3->satuan_konversi_jual;
								if($val3->konversi_akhir == 0) {
									$konversi = 1;
								} else {
									$konversi = $val3->konversi_akhir;
								}
								if($val3->konversi_akhir_jual == 0) {
									$konversi = 1;
								} else {
									$konversi_jual = $val3->konversi_akhir_jual;
								}
							}
						}

						$DOid = [];
						$DOid = json_decode($val2->t_so_customer_id);
						for($i=0; $i<sizeof($DOid);$i++) {
							if(@$join_do['data']) {
								unset($join_do['data']);
							}
							if(@$where_do['data']) {
								unset($where_do['data']);
							}
							$join_do['data'][] = array(
								'table' => 't_orderdet b',
								'join'  => 'b.orderdet_id = a.t_orderdet_id',
								'type'  => 'left'
							);
							$join_do['data'][] = array(
								'table' => 't_order c',
								'join'  => 'c.order_id = b.t_order_id',
								'type'  => 'left'
							);
							$join_do['data'][] = array(
								'table' => 'm_partner d',
								'join'  => 'd.partner_id = c.m_supplier_id',
								'type'  => 'left'
							);
							$where_do['data'][] = array(
								'column' => 't_so_customer_id',
								'param'	 => $DOid[$i]
							);
							$where_do['data'][] = array(
								'column' => 'b.m_barang_id',
								'param'	 => $val2->m_barang_id
							);
							$query_do = $this->mod->select('*', 't_so_customerdet a', $join_do, $where_do);
							if($query_do) {
								foreach ($query_do->result() as $val3) {
									$totalBeli = $totalBeli + ($val3->so_customerdet_qty_kirim * $konversi * $val3->orderdet_harga_satuan);
									$supplier = $val3->partner_nama;
									$order_ppn = $val3->order_jenis_ppn;
									$orderdet_harga_satuan = $val3->orderdet_harga_satuan;
								}
							}
						}

						
						$hasil['val2'][] = array(
							'po_customer_nomor'				=> $val2->po_customer_nomor,
							'po_customer_tanggal'			=> date('d/m/Y', strtotime($val2->po_customer_tanggal)),
							'po_customer_persentase'		=> $val2->po_customer_persentase,
							'faktur_penjualandet_uraian'	=> $val2->faktur_penjualandet_uraian,
							'faktur_penjualandet_persentase'=> $val2->faktur_penjualandet_persentase,
							'po_customer_total'				=> $val2->po_customer_total,
							'surat_jalandet_qty_kirim'		=> $val2->surat_jalandet_qty_kirim,
							'po_customerdet_harga_satuan'	=> $val2->po_customerdet_harga_satuan,
							'orderdet_harga_satuan'			=> $orderdet_harga_satuan,
							'po_customerdet_keterangan'		=> $val2->po_customerdet_keterangan,
							'barang_kode'					=> $val2->barang_kode,
							'barang_nama'					=> $val2->barang_nama,
							'barang_ukuran'					=> $val2->barang_ukuran,
							'barang_merk'					=> $val2->barang_merk,
							'surat_jalandet_id'				=> $val2->surat_jalandet_id,
							'surat_jalan_id'				=> $val2->surat_jalan_id,
							'surat_jalan_nomor'				=> $val2->surat_jalan_nomor,
							'jenis_barang_nama'				=> $val2->jenis_barang_nama,
							'satuan_nama'					=> $val2->satuan_nama,
							'satuan_konversi'				=> $satuan_konversi,
							'konversi'						=> $konversi,
							'satuan_konversi_jual'			=> $satuan_konversi_jual,
							'konversi_akhir_jual'			=> $konversi_jual,
							'faktur_penjualandet_uraian'	=> $val2->faktur_penjualandet_uraian,
							'po_customer_cetak_merk'		=> $val2->po_customer_cetak_merk,
							'po_customer_jasaangkut_bayar'	=> $val2->po_customer_jasaangkut_bayar,
							'po_customer_ekspedisi'			=> $val2->po_customer_ekspedisi,
							'po_customer_catatan'			=> $val2->po_customer_catatan,
							'supplier'						=> $supplier,
							'order_ppn'						=> $order_ppn,

						);
					}
				}
				// END CARI DETAIL
				if($type == 1) {
					$url = 'manufaktur/print/P_detail_laporan_laba_kotor';
				} else {
					$url = 'manufaktur/print/P_laporan_laba_kotor';
				}
				
				// $supplier = ''; $order_ppn = '';
				// $totalBeli = 0;
				// $status = '';
				// $SJid = [];
				// $SJid = json_decode($val->t_surat_jalan_id);
				// for($j=0; $j < sizeof($SJid); $j++) {
				// 	if(@$where_sj['data']) {
				// 		unset($where_sj['data']);
				// 	}
				// 	$where_sj['data'][] = array(
				// 		'column' => 'surat_jalan_id',
				// 		'param'	 => $SJid[$j]
				// 	);
				// 	$query_sj = $this->mod->select('*', 't_surat_jalan', null, $where_sj);
				// 	if($query_sj) {
				// 		foreach ($query_sj->result() as $val2) {
				// 			$DOid = [];
				// 			$DOid = json_decode($val2->t_so_customer_id);
				// 			for($i=0; $i<sizeof($DOid);$i++) {
				// 				if(@$join_do['data']) {
				// 					unset($join_do['data']);
				// 				}
				// 				if(@$where_do['data']) {
				// 					unset($where_do['data']);
				// 				}
				// 				$join_do['data'][] = array(
				// 					'table' => 't_orderdet b',
				// 					'join'  => 'b.orderdet_id = a.t_orderdet_id',
				// 					'type'  => 'left'
				// 				);
				// 				$join_do['data'][] = array(
				// 					'table' => 't_order c',
				// 					'join'  => 'c.order_id = b.t_order_id',
				// 					'type'  => 'left'
				// 				);
				// 				$join_do['data'][] = array(
				// 					'table' => 'm_partner d',
				// 					'join'  => 'd.partner_id = c.m_supplier_id',
				// 					'type'  => 'left'
				// 				);
				// 				$where_do['data'][] = array(
				// 					'column' => 't_so_customer_id',
				// 					'param'	 => $DOid[$i]
				// 				);
				// 				$query_do = $this->mod->select('*', 't_so_customerdet a', $join_do, $where_do);
				// 				if($query_do) {
				// 					foreach ($query_do->result() as $val2) {
				// 						if($supplier == '') {
				// 							$supplier = $val2->partner_nama;
				// 						}
				// 						// $order_ppn = $val2->order_ppn;
				// 					}
				// 				}
				// 			}
				// 		}
				// 	}
				// }
				$persentase_laba = 0;
				if($val->faktur_penjualan_sub_total == 0) {
					$persentase_laba = 0;
				} else {
					$persentase_laba = ($val->faktur_penjualan_sub_total-$totalBeli)/$val->faktur_penjualan_sub_total*100;
				}
				$response['data'][] = array(
					'no' => $no,
					'faktur_penjualan_nomor' 			=> $val->faktur_penjualan_nomor,
					'faktur_penjualan_tanggal' 			=> date('d/m/Y', strtotime($val->faktur_penjualan_tanggal)),
					'faktur_penjualan_jatuh_tempo' 		=> date('d/m/Y', strtotime($val->faktur_penjualan_jatuh_tempo)),
					'faktur_penjualan_ppn'				=> $val->faktur_penjualan_ppn,
					// 'order_jenis_ppn_nama' 	=> $val->order_jenis_ppn_nama,
					'customer_nama' 					=> $val->customer_nama,
					'faktur_penjualan_sub_total'		=> $val->faktur_penjualan_sub_total,
					'totalBeli'							=> $totalBeli,
					'supplier'							=> $supplier,
					// 'order_ppn'							=> $order_ppn,
					'laba'								=> $val->faktur_penjualan_sub_total-$totalBeli,
					'persentase_laba'					=> $persentase_laba,
					'detail'							=> $hasil,
					// "RP ".number_format($val->nominal_sisa_hutang, 2, '.', ','),
					// $button
				);
				$no++;
			}
		}
		$response['from_tanggal'] = date('d-m-Y', strtotime($awal));
		$response['to_tanggal'] = date('d-m-Y', strtotime($akhir));
		$response['title'][] = array(
			'aplikasi'		=> $this->app_name,
			'title_page' 	=> 'Laporan',
			'title_page2' 	=> 'Laporan Penjualan',
		);
				
		// CARI CABANG
		$hasil1['val2'] = array();
		$where_cabang['data'][] = array(
			'column' => 'cabang_id',
			'param'	 => $cabang
		);
		$query_cabang = $this->mod->select('*','m_cabang',NULL,$where_cabang);
		if ($query_cabang) {
			foreach ($query_cabang->result() as $val2) {
				// CARI KOTA
				$hasil2['val2'] = array();
				$where_kota['data'][] = array(
					'column' => 'id',
					'param'	 => $val2->cabang_kota
				);
				$query_kota = $this->mod->select('*','regencies',NULL,$where_kota);
				if ($query_kota) {
					foreach ($query_kota->result() as $val3) {
						$hasil2['val3'][] = array(
							'id' 		=> $val3->id,
							'text' 		=> $val3->name,
						);
					}
				}
				// END CARI KOTA
				$hasil1['val2'][] = array(
					'id' 			=> $val2->cabang_id,
					'text' 			=> $val2->cabang_nama,
					'alamat'		=> $val2->cabang_alamat,
					'kota'			=> $hasil2,
					'telp'  		=> json_decode($val2->cabang_telepon),
					'kodeppn'		=> $val2->cabang_kode_ppn,
					'kodenonppn'	=> $val2->cabang_kode_non_ppn,
				);
			}
		}
		$response['val'][] = array(
			'cabang'				=> $hasil1,
			'periode_awal'			=> date ("d/m/Y", strtotime($awal)),
			'periode_akhir'			=> date ("d/m/Y", strtotime($akhir))
		);
		// END CARI CABANG
		// echo json_encode($response);
		if($type == 1) {
			$this->pdf->set_paper('A4', 'landscape');
		} else {
			$this->pdf->set_paper('A4', 'portrait');
		}
		$this->pdf->load_view($url, $response);
		$this->pdf->render();
		$this->pdf->stream($name,array("Attachment"=>false));
		// $this->load->view($url, $response);
	}

}
