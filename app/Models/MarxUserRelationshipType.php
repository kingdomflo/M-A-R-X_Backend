<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MarxUserRelationshipType extends Model
{

  public function relationship_type()
  {
    return $this->hasOne('App\Models\MarxRelationshipType', 'id', 'relationship_type_id');
  }

  public function marx_relationship()
  {
    return $this->hasMany('App\Models\MarxRelationship');
  }

  public function marx_user()
  {
    return $this->belongsTo('App\Models\MarxUser');
  }

  public function marx_relationship_type()
  {
    return $this->belongsTo('App\Models\MarxRelationshipType');
  }

}