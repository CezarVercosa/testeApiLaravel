<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function search($ceps)
    {
        $cepsArray = explode(',', $ceps);
        $addresses = [];

        foreach ($cepsArray as $cep) {
            $url = "https://viacep.com.br/ws/{$cep}/json/";

        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $data = json_decode($response, true);

            if ($httpStatus <> 200) {
                $addresses[] = [
                    "erro" => true,
                    'cep' => $cep
                ];
                continue;
            }

            $addresses[] = [
                'cep' => $data['cep'],
                'logradouro' => $data['logradouro'],
                'complemento' => $data['complemento'],
                'bairro' => $data['bairro'],
                'localidade' => $data['localidade'],
                'uf' => $data['uf'],
                'ibge' => $data['ibge'],
                'gia' => $data['gia'],
                'ddd' => $data['ddd'],
                'siafi' => $data['siafi'],
            ];
            
            
        }

        return response()->json(array_reverse($addresses));// colocando do ultimo cep ao primeiro conforme a regra do teste.
    }
}
