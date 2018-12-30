<?php

namespace App\Models\Entity;

class UserRelationshipType
{
    public $id;
    public $relationshipTypeId;
    public $userId;
    public $name;

    public static function map_single($object)
    {
        $toReturn = new UserRelationshipType();
        $toReturn->id = $object->id;
        $toReturn->relationshipTypeId = $object->relationship_type_id;
        $toReturn->userId = $object->user_id;
        $toReturn->name = $object->relationship_type->name;
        return $toReturn;
    }

    public static function map_array($object)
    {
        $toReturn = array();
        foreach ($object as $element) {
            $toReturn[] = UserRelationshipType::map_single($element);
        }
        return $toReturn;
    }
}