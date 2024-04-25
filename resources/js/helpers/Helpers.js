import Swal from 'sweetalert2';

export const empty = (str) => typeof str == 'string' && !str.trim() || typeof str == 'undefined' || str === null;

export const show_msgbox = (message, icon) => Swal.fire({
	html:  message,
	icon: icon,
	confirmButtonText: 'ok'
});

export const validatedEmail = (email) => {
	const emailFilter = /^.+@.+\..{2,}$/;
	const illegalChars = /[,\]]/;
	
	if (!(emailFilter.test(email)) || email.match(illegalChars))
	{
		return false;
	}
	
	return true;
}

export const dateHoursCurrent = () => {
	const agora = new Date();
	const dia = agora.getDate().toString().padStart(2, '0');
	const mes = (agora.getMonth() + 1).toString().padStart(2, '0');
	const ano = agora.getFullYear();
	const hora = agora.getHours().toString().padStart(2, '0');
	const minuto = agora.getMinutes().toString().padStart(2, '0');
	const segundo = agora.getSeconds().toString().padStart(2, '0');
	return `${ano}-${mes}-${dia} ${hora}:${minuto}:${segundo}`;
}

export const validatedUsername = (username) => {
	let regExpUsername = /[^a-z0-9_]/g;
	if(username.match(regExpUsername)){
		username = username.replace(regExpUsername,'');
	}
	
	return username;
}

export const validatedPhone = (phone) => {
	let whatsappRegex = /^[1-9]{2}[1-9]{2}[2-9][0-9]{7,8}$/;
	if(!whatsappRegex.test(phone)){
		return true
	}
	
	return false;
}

export const keepNumbersOnly = (str) => {
	if(empty(str)){ return ''; }
	return str.replace(/\D/g, '');
}

export const formatDateTimeLocal = (date) => {
	
	if(empty(date))
	{
		return '';
	}
	
	return date.substr(6, 4)+ "-" +date.substr(3, 2)+ "-" +date.substr(0, 2)+ "T" +date.substr(11, 2)+ ":" +date.substr(14, 2)+ ":" +date.substr(17, 2);
}

export const formatarCPFCNPJ = (value) => {
	if(empty(value))
	{
		return '';
	}
	
	value = value.replace(/\D/g, '');
	if(value.length === 11)
	{
		return value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "$1.$2.$3-$4");
	}
	else
	{
		return value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/g, "$1.$2.$3/$4-$5");
	}
}

export const calculateDateMinus30Days = () => {
 const currentDate = new Date();
	
 const dateMinus30Days = new Date(currentDate);
 dateMinus30Days.setDate(currentDate.getDate() - 30);
	
 const currentDateFormatted = `${currentDate.getFullYear()}-${(currentDate.getMonth() + 1).toString().padStart(2, '0')}-${currentDate.getDate().toString().padStart(2, '0')}`;
 const dateMinus30DaysFormatted = `${dateMinus30Days.getFullYear()}-${(dateMinus30Days.getMonth() + 1).toString().padStart(2, '0')}-${dateMinus30Days.getDate().toString().padStart(2, '0')}`;
	
 return {
	 currentDate: currentDateFormatted,
	 dateMinus30Days: dateMinus30DaysFormatted
 };
}

export const formatPhoneNumber = (value) => {
	
	if(empty(value))
	{
		return value;
	}
	
	let ret = '';
	switch(value.length)
	{
		case 10:
			ret = "("+value.substr(0,2)+") "+value.substr(2,4)+"-"+value.substr(6,4);
			break;
		case 11:
			ret = "("+value.substr(0,2)+") "+value.substr(2,1)+"-"+value.substr(3,4)+"-"+value.substr(7,4);
			break;
		case 12:
			ret = value.substr(0,2)+" ("+value.substr(2,2)+") "+value.substr(4,4)+"-"+value.substr(8,4);
			break;
		case 13:
			ret = value.substr(0,2)+" ("+value.substr(2,2)+") "+value.substr(4,1)+"-"+value.substr(5,4)+"-"+value.substr(9,4);
			break;
		default:
			ret = "";
			break;
	}

	return ret;
}

