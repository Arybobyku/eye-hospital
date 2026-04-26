export const filterselected = (form, key) => {
	var filter = "label";
	var keyword = form.select[key].search;
	if (keyword.trim() != '') { keyword = keyword.toLowerCase(); }
	
	form.select[key].filter = form.select[key].data.filter(function(obj) {
		return obj[filter].toLowerCase().includes(keyword);
	});

	let data = [];
	for (let i = 0; i < form.select[key].filter.length; i++) {
		for (let j = 0; j < data.length; j++) {
			if (data[j].label == form.select[key].filter[i].label){ break; }

			if (j == (data.length - 1)) { data.push(form.select[key].filter[i]); }
		}
		if (data.length < 1) {
			data.push(form.select[key].filter[i]);
		}
	}
	form.select[key].filter = data;
	return form;
}

export const hideselected = (form) => {
	for (const key in form.select) { 
		form.select[key].option = 'display: none';
		form.select[key].filter = form.select[key].data;
		form.select[key].search = '';
	} 
	return form;
}

export const itemselected = (form, item, key) => {
	form.select[key].value = item.value;
	form.select[key].uuid = item.uuid;
	form.select[key].label = item.label;
	form.select[key].option = 'display: none';
	form.select[key].filter = form.select[key].data;
	form.select[key].search = '';
	return form;
}
export const itemselectedNonUuid = (form, item, key) => {
	form.select[key].value = item.label;
	form.select[key].uuid = item.label;
	form.select[key].label = item.label;
	form.select[key].option = 'display: none';
	form.select[key].filter = form.select[key].data;
	form.select[key].search = '';
	return form;
}

export const clearselected = (form, key) => {
	form.select[key].option = 'display: none';
	form.select[key].filter = form.select[key].data;
	form.select[key].search = '';
	form.select[key].value = ''; 
	form.select[key].label = 'Silahkan Pilih'; 
	return form;
}

export const boxselected = (event, form, key) => {
	let position = '';
	if (form.select[key].disabled) { position = 'stop'; }
	if (event.target.className != ("hospitals select-close select-close-" + key)) {
		if (event.target.className != 'hospitals select-search') {
			if (form.select[key].option == 'display: block') {
				form.select[key].option = 'display: none';
				form.select[key].filter = form.select[key].data;
				form.select[key].search = '';
				position = 'nextstop';
			}
			else { position = 'nextstart'; }
		}
	}
	return { _position: position, _form: form };
}

export const conditionselected = (form, item, key, position) => {
	
	if (key == 'provinsi') {
		if (form.select.provinsi.value != item.value) {
			form.select.kabkota.data = [];
			form.select.kabkota.filter = [];
			form.select.kabkota.search = [];
			form.select.kabkota.value = '';
			form.select.kabkota.label = 'Silahkan Pilih';

			form.select.kecamatan.data = [];
			form.select.kecamatan.filter = [];
			form.select.kecamatan.search = [];
			form.select.kecamatan.value = '';
			form.select.kecamatan.label = 'Silahkan Pilih';

			form.select.kelurahan.data = [];
			form.select.kelurahan.filter = [];
			form.select.kelurahan.search = [];
			form.select.kelurahan.value = '';
			form.select.kelurahan.label = 'Silahkan Pilih';
		}
	}
	else if (key == 'kabkota') {
		if (form.select.kabkota.value != item.value) {
			form.select.kecamatan.data = [];
			form.select.kecamatan.filter = [];
			form.select.kecamatan.search = [];
			form.select.kecamatan.value = '';
			form.select.kecamatan.label = 'Silahkan Pilih';

			form.select.kelurahan.data = [];
			form.select.kelurahan.filter = [];
			form.select.kelurahan.search = [];
			form.select.kelurahan.value = '';
			form.select.kelurahan.label = 'Silahkan Pilih';
		}
	}
	else if (key == 'kecamatan') {
		if (form.select.kecamatan.value != item.value) {
			form.select.kelurahan.data = [];
			form.select.kelurahan.filter = [];
			form.select.kelurahan.search = [];
			form.select.kelurahan.value = '';
			form.select.kelurahan.label = 'Silahkan Pilih';
		}
	}
	return form;
}