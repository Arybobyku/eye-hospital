export const datename = (tanggal, istimes = false) => {
	let tmp = tanggal.split(" "), 
			dates = tmp[0].split('-');
	if (tmp.length > 1) {
		let times = tmp[1].split(':');
		if (istimes) { return dates[2] + ' ' + monthname(dates[1]) + ' ' + dates[0] + ' <strong>' + times[0] + ':' + times[1] + '</strong>'; }
		return dates[2] + ' ' + monthname(dates[1]) + ' ' + dates[0];
	}
	return dates[2] + ' ' + monthname(dates[1]) + ' ' + dates[0];
}

const monthname = (month) => {
	if (month == '01') { month = 'Januari'; } 
	else if (month == '02') { month = 'Februari'; }
	else if (month == '03') { month = 'Maret'; }
	else if (month == '04') { month = 'April'; }
	else if (month == '05') { month = 'Mei'; }
	else if (month == '06') { month = 'Juni'; }
	else if (month == '07') { month = 'Juli'; }
	else if (month == '08') { month = 'Agustus'; }
	else if (month == '09') { month = 'September'; }
	else if (month == '10') { month = 'Oktober'; }
	else if (month == '11') { month = 'November'; }
	else { month = 'Desember'; }
	return month;
}

export const datenumber = (tanggal, istimes = false) => {
	let tmp = tanggal.split(" "), 
			dates = tmp[0].split('-');
	if (tmp.length > 1) {
		let times = tmp[1].split(':');
		if (istimes) { return dates[2] + '/' + dates[1] + '/' + dates[0] + ' ' + times[0] + ':' + times[1]; }
		return dates[2] + '/' + dates[1] + '/' + dates[0];
	}
	return dates[2] + '/' + dates[1] + '/' + dates[0];
}

export const strtolower = (str) => { return str.toLowerCase(); }

export const lowercaseNoSpace = (str) => { return str.toLowerCase().trim(); }

export const strtoupper = (str) => { return str.toLocaleUpperCase(); }

/* Mengambil character berdasarkan lokasi index awal dan akhir */
export const substring = (str, from, to) => { return str.substr(from, to); }

export const streachcapital = (str) => {
	const words = str.split(" ");
	for (let i = 0; i < words.length; i++) { words[i] = words[i][0].toUpperCase() + words[i].substr(1); }
	return words.join(" ");
}

// export const countage = (dates) => { //remark by Yudha
// 	let tmp = dates.split(" ");
// 	dates = tmp[0].split("-");
// 	let yearBirthday = dates[0], monthBirthday = parseInt(dates[1]);
// 	var dateObj = new Date();
// 	var monthToday = dateObj.getUTCMonth() + 1;
// 	var yearToday = dateObj.getUTCFullYear();
// 	yearBirthday = parseInt(yearToday) - parseInt(yearBirthday);
// 	if (monthToday < monthBirthday) { monthToday += 2 + 10; }
// 	monthBirthday = monthToday - monthBirthday;
// 	if (yearBirthday >= 1) {
// 		if (monthBirthday > 0) { return yearBirthday + ' tahun ' + monthBirthday + ' bulan';  }
// 		return yearBirthday + ' tahun'; 
// 	}
// 	return monthBirthday + ' bulan';
// }
export const countage = (dateString) => {
    // Pastikan format YYYY-MM-DD
    const [year, month, day] = dateString.split(" ")[0].split("-").map(Number);

    const today = new Date();
    const birth = new Date(year, month - 1, day); // month 0-based

    let yearDiff = today.getFullYear() - birth.getFullYear();
    let monthDiff = today.getMonth() - birth.getMonth();
    let dayDiff = today.getDate() - birth.getDate();

    // Jika hari belum lewat → kurangi 1 bulan
    if (dayDiff < 0) {
        monthDiff -= 1;
    }

    // Jika bulan minus → kurangi 1 tahun
    if (monthDiff < 0) {
        yearDiff -= 1;
        monthDiff += 12;
    }

    // Safety: jika tanggal lahir di masa depan
    if (yearDiff < 0) {
        return "0 bulan";
    }

    if (yearDiff >= 1) {
        if (monthDiff > 0) {
            return `${yearDiff} tahun ${monthDiff} bulan`;
        }
        return `${yearDiff} tahun`;
    }

    return `${monthDiff} bulan`;
};
export const nullAndZero = (str) => {
	if (str) { if (str != '0') { return str; } }
	return '-';
}

export const formatrupiah = (str) => { return 'Rp. ' + str.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."); }
export const numberdigit = (str) => { return str.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."); }