export const formatDateTime = (value) => {
	
	if(empty(value))
	{
		return '';
	}
	
	const date = new Date(value);
	const dia = date.getDate().toString().padStart(2, '0');
	const mes = (date.getMonth() + 1).toString().padStart(2, '0');
	const ano = date.getFullYear();
	const hora = date.getHours().toString().padStart(2, '0');
	const minutos = date.getMinutes().toString().padStart(2, '0');
	const segundos = date.getSeconds().toString().padStart(2, '0');

	return `${dia}/${mes}/${ano} ${hora}:${minutos}:${segundos}`;
}

export const formatDateNoSeconds = (value) => {
	if(empty(value))
	{
		return '';
	}
	
	const date = new Date(value);
	const dia = date.getDate().toString().padStart(2, '0');
	const mes = (date.getMonth() + 1).toString().padStart(2, '0');
	const ano = date.getFullYear();
	const hora = date.getHours().toString().padStart(2, '0');
	const minutos = date.getMinutes().toString().padStart(2, '0');
	const segundos = date.getSeconds().toString().padStart(2, '0');

	return `${dia}/${mes}/${ano} ${hora}:${minutos}`;
}
export const formatCep = (value) => {
	
	if(empty(value))
	{
		return value;
	}
	
	return value.replace(/^(\d{5})(\d)/, "$1-$2");
}

export const formatDate = (date, fluxo) => {
	
	if(empty(date))
	{
		return '';
	}
	
	if(fluxo == 0)
	{
		return date.substr(6, 4)+ "-" +date.substr(3, 2)+ "-" +date.substr(0, 2);
	}
	else
	{
		const partes = date.split('-');
		const dia = partes[2];
		const mes = partes[1];
		const ano = partes[0];
		return `${dia}/${mes}/${ano}`;
	}
}

export const confirm_alert = async (msg) => {
	const response = await Swal.fire({
		text: msg,
		icon: 'warning',
		showCancelButton: true,
		cancelButtonText: 'Não',
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Sim'
	});
	
	return response.isConfirmed;
}

export const convertWordToUppercase = (word) => {
	if(empty(word))
	{
		return '';
	}
	let modifiedString = word.toLowerCase().replace(/(^|\s)[a-z]/g, function(f){ return f.toUpperCase(); });
	return modifiedString;
}

export const convertToUpperCase = (str) => {
	if(empty(str))
	{
		return '';
	}
  return str.toUpperCase();
}

export const validateCPF = (cpf) => {
	let sum = 0;
	let rest;
	if (cpf == "00000000000") return false;
	
	for (let i = 1; i <= 9; i++)
		sum = sum + parseInt(cpf.substring(i - 1, i)) * (11 - i);
	rest = (sum * 10) % 11;

	if (rest == 10 || rest == 11) rest = 0;
	if (rest != parseInt(cpf.substring(9, 10))) return false;

	sum = 0;
	for (let i = 1; i <= 10; i++)
		sum = sum + parseInt(cpf.substring(i - 1, i)) * (12 - i);
	rest = (sum * 10) % 11;

	if (rest == 10 || rest == 11) rest = 0;
	if (rest != parseInt(cpf.substring(10, 11))) return false;
	return true;
}

export const validateCNPJ = (cnpj) => {
	cnpj = cnpj.replace(/[^\d]+/g,'');
	if(cnpj == '') return false;
	if (cnpj.length != 14)
		return false;
	if (cnpj == "00000000000000" || 
			cnpj == "11111111111111" || 
			cnpj == "22222222222222" || 
			cnpj == "33333333333333" || 
			cnpj == "44444444444444" || 
			cnpj == "55555555555555" || 
			cnpj == "66666666666666" || 
			cnpj == "77777777777777" || 
			cnpj == "88888888888888" || 
			cnpj == "99999999999999")
		return false;

	let tamanho = cnpj.length - 2
	let numeros = cnpj.substring(0, tamanho);
	let digitos = cnpj.substring(tamanho);
	let soma = 0;
	let pos = tamanho - 7;
	for (let i = tamanho; i >= 1; i--) {
		soma += numeros.charAt(tamanho - i) * pos--;
		if (pos < 2)
			pos = 9;
	}
	let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	if (resultado != digitos.charAt(0))
		return false;
	
	tamanho = tamanho + 1;
	numeros = cnpj.substring(0, tamanho);
	soma = 0;
	pos = tamanho - 7;
	for (let i = tamanho; i >= 1; i--) {
		soma += numeros.charAt(tamanho - i) * pos--;
		if (pos < 2)
			pos = 9;
	}
	resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	if (resultado != digitos.charAt(1))
		return false;
	return true;
}

