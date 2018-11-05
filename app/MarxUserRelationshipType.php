<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class MarxUserRelationshipType extends Model
{

  public function relationship_type()
  {
    return $this->hasOne('App\MarxRelationshipType', 'id', 'relationship_type_id');
  }

  public function marx_relationship()
  {
    return $this->hasMany('App\MarxRelationship');
  }

  public function marx_user()
  {
    return $this->belongsTo('App\MarxUser');
  }

  public function marx_relationship_type()
  {
    return $this->belongsTo('App\MarxRelationshipType');
  }

}