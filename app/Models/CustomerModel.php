<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    protected $table = 'customer';
    protected $fillable = ['name', 'phone','address','status', 'created_at','remark', 'room_id','stay_type','price'];
    public $timestamps = false;

    public function room(){
        return $this->belongsTo(RoomModel::class, 'room_id', 'id');
    }
}


?>