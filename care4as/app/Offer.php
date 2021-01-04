<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public function saveOffer($name,$volume,$price,$telefon,$categories=null)
    {
      $this->name = $name;
      $this->volume = $volume;
      $this->price = $price;
      $this->telefon = $telefon;

      foreach ($categories as $value) {
        $this->$value = 1;
      };

      $this->save();
    }
}
