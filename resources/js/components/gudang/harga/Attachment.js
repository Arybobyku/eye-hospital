export const parseharga = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('obat_uuid', form.detailobat.uuid);
	data.append('obat_id', form.detailobat.id);
	data.append('nama', form.detailobat.nama)
	data.append('satuan_uuid_besar', form.detailobat.satuan_uuid_besar);
	data.append('satuan_uuid_besar', form.detailobat.satuan_uuid_besar);
	data.append('nama_satuan_besar', form.detailobat.nama_satuan_besar);
	data.append('satuan_uuid_kecil', form.detailobat.satuan_uuid_kecil);
	data.append('nama_satuan_kecil', form.detailobat.nama_satuan_kecil);
	data.append('hitung_besar', form.detailobat.hitung_besar);
	data.append('hitung_kecil', form.detailobat.hitung_kecil);
	data.append('kategori', form.detailobat.kategori);
	data.append('formularium', form.detailobat.formularium);
	data.append('golongan', form.detailobat.golongan);

	data.append('harga_netto', form.harganetto.value);
	data.append('harga_netto_discount', form.harganettodiscount.value);
	data.append('harga_netto_ppn', form.harganettoppn.value);
	data.append('hpp', form.hpp.value);
	data.append('margin_resep', form.marginresep.value);
	data.append('margin_non_resep', form.marginnonresep.value);
	data.append('hja_resep', form.hjaresep.value);
	data.append('hja_resep_besar', form.hjaresepbesar.value);
	data.append('hja_non_resep', form.hjanonresep.value);
	data.append('hja_non_resep_besar', form.hjanonresepbesar.value);
	data.append('keterangan', form.keterangan.value);

	
	return data;
}
