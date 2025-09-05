
export const initindexdb = (dbName, tableName) => {
	console.log(tableName)
	if (tableName == 'satuanbesar' || tableName == 'satuankecil') { tableName = 'satuan'; }

	if (tableName == 'satuankomposisi') { tableName = 'satuan'; }
	
	if (tableName == 'satuandiperlukan') { tableName = 'satuan'; }

	if (tableName == 'paketbedahbedah') { tableName = 'paketbedah'; }

	if (tableName == 'carabayarbedah') { tableName = 'carabayar'; }
	if (tableName == 'carabayarreg') { tableName = 'carabayar'; }

	if (tableName == 'asuransibedah') { tableName = 'asuransi'; }
	if (tableName == 'asuransireg') { tableName = 'asuransi'; }

	if (tableName == 'kamarinapjalan') { tableName = 'kamarinap'; }

	if (tableName == 'carabayartindakanrawatjalanjalan') { tableName = 'carabayartindakanrawatjalan'; }

	if (tableName == 'supplierretur') { tableName = 'supplier'; }
	if (tableName == 'dokterreg') { tableName = 'dokter'; }
	if (tableName == 'obat2') { tableName = 'obat'; }
	if (tableName == 'obat3') { tableName = 'obat'; }
	if (tableName == 'obat4') { tableName = 'obat'; }

	console.log("table", tableName)
	return new Promise(function (resolve, reject) {
    var open = window.indexedDB.open(dbName, window.localStorage.getItem("version"));
    open.onsuccess = function() {
      var db = open.result;
      var transaction = db.transaction([tableName], "readwrite");
      var store = transaction.objectStore(tableName);
      var request = store.getAll();
      request.onsuccess = function(event){ resolve(event.target.result); };
      request.onerror = function(event) { reject(event) }
      // Close the db when the transaction is done
      transaction.oncomplete = function() { db.close(); };
      transaction.onerror = function(event) { reject(event) }
    };
    open.onerror = function(event) { reject(event) }
  });
}

export const indexdbprocessing = (data, form, key) => {
	for (let i = 0; i < data.length; i++) {
		if (key == 'kabkota' && form.select.provinsi.value != '') {
			if (data[i].provinsi_id == form.select.provinsi.value) {
				form.select[key].filter.push(data[i]);
			}
		}
		else if (key == 'kecamatan' && form.select.kabkota.value != '') {
			if (data[i].kab_kota_id == form.select.kabkota.value){
				form.select[key].filter.push(data[i]);
			}
		}
		else if (key == 'kelurahan' && form.select.kecamatan.value != '') {
			if (data[i].kecamatan_id == form.select.kecamatan.value){
				form.select[key].filter.push(data[i]);
			}
		}
		else if (key == 'provinsi') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'satuanbesar') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'satuankecil') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'satuankomposisi') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'satuandiperlukan') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'obat') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'obat2') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'obat3') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'obat4') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'supplier') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'obatgudang') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'carabayar') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'asuransi') {
			if (data[i].carabayar_uuid == form.select.carabayar.value){
				form.select[key].filter.push(data[i]);
			}
		}
		else if (key == 'carabayarbedah') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'asuransibedah') {
			if (data[i].carabayar_uuid == form.select.carabayarbedah.value){
				form.select[key].filter.push(data[i]);
			}
		}
		else if (key == 'carabayarreg') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'asuransireg') {
			if (data[i].carabayar_uuid == form.select.carabayarreg.value){
				form.select[key].filter.push(data[i]);
			}
		}
		else if (key == 'dokter') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'dokterreg') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'dokterumum') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'jeniskamar') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'carabayartindakanrawatjalan') {
			if (data[i].carabayar_nama == form.carabayar_nama){
				form.select[key].filter.push(data[i]);
			}
		}
		else if (key == 'carabayartindakanrawatjalanjalan') {
			if (data[i].carabayar_nama == form.carabayar_nama){
				form.select[key].filter.push(data[i]);
			}
		}
		else if (key == 'tindakanrawatjalan') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'icd9') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'icd10') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'tindakannonbedah') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'apotek') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'apotekracikan') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'paketbedah') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'paketbedahbedah') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'tindakanbedah') {
			if (data[i].jenis == form.select.jenis.value){
				form.select[key].filter.push(data[i]);
			}
		}
		else if (key == 'kamarinap') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'kamarinapjalan') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'hargagudang') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'supplierretur') {
			form.select[key].filter.push(data[i]);
		}
		else if (key == 'alltindakan') {
			form.select[key].filter.push(data[i]);
		}
	}

	form.select[key].data = form.select[key].filter;
	
	return form;
}

