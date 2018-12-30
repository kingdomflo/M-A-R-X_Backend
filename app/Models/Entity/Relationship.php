<?php

namespace App\Models\Entity;

class Relationship
{
    public $id;
    public $userRelationshipTypeId;
    public $relationshipTypeId;
    public $userId;
    public $name;
    public $relationshipType;

    public static function map_single($object)
    {
        $toReturn = new Relationship();
        $toReturn->id = $object->id;
        $toReturn->userRelationshipTypeId = $object->user_relationship_type_id;
        $toReturn->relationshipTypeId = $object->user_relationship_type->relationship_type_id;
        $toReturn->userId = $object->user_relationship_type->user_id;
        $toReturn->name = $object->name;
        $toReturn->relationshipType = $object->user_relationship_type->relationship_type->name;
        return $toReturn;
    }

    public static function map_array($object)
    {
        $toReturn = array();
        foreach ($object as $element) {
            $toReturn[] = Relationship::map_single($element);
        }
        return $toReturn;
    }
}