export const setStartOfWeek = () => {
	const currentDate = new Date();
	const dayOfWeek = currentDate.getDay();
	
	const startOfWeek = new Date(currentDate);
	startOfWeek.setDate(currentDate.getDate() - dayOfWeek);
	
	const endOfWeek = new Date(currentDate);
	endOfWeek.setDate(currentDate.getDate() + (6 - dayOfWeek));
	
	const year_start_of_week = startOfWeek.getFullYear();
	const month_start_of_week = String(startOfWeek.getMonth() + 1).padStart(2, '0');
	const day_start_of_week = String(startOfWeek.getDate()).padStart(2, '0');
	
	return `${year_start_of_week}-${month_start_of_week}-${day_start_of_week}`;
}

export const setEndOfWeek = () => {
	const currentDate = new Date();
	const dayOfWeek = currentDate.getDay();
	
	const startOfWeek = new Date(currentDate);
	startOfWeek.setDate(currentDate.getDate() - dayOfWeek);
	
	const endOfWeek = new Date(currentDate);
	endOfWeek.setDate(currentDate.getDate() + (6 - dayOfWeek));
	
	const year_end_of_week = endOfWeek.getFullYear();
	const month_end_of_week = String(endOfWeek.getMonth() + 1).padStart(2, '0');
	const day_end_of_week = String(endOfWeek.getDate()).padStart(2, '0');
	
	return `${year_end_of_week}-${month_end_of_week}-${day_end_of_week}`;
}

export const dateTimeSchedulingInferiorCurrent = (value) => {
  const dataHoraAtual = new Date();
  const dataHoraAgendamentoObj = new Date(value);
	
  return dataHoraAgendamentoObj < dataHoraAtual;
}

export const dateInferiorCurrent = (value) => {
	const today = new Date().toISOString().split('T')[0];
	const schedulingDate = new Date(value).toISOString().split('T')[0];
	return schedulingDate < today;
}

export const formatBytes = (size, precision = 2) => {
	const base = Math.log(size) / Math.log(1024);
	const suffixes = ['', 'K', 'M', 'G', 'T'];
	return (Math.pow(1024, base - Math.floor(base)).toFixed(precision)) + suffixes[Math.floor(base)];
}

export const limiteTextWithPoints = (texto, limite)=> {
	
	if (texto.length > limite)
	{
		return texto.slice(0, limite) + '...';
	}
	else
	{
		return texto;
	}
}

export const convertedToDecimal = (valueFormated) => {
	if(!valueFormated){ return; }
	const valueSemSymbol = valueFormated.replace(/[^\d,]/g, "").replace(",", ".");
	const valorDecimal = parseFloat(valueSemSymbol);
	return isNaN(valorDecimal) ? 0 : valorDecimal;
}

export const convertedToCointBrazilian = (value) => {
	if(!value){ return; }
	
	return parseFloat(value).toLocaleString('pt-BR', {
		style: 'currency',
		currency: 'BRL',
	});
}

export const dateStartAndDateEndInferiorCurrent = (date_start, date_end) => {
	
	if(empty(date_start) || empty(date_end)){ return; }

	var date_start = new Date(date_start);
	
	var date_end = new Date(date_end);
	
	if (date_end < date_start)
	{
		return true;
	}
	
	return false;
}

export const formatMoneyBRL = (value) => {
	return parseInt(value).toLocaleString('pt-BR', {
		style: 'currency',
		currency: 'BRL'
	})
}