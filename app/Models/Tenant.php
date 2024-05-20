<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
	use UuidTrait, HasFactory;
	
	protected $table = 'tenants';

	protected $fillable = [
   'uuid',
   'subdomain',
   'filename_certificate',
   'file_certificate',
   'filename_logo_portal',
   'file_logo_portal',
   'color_general',
   'json_tmp'
	];
	
	public function user(){
		return $this->hasOne(User::class, 'tenant_id', 'id')->where('category', 'CL');
	}
	
	public function access()
	{
		return $this->hasOne(Access::class, 'tenant_id', 'id');
	}
	
	public function integrationWhatsaApp()
	{
		return $this->hasOne(IntegrationWhatsApp::class, 'tenant_id', 'id');
	}
}