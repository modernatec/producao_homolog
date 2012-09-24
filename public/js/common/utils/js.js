//-----------------------------------------------------------------------------
// Agencia RS
// http://agenciars.com.br
// 01/02/2010
// Charset UTF-8
//-----------------------------------------------------------------------------

//-----------------------------------------------------------------------------
// Vars
//-----------------------------------------------------------------------------
var v;
var aPersonal = new Array
(
	'clie_name', 
	'clie_last_name', 
	'clie_cpf', 
	'clie_rg', 
	'clie_birth_day', 
	'clie_birth_mount', 
	'clie_birth_year'
);

var aCompany = new Array
(
	'clie_company', 
	'clie_cnpj', 
	'clie_insc', 
	'clie_resp'
);


//-----------------------------------------------------------------------------
// Set element by id
//-----------------------------------------------------------------------------
// str		string
// return 	object
//-----------------------------------------------------------------------------
function setID(str)
{
	return document.getElementById(str);
}


//-----------------------------------------------------------------------------
// Onload
//-----------------------------------------------------------------------------
// return 	void
//-----------------------------------------------------------------------------
window.onload = function()
{
	setPersonalType();
	alterPass();
	setInputValue('search', 'Buscar...');
	setInputValue('zip', 'Digite seu CEP');
	setInputValue('user_active', 'E-mail');
	setInputValue('user_pass', 'Senha');
}


//-----------------------------------------------------------------------------
// Set input value
//-----------------------------------------------------------------------------
// id		string
// str		string
// return 	void
//-----------------------------------------------------------------------------
function setInputValue(id, str)
{
	if(setID(id) != null)
	{
		setID(id).style.color 	= '#999999';
		setID(id).value 		= str;
		if(setID(id).type == 'password')
		{
			if(setID(id).type == 'password')
				setID(id).setAttribute('type', 'text');
			
			setID(id).onfocus = function()
			{
				if(setID(id).value == str)
				{
					setID(id).value 		= '';
					setID(id).style.color 	= '#2D2D2D';
					if(setID(id).type == 'text')
						setID(id).setAttribute('type', 'password');
				}
			}
			setID(id).onblur = function()
			{
				if(setID(id).value == '')
				{
					setID(id).style.color 	= '#999999';
					setID(id).value 		= str;
					
					if(setID(id).type == 'password')
						setID(id).setAttribute('type', 'text');
				}
			}
		}
		else
		{
			setID(id).onfocus = function()
			{
				if(setID(id).value == str)
				{
					setID(id).value 		= '';
					setID(id).style.color 	= '#2D2D2D';
				}
			}
		
			setID(id).onblur = function()
			{
				if(setID(id).value == '')
				{
					setID(id).style.color 	= '#999999';
					setID(id).value 		= str;
				}
			}
		}
	}
}


//-----------------------------------------------------------------------------
// Only numbers
//-----------------------------------------------------------------------------
// return	void
//-----------------------------------------------------------------------------
function onlyNumbers(id, type)
{
	if(id == null)
		id = '';
	else if(type == null)
		type = '';
	else
		if(setID(id) != null)
			setID(id).value = setNum(setID(id).value, type);
	
	
	if(setID('clie_zip') != null)
		setID('clie_zip').value = setNum(setID('clie_zip').value);
	
	if(setID('delivery_zip') != null)
		setID('delivery_zip').value = setNum(setID('delivery_zip').value);
	
	if(setID('request_zip') != null)
		setID('request_zip').value = setNum(setID('request_zip').value);
	
	setTimeout(onlyNumbers, 0);
}


//-----------------------------------------------------------------------------
// Set number
//-----------------------------------------------------------------------------
// id		string
// type		string
// return	int
//-----------------------------------------------------------------------------
function setNum(id, type)
{
	((type == null) ? type = '' : type);
	switch(type)
	{
		case 'PRINCE'	: return id.replace(/[^0-9\.\,]/g, ''); 	break;
		case 'RG'		: return id.replace(/[^0-9\.\-\x]/g, ''); 	break;
		case 'DOC'		: return id.replace(/[^0-9\.\-]/g, ''); 	break;
		case 'CNPJ'		: return id.replace(/[^0-9\.\-\\]/g, ''); 	break;
		case 'CEP'		: return id.replace(/[^0-9\-]/g, ''); 		break;
		default			: return id.replace(/[^0-9]/g, ''); 		break;
	}
}


//-----------------------------------------------------------------------------
// Set personal type
//-----------------------------------------------------------------------------
// return	void
//-----------------------------------------------------------------------------
function setPersonalType()
{
	if(setID('personal_type') != null)
	{
		if(document.sendForm.personal_type[1].checked)
		{
			document.sendForm.personal_type[1].checked 	= true;
			setID('company').style.display 				= 'block';
			setID('personalName').innerHTML				= 'Pessoa Jurídica';
			
			for(v in aPersonal)
				setID(aPersonal[v]).value = '';
			
			setID('personal').style.display = 'none';
		}
		else
		{
			document.sendForm.personal_type[0].checked 	= true;
			setID('personal').style.display 			= 'block';
			setID('personalName').innerHTML				= 'Pessoa Física';
			
			for(v in aCompany)
				setID(aCompany[v]).value = '';
			
			setID('company').style.display 	= 'none';
		}
	}
}


//-----------------------------------------------------------------------------
// Alter password
//-----------------------------------------------------------------------------
// return	void
//-----------------------------------------------------------------------------
function alterPass()
{
	if(setID('alterPWD') != null)
	{
		if(document.sendForm.alterPWD[1].checked)
		{
			document.sendForm.alterPWD[1].checked 		= true;
			setID('user_pass').style.display 			= 'block';
			setID('newUser_pass').style.display 		= 'block';
			setID('replyNewUser_pass').style.display 	= 'block';
		}
		else
		{
			document.sendForm.alterPWD[0].checked	= true;
			setID('user_pass').style.display 				= 'none';
			setID('newUser_pass').style.display 			= 'none';
			setID('replyNewUser_pass').style.display 		= 'none';
		}
	}
}