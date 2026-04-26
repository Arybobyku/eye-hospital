export const parseunit = (form) => {
	let data = new FormData();
	data.append('dari', form.dari);
	data.append('ke', form.ke);
	data.append('posisi', form.posisi);
	data.append('kwitansi_claim', form.kwitansi.value);
	data.append('claim_additional', form.claimadditional.value);
	return data;
}
