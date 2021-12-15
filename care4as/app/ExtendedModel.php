<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class ExtendedModel extends Model
{
    public function TranformRequestToModel($transformed,$additionalProperties=false)
    {

      // $tranformed = $request->except(['_token']);
      $properties = array_keys($transformed);

      // dd($properties);

      foreach($properties as $key => $property)
      {

        $this->$property = $transformed[$property];
      }

      if($additionalProperties)
      {
        foreach($additionalProperties as $key=>$property)
        {
          $this->$key = $property;
        }
      }
      // dd($this);
      $this->save();
    }
}
