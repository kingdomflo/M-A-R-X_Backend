<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class MarxRelationship extends Model
{
  public function marx_user()
  {
    return $this->belongsTo('App\MarxUser');
  }

  public function marx_user_relationship_type()
  {
    return $this->belongsTo('App\MarxUserRelationshipType');
  }
}