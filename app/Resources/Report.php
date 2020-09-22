<?php

namespace App\Resources;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

  protected $fillable = [
      'id','serial', 'type', 'brand', 'model', 'ip', 'mac_address', 'active_type', 'comment', 'status', 'place_id'
  ];

  public function scopeSearch($query, $search) {
      if($search != "") {
          return $query->where('serial', 'LIKE', '%'.$search.'%')
                       ->orWhere('type', 'LIKE', '%'.$search.'%')
                       ->orWhere('brand', 'LIKE', '%'.$search.'%')
                       ->orWhere('model', 'LIKE', '%'.$search.'%')
                       ->orWhere('ip', 'LIKE', '%'.$search.'%')
                       ->orWhere('mac_address', 'LIKE', '%'.$search.'%')
                       ->orWhere('active_type', 'LIKE', '%'.$search.'%');
      }
  }



}
