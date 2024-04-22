export const parseretur = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('supplier_uuid', form.select.supplier.value);
	data.append('nama_supplier', form.select.supplier.label);
	data.append('tanggal_retur', form.tanggalretur.value);
	data.append('keterangan', form.keterangan.value);
	return data;
}

export const parseobat = (form) => {
	let data = new FormData();
	data.append('kode_retur', form.detailretur.kode_retur);
	data.append('dataobat', JSON.stringify(form.listdata));
	return data;
}