<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Tenant\ManagerTenant;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Helpers
{
	public static function formata_telefone($numero)
	{
		if(empty($numero)){ return $numero; }
		$ret = '';
		switch(strlen($numero))
		{
			case '10':
				$ret = "(".substr($numero,0,2).") ".substr($numero,2,4)."-".substr($numero,6,4);
			case '11':
				$ret = "(".substr($numero,0,2).") ".substr($numero,2,1)."-".substr($numero,3,4)."-".substr($numero,7,4);
				break;
			case '12':
				$ret = substr($numero,0,2)." (".substr($numero,2,2).") ".substr($numero,4,4)."-".substr($numero,8,4);
				break;
			case '13':
				$ret = substr($numero,0,2)." (".substr($numero,2,2).") ".substr($numero,4,1)."-".substr($numero,5,4)."-".substr($numero,9,4);
				break;
			default:
				$ret = $numero;
				break;
		}
		return $ret;
	}
	
	public static function formatedMoneyBR($value)
	{
		if(empty($value)){ return $value; }
		return  number_format($value, 2, ',', '.');
	}
	
	public static function formated_CEP($string)
	{
		return substr($string, 0, 5) . '-' . substr($string, 5, 3);
	}
	
	public static function formated_RG($string)
	{
		return substr($string, 0, 2) . '.' . substr($string, 2, 3) . 
		'.' . substr($string, 5, 3);
	}
	
	public static function state($str)
	{
		if(!$str)
		{
			return '';
		}
		
		$state = array(
			'AC' => 'Acre',
			'AL' => 'Alagoas',
			'AP' => 'Amapá',
			'AM' => 'Amazonas',
			'BA' => 'Bahia',
			'CE' => 'Ceará',
			'DF' => 'Distrito Federal',
			'ES' => 'Espírito Santo',
			'GO' => 'Goiás',
			'MA' => 'Maranhão',
			'MT' => 'Mato Grosso',
			'MS' => 'Mato Grosso do Sul',
			'MG' => 'Minas Gerais',
			'PA' => 'Pará',
			'PB' => 'Paraíba',
			'PR' => 'Paraná',
			'PE' => 'Pernambuco',
			'PI' => 'Piauí',
			'RJ' => 'Rio de Janeiro',
			'RN' => 'Rio Grande do Norte',
			'RS' => 'Rio Grande do Sul',
			'RO' => 'Rondônia',
			'RR' => 'Roraima',
			'SC' => 'Santa Catarina',
			'SP' => 'São Paulo',
			'SE' => 'Serigipe',
			'TO' => 'Tocantins'
		);
		return $state[$str];
	}

	public static function Mask($mask,$str)
	{
		if(!$str)
		{
			return '';
		}
		
		$str = str_replace(" ","",$str);
		
		for($i=0;$i<strlen($str);$i++)
		{
			$mask[strpos($mask,"#")] = $str[$i];
		}
		
		return $mask;
	}
	
	public static function cleanCaracter($var)
	{
		$var =  str_replace('(', '', $var);
		$var =  str_replace(')', '', $var);
		$var =  str_replace('-', '', $var);
		$var =  str_replace('.', '', $var);
		$var =  str_replace('/', '', $var);
		$var =  str_replace('.', '', $var);
		$var =  str_replace(',', '', $var);
		$var =  str_replace(' ', '', $var);
		return $var;
	}
	
	public static function formatData($data)
	{
		if(empty($data)){ return null; }
		$data = strtr($data, '/', '-');
		$ret_data = date('Y-m-d', strtotime($data));
		return $ret_data;
	}
	
	public static function formataDataHora($data)
	{
		if(empty($data)){ return null; }
		$data = strtr($data, '/', '-');
		$ret_data = date('Y-m-d H:i:s', strtotime($data));
		return $ret_data;
	}
	
	public static function formatDateHours($data)
	{
		$date = new DateTime($data);
		return $date->format('Y-m-d H:i:s');   
	}
	
	public static function getDataHora($data)
	{
		$datahora = date('d/m/Y H:i:s', strtotime($data));
		return $datahora;
	}
	
	public static function getData($data)
	{
		$data = date('d/m/Y', strtotime($data));
		return $data;
	}
	
	public function isEmpty($_str)
	{
		if( empty($_str) )
		{
			if($_str == 0){ return false; } else { return true; }
		}
		return false;
	}
	
	public static function getCep($cep)
	{
		$response = Http::get('https://viacep.com.br/ws/'.$cep.'/json/');
		
		if($response->successful())
		{
			$tmp = $response->json();
			
			if((empty($tmp['uf']) && empty($tmp['localidade'])) ||
		    (strlen($tmp['uf']) < 2 && strlen($tmp['localidade']) < 2)
			)
			{
				return (object) array("status" => "0", "message" => "O CEP ".$cep." não existe!");
				exit;
			}
			
			return (object) array(
				"status"     => "1", 
				"message"    => "", 
				"cep"        => $tmp['cep'],
				"logradouro" => $tmp['logradouro'],
				"complemento" => $tmp['complemento'],
				"bairro"     => $tmp['bairro'],
				"localidade" => $tmp['localidade'],
				"uf"         => $tmp['uf'],
			 	"ibge"       => $tmp['ibge']
			);
		}
		else
		{
			return (object) array("status" => "0", "message" => "Incapaz de comunicar com o computador dos correios. Serviço temporariamente indisponível!");
		}
	}
	
	public static function getCity($state)
	{
		$states = DB::table('states')->where('letter', '=', $state)->first();
		
		$cities = DB::table('cities')->select('iso', 'title')->where('state_id', '=', $states->id)->get();
		
		if(empty($cities))
		{
			return response()->json(array("status" => "0", "text" => "Incapaz de realizar a listagem das cidades. Registro inexistente!", "typeBox" => "alert"));
			exit;
		}
		
		$item = '';
		foreach($cities as $citie)
		{
			$item .= "<option value='".$citie->iso."'>".$citie->title."</option>";
		}
		
		return response()->json(array("status" => "1", "text" => "$item", "typeBox" => "confirm"));
	}
	
	public static function getState()
	{
		$states = DB::table('states')->get();
		
		return $states;
	}
	
	public static function formated_CNPJ($_NUM)
	{
		if(empty($_NUM) || $_NUM == ''){ return $_NUM; }
		$o_ret = '';
		$o_ret = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $_NUM);
		return $o_ret;
	}
	
	public static function formated_CPF($_NUM)
	{
		if(empty($_NUM) || $_NUM == ''){ return $_NUM; }
		$o_ret = '';
		$o_ret = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $_NUM);
		return $o_ret;
	}
	
	public static function getUrlMainFrontEnd($subdomain)
	{
		return env('APP_HTTPS').$subdomain.'.'.env('APP_URL_FRONTEND');
	}
	
	public static function getValidRandomFilename($path, $extension)
	{
		do
		{
			$tokenRand = Str::random(40);
			
			if (file_exists($path."/".$tokenRand.'.'.$extension)) { $continue = true; } else { $continue = false; }
			
		} while ($continue == true);
		
		return $tokenRand.'.'.$extension;
	}
	
	public static function check_data_in_table($column, $field, $table)
	{
		return DB::table($table)
					->where($column, $field)
					->count();
	}
	
	public static function formatBytes($size, $precision = 2)
	{ 
		$base = log($size, 1024);
		$suffixes = array('', 'K', 'M', 'G', 'T');
		return round(pow(1024, $base - floor($base)), $precision) .''. $suffixes[floor($base)];
	}
	
	public static function getFileName($filename)
	{
		if(!$filename){  return; }
		$name_file = explode('/',$filename); 
		return $name_file[1];
	}
	
	public static function handleUploadedFile($pathFile, $uploadedFile, $existingFile)
	{
		if (!$uploadedFile || !$uploadedFile->isValid())
		{
			return false;
		}
		
		if ($existingFile)
		{
			Storage::delete($existingFile);
		}
		
		if(!$pathFile)
		{
			$pathFile = auth()->user()->tenant->uuid;
		}
		
		$path = $uploadedFile->store($pathFile);
		
		if (!$path)
		{
			return false;
		}
		
		return (object) [
			'path' => $path,
			'name' => $uploadedFile->getClientOriginalName(),
			'ext'  => $uploadedFile->getClientOriginalExtension(),
			'size' => $uploadedFile->getSize()
		];
	}
	
	public static function deleteFile($file)
	{
		if($file)
		{
			if(Storage::exists($file))
			{
				Storage::delete($file);
			}
		}
	}
	
	public static function loggerUsers($description, $type, $username)
	{
		
		if(empty($description) || empty($type))
		{
			return false;
		}
		
		DB::table('logger_users')->insert([
			'uuid' => str::uuid(),
	'username' => $username,
			'date' => date('Y-m-d H:i:s'),
'description' => $description,
				'ip' => $_SERVER['REMOTE_ADDR'],
			'type' => $type
		]);
		
		return true;
	}
	
	public static function getInfoAccess($tenant_id)
	{
		$query = DB::table('access')
        ->select(
            'type as type',
            'period as period',
            'date_start',
            'date_end',
				);
		
		if (config('database.default') == 'sqlite')
		{
		// Consulta específica para SQLite
		$query->selectRaw('
         CASE 
             WHEN type = "T" THEN 
                 CASE 
                     WHEN situation = "I" THEN "I" 
                     WHEN date_end >= datetime("now") THEN "A"
                     ELSE "E"
                 END
             ELSE
                 CASE 
                     WHEN situation = "I" THEN "I"
                     WHEN date_end >= datetime("now", "+3 days") THEN "A"
                     ELSE "E"
                 END 
         END as situation
     ');
    }
		else
		{
			// Consulta para outros bancos de dados (MySQL, etc.)
			$query->selectRaw('
          CASE 
              WHEN type = "T" THEN 
                  CASE 
                      WHEN situation = "I" THEN "I" 
                      WHEN date_end >= NOW() THEN "A"
                      ELSE "E"
                  END
              ELSE
                  CASE 
                      WHEN situation = "I" THEN "I"
                      WHEN date_end >= DATE_ADD(NOW(), INTERVAL 3 DAY) THEN "A"
                      ELSE "E"
                  END 
          END as situation
      ');
    }
		return $query
				->where('tenant_id', $tenant_id)
				->first();
	}
	
	public static function checkExtensionFile($filename, $extensions)
	{
		$extensionAllowed = $extensions;
		$extensionFile    = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		
		if (in_array($extensionFile, $extensionAllowed))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public static function isDateTimeEndBeforeDateTimeStart($dateTimeEnd, $dateTimeStart)
	{
		$timestampEnd = strtotime($dateTimeEnd);
		$timestampStart = strtotime($dateTimeStart);
		return $timestampEnd < $timestampStart;
	}

	public static function get_extension_from_mimetype($mime) 
	{
		$mime_map = [
			'video/3gpp2'                                                               => '3g2',
			'video/3gp'                                                                 => '3gp',
			'video/3gpp'                                                                => '3gp',
			'application/x-compressed'                                                  => '7zip',
			'audio/x-acc'                                                               => 'aac',
			'audio/ac3'                                                                 => 'ac3',
			'application/postscript'                                                    => 'ai',
			'audio/x-aiff'                                                              => 'aif',
			'audio/aiff'                                                                => 'aif',
			'audio/x-au'                                                                => 'au',
			'video/x-msvideo'                                                           => 'avi',
			'video/msvideo'                                                             => 'avi',
			'video/avi'                                                                 => 'avi',
			'application/x-troff-msvideo'                                               => 'avi',
			'application/macbinary'                                                     => 'bin',
			'application/mac-binary'                                                    => 'bin',
			'application/x-binary'                                                      => 'bin',
			'application/x-macbinary'                                                   => 'bin',
			'image/bmp'                                                                 => 'bmp',
			'image/x-bmp'                                                               => 'bmp',
			'image/x-bitmap'                                                            => 'bmp',
			'image/x-xbitmap'                                                           => 'bmp',
			'image/x-win-bitmap'                                                        => 'bmp',
			'image/x-windows-bmp'                                                       => 'bmp',
			'image/ms-bmp'                                                              => 'bmp',
			'image/x-ms-bmp'                                                            => 'bmp',
			'application/bmp'                                                           => 'bmp',
			'application/x-bmp'                                                         => 'bmp',
			'application/x-win-bitmap'                                                  => 'bmp',
			'application/cdr'                                                           => 'cdr',
			'application/coreldraw'                                                     => 'cdr',
			'application/x-cdr'                                                         => 'cdr',
			'application/x-coreldraw'                                                   => 'cdr',
			'image/cdr'                                                                 => 'cdr',
			'image/x-cdr'                                                               => 'cdr',
			'zz-application/zz-winassoc-cdr'                                            => 'cdr',
			'application/mac-compactpro'                                                => 'cpt',
			'application/pkix-crl'                                                      => 'crl',
			'application/pkcs-crl'                                                      => 'crl',
			'application/x-x509-ca-cert'                                                => 'crt',
			'application/pkix-cert'                                                     => 'crt',
			'text/css'                                                                  => 'css',
			'text/csv'                                                                  => 'csv',
			'text/x-comma-separated-values'                                             => 'csv',
			'text/comma-separated-values'                                               => 'csv',
			'application/vnd.msexcel'                                                   => 'csv',
			'application/x-director'                                                    => 'dcr',
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
			'application/x-dvi'                                                         => 'dvi',
			'message/rfc822'                                                            => 'eml',
			'application/x-msdownload'                                                  => 'exe',
			'video/x-f4v'                                                               => 'f4v',
			'audio/x-flac'                                                              => 'flac',
			'video/x-flv'                                                               => 'flv',
			'image/gif'                                                                 => 'gif',
			'application/gpg-keys'                                                      => 'gpg',
			'application/x-gtar'                                                        => 'gtar',
			'application/x-gzip'                                                        => 'gzip',
			'application/mac-binhex40'                                                  => 'hqx',
			'application/mac-binhex'                                                    => 'hqx',
			'application/x-binhex40'                                                    => 'hqx',
			'application/x-mac-binhex40'                                                => 'hqx',
			'text/html'                                                                 => 'html',
			'image/x-icon'                                                              => 'ico',
			'image/x-ico'                                                               => 'ico',
			'image/vnd.microsoft.icon'                                                  => 'ico',
			'text/calendar'                                                             => 'ics',
			'application/java-archive'                                                  => 'jar',
			'application/x-java-application'                                            => 'jar',
			'application/x-jar'                                                         => 'jar',
			'image/jp2'                                                                 => 'jp2',
			'video/mj2'                                                                 => 'jp2',
			'image/jpx'                                                                 => 'jp2',
			'image/jpm'                                                                 => 'jp2',
			'image/jpeg'                                                                => 'jpeg',
			'image/pjpeg'                                                               => 'jpeg',
			'application/x-javascript'                                                  => 'js',
			'application/json'                                                          => 'json',
			'text/json'                                                                 => 'json',
			'application/vnd.google-earth.kml+xml'                                      => 'kml',
			'application/vnd.google-earth.kmz'                                          => 'kmz',
			'text/x-log'                                                                => 'log',
			'audio/x-m4a'                                                               => 'm4a',
			'audio/mp4'                                                                 => 'm4a',
			'application/vnd.mpegurl'                                                   => 'm4u',
			'audio/midi'                                                                => 'mid',
			'application/vnd.mif'                                                       => 'mif',
			'video/quicktime'                                                           => 'mov',
			'video/x-sgi-movie'                                                         => 'movie',
			'audio/mpeg'                                                                => 'mp3',
			'audio/mpg'                                                                 => 'mp3',
			'audio/mpeg3'                                                               => 'mp3',
			'audio/mp3'                                                                 => 'mp3',
			'video/mp4'                                                                 => 'mp4',
			'video/mpeg'                                                                => 'mpeg',
			'application/oda'                                                           => 'oda',
			'audio/ogg'                                                                 => 'ogg',
			'audio/ogg; codecs=opus'                                                    => 'ogg',
			'video/ogg'                                                                 => 'ogg',
			'application/ogg'                                                           => 'ogg',
			'font/otf'                                                                  => 'otf',
			'application/x-pkcs10'                                                      => 'p10',
			'application/pkcs10'                                                        => 'p10',
			'application/x-pkcs12'                                                      => 'p12',
			'application/x-pkcs7-signature'                                             => 'p7a',
			'application/pkcs7-mime'                                                    => 'p7c',
			'application/x-pkcs7-mime'                                                  => 'p7c',
			'application/x-pkcs7-certreqresp'                                           => 'p7r',
			'application/pkcs7-signature'                                               => 'p7s',
			'application/pdf'                                                           => 'pdf',
			'application/octet-stream'                                                  => 'pdf',
			'application/x-x509-user-cert'                                              => 'pem',
			'application/x-pem-file'                                                    => 'pem',
			'application/pgp'                                                           => 'pgp',
			'application/x-httpd-php'                                                   => 'php',
			'application/php'                                                           => 'php',
			'application/x-php'                                                         => 'php',
			'text/php'                                                                  => 'php',
			'text/x-php'                                                                => 'php',
			'application/x-httpd-php-source'                                            => 'php',
			'image/png'                                                                 => 'png',
			'image/x-png'                                                               => 'png',
			'application/powerpoint'                                                    => 'ppt',
			'application/vnd.ms-powerpoint'                                             => 'ppt',
			'application/vnd.ms-office'                                                 => 'ppt',
			'application/msword'                                                        => 'doc',
			'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
			'application/x-photoshop'                                                   => 'psd',
			'image/vnd.adobe.photoshop'                                                 => 'psd',
			'audio/x-realaudio'                                                         => 'ra',
			'audio/x-pn-realaudio'                                                      => 'ram',
			'application/x-rar'                                                         => 'rar',
			'application/rar'                                                           => 'rar',
			'application/x-rar-compressed'                                              => 'rar',
			'audio/x-pn-realaudio-plugin'                                               => 'rpm',
			'application/x-pkcs7'                                                       => 'rsa',
			'text/rtf'                                                                  => 'rtf',
			'text/richtext'                                                             => 'rtx',
			'video/vnd.rn-realvideo'                                                    => 'rv',
			'application/x-stuffit'                                                     => 'sit',
			'application/smil'                                                          => 'smil',
			'text/srt'                                                                  => 'srt',
			'image/svg+xml'                                                             => 'svg',
			'application/x-shockwave-flash'                                             => 'swf',
			'application/x-tar'                                                         => 'tar',
			'application/x-gzip-compressed'                                             => 'tgz',
			'image/tiff'                                                                => 'tiff',
			'font/ttf'                                                                  => 'ttf',
			'text/plain'                                                                => 'txt',
			'text/x-vcard'                                                              => 'vcf',
			'application/videolan'                                                      => 'vlc',
			'text/vtt'                                                                  => 'vtt',
			'audio/x-wav'                                                               => 'wav',
			'audio/wave'                                                                => 'wav',
			'audio/wav'                                                                 => 'wav',
			'application/wbxml'                                                         => 'wbxml',
			'video/webm'                                                                => 'webm',
			'image/webp'                                                                => 'webp',
			'audio/x-ms-wma'                                                            => 'wma',
			'application/wmlc'                                                          => 'wmlc',
			'video/x-ms-wmv'                                                            => 'wmv',
			'video/x-ms-asf'                                                            => 'wmv',
			'font/woff'                                                                 => 'woff',
			'font/woff2'                                                                => 'woff2',
			'application/xhtml+xml'                                                     => 'xhtml',
			'application/excel'                                                         => 'xl',
			'application/msexcel'                                                       => 'xls',
			'application/x-msexcel'                                                     => 'xls',
			'application/x-ms-excel'                                                    => 'xls',
			'application/x-excel'                                                       => 'xls',
			'application/x-dos_ms_excel'                                                => 'xls',
			'application/xls'                                                           => 'xls',
			'application/x-xls'                                                         => 'xls',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
			'application/vnd.ms-excel'                                                  => 'xlsx',
			'application/xml'                                                           => 'xml',
			'text/xml'                                                                  => 'xml',
			'text/xsl'                                                                  => 'xsl',
			'application/xspf+xml'                                                      => 'xspf',
			'application/x-compress'                                                    => 'z',
			'application/x-zip'                                                         => 'zip',
			'application/zip'                                                           => 'zip',
			'application/x-zip-compressed'                                              => 'zip',
			'application/s-compressed'                                                  => 'zip',
			'multipart/x-zip'                                                           => 'zip',
			'text/x-scriptzsh'                                                          => 'zsh',
		];
		return isset($mime_map[$mime]) ? $mime_map[$mime] : false;
	}
}
?>