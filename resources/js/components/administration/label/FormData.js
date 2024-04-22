export const formlabel = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		based: { 
			title: 'Group', for_id: 'form_'+'based', type: 'text', required: 'required', 
			name: 'based', value: '', disabled: false, show: true, kinds: ''
		},
		icon: { 
			title: 'Icon', for_id: 'form_'+'icon', type: 'text', required: 'required', 
			name: 'icon', value: '', disabled: false, show: true, kinds: ''
		},
		link: { 
			title: 'Link', for_id: 'form_'+'link', type: 'text', required: 'required', 
			name: 'link', value: '', disabled: false, show: true, kinds: ''
		},
		posisilabel: { 
			title: 'Posisi ke', for_id: 'form_'+'posisilabel', type: 'number', required: 'required', 
			name: 'posisilabel', value: '', disabled: false, show: true, kinds: ''
		},
	}
}