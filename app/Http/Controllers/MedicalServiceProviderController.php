<?php

namespace App\Http\Controllers;

use App\MedicalServiceProvider;
use Illuminate\Http\Request;

use App\Http\Resources\MedicalServiceProviderResource;

class MedicalServiceProviderController extends Controller
{
    /**
     * Return return matched prioviders collection 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return collection
     */
    public function getList(Request $request)
    {
      return MedicalServiceProviderResource::collection(MedicalServiceProvider::all());
    }
}