export const createdb = (dbName, version, response) => {
	return new Promise(function (resolve, reject) {
		const tmp_ = window.indexedDB.open(dbName, version);
		tmp_.onupgradeneeded = (event) => {
			let db = tmp_.result;
			
			if (response.data.apotek.length > 0) {
				let apotek = db.createObjectStore('apotek', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.apotek;
				while (i < data.length) { apotek.put(apotekfunction(data, i)); i++; }
			}

			if (response.data.hargagudang.length > 0) {
				let hargagudang = db.createObjectStore('hargagudang', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.hargagudang;
				while (i < data.length) { hargagudang.put(hargagudangfunction(data, i)); i++; }
			}

			if (response.data.apotekracikan.length > 0) {
				let apotekracikan = db.createObjectStore('apotekracikan', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.apotekracikan;
				while (i < data.length) { apotekracikan.put(apotekracikanfunction(data, i)); i++; }
			}

			if (response.data.kamarinap.length > 0) {
				let kamarinap = db.createObjectStore('kamarinap', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.kamarinap;
				while (i < data.length) { kamarinap.put(kamarinapfunction(data, i)); i++; }
			}

			if (response.data.alltindakan.length > 0) {
				let alltindakan = db.createObjectStore('alltindakan', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.alltindakan;
				while (i < data.length) { alltindakan.put(alltindakanfunction(data, i)); i++; }
			}

			if (response.data.obat.length > 0) {
				let obat = db.createObjectStore('obat', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.obat;
				while (i < data.length) { obat.put(obatfunction(data, i)); i++; }
			}
			if (response.data.obat2.length > 0) {
				let obat2 = db.createObjectStore('obat', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.obat;
				while (i < data.length) { obat2.put(obat2function(data, i)); i++; }
			}
			if (response.data.obat3.length > 0) {
				let obat3 = db.createObjectStore('obat3', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.obat3;
				while (i < data.length) { obat3.put(obat3function(data, i)); i++; }
			}

			if (response.data.obat4.length > 0) {
				let obat4 = db.createObjectStore('obat4', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.obat4;
				while (i < data.length) { obat4.put(obat4function(data, i)); i++; }
			}

			if (response.data.obatgudang.length > 0) {
				let obatgudang = db.createObjectStore('obatgudang', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.obatgudang;
				while (i < data.length) { obatgudang.put(obatgudangfunction(data, i)); i++; }
			}

			if (response.data.dokter.length > 0) {
				let dokter = db.createObjectStore('dokter', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.dokter;
				while (i < data.length) { dokter.put(dokterfunction(data, i)); i++; }
			}

			if (response.data.dokterumum.length > 0) {
				let dokterumum = db.createObjectStore('dokterumum', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.dokterumum;
				while (i < data.length) { dokterumum.put(dokterumumfunction(data, i)); i++; }
			}

			if (response.data.icd9.length > 0) {
				let icd9 = db.createObjectStore('icd9', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.icd9;
				while (i < data.length) { icd9.put(icd9function(data, i)); i++; }
			}

			if (response.data.icd10.length > 0) {
				let icd10 = db.createObjectStore('icd10', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.icd10;
				while (i < data.length) { icd10.put(icd10function(data, i)); i++; }
			}

			if (response.data.supplier.length > 0) {
				let supplier = db.createObjectStore('supplier', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.supplier;
				while (i < data.length) { supplier.put(supplierfunction(data, i)); i++; }
			}

			if (response.data.satuan.length > 0) {
				let satuan = db.createObjectStore('satuan', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.satuan;
				while (i < data.length) { satuan.put(satuanfunction(data, i)); i++; }
			}

			if (response.data.ruangans.length > 0) {
				let ruangans = db.createObjectStore('ruangans', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.ruangans;
				while (i < data.length) { ruangans.put(ruangansfunction(data, i)); i++; }
			}

			if (response.data.carabayar.length > 0) {
				let carabayar = db.createObjectStore('carabayar', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.carabayar;
				while (i < data.length) { carabayar.put(carabayarfunction(data, i)); i++; }
			}

			if (response.data.asuransi.length > 0) {
				let asuransi = db.createObjectStore('asuransi', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.asuransi;
				while (i < data.length) { asuransi.put(asuransifunction(data, i)); i++; }
			}

			if (response.data.layanan.length > 0) {
				let layanan = db.createObjectStore('layanan', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.layanan;
				while (i < data.length) { layanan.put(layananfunction(data, i)); i++; }
			}

			if (response.data.tarif.length > 0) {
				let tarif = db.createObjectStore('tarif', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.tarif;
				while (i < data.length) { tarif.put(tariffunction(data, i)); i++; }
			}

			if (response.data.provinsi.length > 0) {
				let provinsi = db.createObjectStore('provinsi', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.provinsi;
				while (i < data.length) { provinsi.put(provinsifunction(data, i)); i++; }
			}

			if (response.data.kabkota.length > 0) {
				let kabkota = db.createObjectStore('kabkota', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.kabkota;
				while (i < data.length) { kabkota.put(kabkotafunction(data, i)); i++; }
			}

			if (response.data.kecamatan.length > 0) {
				let kecamatan = db.createObjectStore('kecamatan', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.kecamatan;
				while (i < data.length) { kecamatan.put(kecamatanfunction(data, i)); i++; }
			}

			if (response.data.kelurahan.length > 0) {
				let kelurahan = db.createObjectStore('kelurahan', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.kelurahan;
				while (i < data.length) { kelurahan.put(kelurahanfunction(data, i)); i++; }
			}

			if (response.data.jeniskamar.length > 0) {
				let jeniskamar = db.createObjectStore('jeniskamar', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.jeniskamar;
				while (i < data.length) { jeniskamar.put(jeniskamarfunction(data, i)); i++; }
			}

			if (response.data.paketbedah.length > 0) {
				let paketbedah = db.createObjectStore('paketbedah', { keyPath: "sid", autoIncrement: true });
				let i = 0, data = response.data.paketbedah;
				console.log(data, 'ini aku yah')
				while (i < data.length) { paketbedah.put(paketbedahfunction(data, i)); i++; }
			}

			if (response.data.carabayartindakanrawatjalan.length > 0) {
				let carabayartindakanrawatjalan = db.createObjectStore('carabayartindakanrawatjalan', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.carabayartindakanrawatjalan;
				while (i < data.length) { carabayartindakanrawatjalan.put(carabayartindakanrawatjalanfunction(data, i)); i++; }
			}

			if (response.data.tindakanrawatjalan.length > 0) {
				let tindakanrawatjalan = db.createObjectStore('tindakanrawatjalan', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.tindakanrawatjalan;
				while (i < data.length) { tindakanrawatjalan.put(tindakanrawatjalanfunction(data, i)); i++; }
			}

			if (response.data.carabayartindakannonbedah.length > 0) {
				let carabayartindakannonbedah = db.createObjectStore('carabayartindakannonbedah', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.carabayartindakannonbedah;
				while (i < data.length) { carabayartindakannonbedah.put(carabayartindakannonbedahfunction(data, i)); i++; }
			}

			if (response.data.tindakannonbedah.length > 0) {
				let tindakannonbedah = db.createObjectStore('tindakannonbedah', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.tindakannonbedah;
				while (i < data.length) { tindakannonbedah.put(tindakannonbedahfunction(data, i)); i++; }
			}

			if (response.data.tindakanbedah.length > 0) {
				let tindakanbedah = db.createObjectStore('tindakanbedah', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.tindakanbedah;
				while (i < data.length) { tindakanbedah.put(tindakanbedahfunction(data, i)); i++; }
			}
			
		};
		tmp_.onerror = function(event) { tmp_.result.close(); reject(event) }
		tmp_.onsuccess = function () { tmp_.result.close(); resolve('berhasil'); };
		tmp_.onblocked = function (event) { tmp_.result.close(); reject(event)  };
	});
}

export const updatedbdokter = (dbName, version, response) => {
	console.log(response)
	return new Promise(function (resolve, reject) {
		const tmp_ = window.indexedDB.open(dbName, version);
		tmp_.onupgradeneeded = (event) => {
			let db = tmp_.result;
			if (response.data.apotek.length > 0) {
				let apotek = db.createObjectStore('apotek', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.apotek;
				while (i < data.length) { apotek.put(apotekfunction(data, i)); i++; }
			}

			if (response.data.apotekracikan.length > 0) {
				let apotekracikan = db.createObjectStore('apotekracikan', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.apotekracikan;
				while (i < data.length) { apotekracikan.put(apotekracikanfunction(data, i)); i++; }
			}

			if (response.data.carabayar.length > 0) {
				let carabayar = db.createObjectStore('carabayar', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.carabayar;
				while (i < data.length) { carabayar.put(carabayarfunction(data, i)); i++; }
			}

			if (response.data.asuransi.length > 0) {
				let asuransi = db.createObjectStore('asuransi', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.asuransi;
				while (i < data.length) { asuransi.put(asuransifunction(data, i)); i++; }
			}

			if (response.data.paketbedah.length > 0) {
				let paketbedah = db.createObjectStore('paketbedah', { keyPath: "sid", autoIncrement: true });
				let i = 0, data = response.data.paketbedah;
				
				while (i < data.length) { paketbedah.put(paketbedahfunction(data, i)); i++; }
			}

			if (response.data.carabayartindakanrawatjalan.length > 0) {
				let carabayartindakanrawatjalan = db.createObjectStore('carabayartindakanrawatjalan', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.carabayartindakanrawatjalan;
				while (i < data.length) { carabayartindakanrawatjalan.put(carabayartindakanrawatjalanfunction(data, i)); i++; }
			}

			if (response.data.tindakanrawatjalan.length > 0) {
				let tindakanrawatjalan = db.createObjectStore('tindakanrawatjalan', { keyPath: "id", autoIncrement: true });
				let i = 0, data = response.data.tindakanrawatjalan;
				while (i < data.length) { tindakanrawatjalan.put(tindakanrawatjalanfunction(data, i)); i++; }
			}
		};
		tmp_.onerror = function(event) { tmp_.result.close(); reject(event) }
		tmp_.onsuccess = function () { tmp_.result.close(); resolve('berhasil'); };
		tmp_.onblocked = function (event) { tmp_.result.close(); reject(event)  };
	});
}

const apotekfunction = (data, i) => {
	return {
		value: data[i].obat_uuid,
		label: data[i].nama,

		harga_obat_id: data[i].harga_obat_id,
		obat_uuid: data[i].obat_uuid,
		nama: data[i].nama,
		satuan_uuid_besar: data[i].satuan_uuid_besar,
		nama_satuan_besar: data[i].nama_satuan_besar,
		satuan_uuid_kecil: data[i].satuan_uuid_kecil,
		nama_satuan_kecil: data[i].nama_satuan_kecil,
		hitung_besar: data[i].hitung_besar,
		hitung_kecil: data[i].hitung_kecil,
		kategori: data[i].kategori,
		formularium: data[i].formularium,
		golongan: data[i].golongan,
		jenis: data[i].jenis,
		harga_netto: data[i].harga_netto,
		harga_netto_discount: data[i].harga_netto_discount,
		harga_netto_ppn: data[i].harga_netto_ppn,
		hpp: data[i].hpp,
		margin_resep: data[i].margin_resep,
		margin_non_resep: data[i].margin_non_resep,
		hja_resep: data[i].hja_resep,
		hja_non_resep: data[i].hja_non_resep,
		hja_resep_besar: data[i].hja_resep_besar,
		hja_non_resep_besar: data[i].hja_non_resep_besar,
		min_stock: data[i].min_stock,
		jumlah_kecil: data[i].jumlah_kecil,
		jumlah_besar: data[i].jumlah_besar
	}
}

const hargagudangfunction = (data, i) => {
	return {
		value: data[i].obat_uuid,
		label: data[i].nama,

		harga_obat_id: data[i].harga_obat_id,
		obat_uuid: data[i].obat_uuid,
		nama: data[i].nama,
		satuan_uuid_besar: data[i].satuan_uuid_besar,
		nama_satuan_besar: data[i].nama_satuan_besar,
		satuan_uuid_kecil: data[i].satuan_uuid_kecil,
		nama_satuan_kecil: data[i].nama_satuan_kecil,
		hitung_besar: data[i].hitung_besar,
		hitung_kecil: data[i].hitung_kecil,
		kategori: data[i].kategori,
		formularium: data[i].formularium,
		golongan: data[i].golongan,
		jenis: data[i].jenis,
		harga_netto: data[i].harga_netto,
		harga_netto_discount: data[i].harga_netto_discount,
		harga_netto_ppn: data[i].harga_netto_ppn,
		hpp: data[i].hpp,
		margin_resep: data[i].margin_resep,
		margin_non_resep: data[i].margin_non_resep,
		hja_resep: data[i].hja_resep,
		hja_non_resep: data[i].hja_non_resep,
		hja_resep_besar: data[i].hja_resep_besar,
		hja_non_resep_besar: data[i].hja_non_resep_besar,
		min_stock: data[i].min_stock,
		jumlah_kecil: data[i].jumlah_kecil,
		jumlah_besar: data[i].jumlah_besar
	}
}

const apotekracikanfunction = (data, i) => {
	return {
		value: data[i].obat_uuid,
		label: data[i].nama + ' - ' + data[i].nama_satuan_kecil,

		harga_obat_id: data[i].harga_obat_id,
		obat_uuid: data[i].obat_uuid,
		nama: data[i].nama,
		satuan_uuid_besar: data[i].satuan_uuid_besar,
		nama_satuan_besar: data[i].nama_satuan_besar,
		satuan_uuid_kecil: data[i].satuan_uuid_kecil,
		nama_satuan_kecil: data[i].nama_satuan_kecil,
		hitung_besar: data[i].hitung_besar,
		hitung_kecil: data[i].hitung_kecil,
		kategori: data[i].kategori,
		formularium: data[i].formularium,
		golongan: data[i].golongan,
		jenis: data[i].jenis,
		harga_netto: data[i].harga_netto,
		harga_netto_discount: data[i].harga_netto_discount,
		harga_netto_ppn: data[i].harga_netto_ppn,
		hpp: data[i].hpp,
		margin_resep: data[i].margin_resep,
		margin_non_resep: data[i].margin_non_resep,
		hja_resep: data[i].hja_resep,
		hja_non_resep: data[i].hja_non_resep,
		hja_resep_besar: data[i].hja_resep_besar,
		hja_non_resep_besar: data[i].hja_non_resep_besar,
		min_stock: data[i].min_stock,
		jumlah_kecil: data[i].jumlah_kecil,
		jumlah_besar: data[i].jumlah_besar
	}
}

const kamarinapfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama_jenis_kamar + ' - ' + data[i].nama,

		uuid: data[i].uuid,
		nama: data[i].nama,
		lantai: data[i].lantai,
		jumlah_bed: data[i].jumlah_bed,
		jenis_kamar_uuid: data[i].jenis_kamar_uuid,
		nama_jenis_kamar: data[i].nama_jenis_kamar
		
	}
}

const alltindakanfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		uuid: data[i].uuid,
		nama: data[i].nama
		
	}
}

const obatfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama,
		keterangan: data[i].keterangan,
		satuan_uuid_besar: data[i].satuan_uuid_besar,
		nama_satuan_besar: data[i].nama_satuan_besar,
		satuan_uuid_kecil: data[i].satuan_uuid_kecil,
		nama_satuan_kecil: data[i].nama_satuan_kecil,
		hitung_besar: data[i].hitung_besar,
		hitung_kecil: data[i].hitung_kecil,
		kategori:data[i].kategori,
		formularium: data[i].formularium,
		golongan: data[i].golongan,
		jenis: data[i].jenis,
		min_stock: data[i].min_stock
	}
}
const obat2function = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama,
		keterangan: data[i].keterangan,
		satuan_uuid_besar: data[i].satuan_uuid_besar,
		nama_satuan_besar: data[i].nama_satuan_besar,
		satuan_uuid_kecil: data[i].satuan_uuid_kecil,
		nama_satuan_kecil: data[i].nama_satuan_kecil,
		hitung_besar: data[i].hitung_besar,
		hitung_kecil: data[i].hitung_kecil,
		kategori:data[i].kategori,
		formularium: data[i].formularium,
		golongan: data[i].golongan,
		jenis: data[i].jenis,
		min_stock: data[i].min_stock
	}
}
const obat3function = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama,
		keterangan: data[i].keterangan,
		satuan_uuid_besar: data[i].satuan_uuid_besar,
		nama_satuan_besar: data[i].nama_satuan_besar,
		satuan_uuid_kecil: data[i].satuan_uuid_kecil,
		nama_satuan_kecil: data[i].nama_satuan_kecil,
		hitung_besar: data[i].hitung_besar,
		hitung_kecil: data[i].hitung_kecil,
		kategori:data[i].kategori,
		formularium: data[i].formularium,
		golongan: data[i].golongan,
		jenis: data[i].jenis,
		min_stock: data[i].min_stock
	}
}

const obat4function = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama,
		keterangan: data[i].keterangan,
		satuan_uuid_besar: data[i].satuan_uuid_besar,
		nama_satuan_besar: data[i].nama_satuan_besar,
		satuan_uuid_kecil: data[i].satuan_uuid_kecil,
		nama_satuan_kecil: data[i].nama_satuan_kecil,
		hitung_besar: data[i].hitung_besar,
		hitung_kecil: data[i].hitung_kecil,
		kategori:data[i].kategori,
		formularium: data[i].formularium,
		golongan: data[i].golongan,
		jenis: data[i].jenis,
		min_stock: data[i].min_stock
	}
}
const obatgudangfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		obat_id: data[i].obat_id,
		obat_uuid: data[i].obat_uuid,
		nama: data[i].nama,
		kategori:data[i].kategori,
		formularium: data[i].formularium,
		golongan: data[i].golongan,
		jenis: data[i].jenis,
		keterangan: data[i].keterangan,
		satuan_uuid_besar: data[i].satuan_uuid_besar,
		nama_satuan_besar: data[i].nama_satuan_besar,
		satuan_uuid_kecil: data[i].satuan_uuid_kecil,
		nama_satuan_kecil: data[i].nama_satuan_kecil,
		hitung_besar: data[i].hitung_besar,
		hitung_kecil: data[i].hitung_kecil,
		jumlah_kecil: data[i].jumlah_kecil,
		jumlah_besar: data[i].jumlah_besar,
		unit_id: data[i].unit_id,
		unit_uuid: data[i].unit_uuid,
		nama_unit: data[i].nama_unit,
	}
}

const dokterfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama_pengguna,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama_pengguna
	}
}

const dokterumumfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama_pengguna,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama_pengguna
	}
}

const jeniskamarfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama
	}
}

const paketbedahfunction = (data, i) => {
	console.log(data[i], 'Kyaraku', i)
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama,
		total: data[i].total,
	}
}

const icd9function = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		kode: data[i].kode,
		nama: data[i].nama
	}
}

const icd10function = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		kode: data[i].kode,
		nama: data[i].nama
	}
}

const supplierfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama,
		alamat: data[i].alamat,
		kontak: data[i].kontak,
	}
}

const satuanfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama,
		alamat: data[i].keterangan
	}
}

const ruangansfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama,
		tipe: data[i].tipe,
		jenis: data[i].jenis,
		lantai: data[i].lantai,
		jumlah_bed: data[i].jumlah_bed,
		alamat: data[i].keterangan
	}
}

const carabayarfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		kode: data[i].kode,
		nama: data[i].nama
	}
}

const asuransifunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		carabayar_uuid: data[i].carabayar_uuid,
		carabayar_kode: data[i].carabayar_kode,
		carabayar_nama: data[i].carabayar_nama,
		kode: data[i].kode,
		nama: data[i].nama
	}
}

const layananfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		kategori: data[i].kategori,
		nama: data[i].nama
	}
}

const tariffunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].layanan_nama,

		id: data[i].id,
		uuid: data[i].uuid,
		carabayar_uuid: data[i].carabayar_uuid,
		carabayar_nama: data[i].carabayar_nama,
		layanan_uuid: data[i].layanan_uuid,
		layanan_kategori: data[i].layanan_kategori,
		layanan_nama: data[i].layanan_nama,
		harga: data[i].harga,
	}
}

const provinsifunction = (data, i) => {
	return {
		value: data[i].id,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama
	}
}

const kabkotafunction = (data, i) => {
	return {
		value: data[i].id,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama,
		provinsi_id: data[i].provinsi_id,
		nama_provinsi: data[i].nama_provinsi,
	}
}

const kecamatanfunction = (data, i) => {
	return {
		value: data[i].id,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama,
		kab_kota_id: data[i].kab_kota_id,
		nama_kab_kota: data[i].nama_kab_kota,
	}
}

const kelurahanfunction = (data, i) => {
	return {
		value: data[i].id,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama,
		kecamatan_id: data[i].kecamatan_id,
		nama_kecamatan: data[i].nama_kecamatan,
	}
}

const tindakanrawatjalanfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama
	}
}

const carabayartindakanrawatjalanfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama_tindakan_rawat_jalan,

		id: data[i].id,
		uuid: data[i].uuid,
		carabayar_uuid: data[i].carabayar_uuid,
		carabayar_nama: data[i].carabayar_nama,
		tindakan_rawat_jalan_uuid: data[i].tindakan_rawat_jalan_uuid,
		nama_tindakan_rawat_jalan: data[i].nama_tindakan_rawat_jalan,
		harga: data[i].harga,
		default: data[i].default,
	}
}

const carabayartindakannonbedahfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama_tindakan_rawat_jalan,

		id: data[i].id,
		uuid: data[i].uuid,
		carabayar_uuid: data[i].carabayar_uuid,
		carabayar_nama: data[i].carabayar_nama,
		tindakan_rawat_jalan_uuid: data[i].tindakan_rawat_jalan_uuid,
		nama_tindakan_rawat_jalan: data[i].nama_tindakan_rawat_jalan,
		harga: data[i].harga,
		default: data[i].default,
	}
}

const tindakannonbedahfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama,
	}
}

const tindakanbedahfunction = (data, i) => {
	return {
		value: data[i].uuid,
		label: data[i].nama,

		id: data[i].id,
		uuid: data[i].uuid,
		nama: data[i].nama,
		jenis: data[i].jenis,
	}
}