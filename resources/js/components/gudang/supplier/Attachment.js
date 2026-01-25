export const parsesupplier = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	data.append('alamat', form.alamat.value);
	data.append('kontak', form.kontak.value);
	return data;
}
