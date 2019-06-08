<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
    //
    public function getConfig()
    {
        $configs = DB::table('client_config')->where('enabled','=',1)
            ->get(['name', 'value']);

        $output_arr = array();
        foreach($configs as $config)
        {
            $output_arr[$config->name] = $config->value;
        }

        return response()->json($output_arr, 200);
    }
}
