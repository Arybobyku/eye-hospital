export const parsefaktur = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('supplier_id', form.select.supplier.value);
	data.append('supplier_uuid', form.select.supplier.value);
	data.append('nama_supplier', form.select.supplier.label);
	data.append('ppn', form.ppn.value);
	data.append('no_faktur', form.nofaktur.value);
	data.append('tanggal_faktur', form.tanggalfaktur.value);
	data.append('pembayaran', form.select.pembayaran.value);
	data.append('jangka_waktu', form.jangkawaktu.value);
	data.append('keterangan', form.keterangan.value);
	return data;
}

export const parseobat = (form) => {
	let data = new FormData();
	data.append('no_faktur', form.detailfaktur.no_faktur);
	data.append('dataobat', JSON.stringify(form.listdata));
	return data;
}
