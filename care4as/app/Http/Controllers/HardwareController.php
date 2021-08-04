<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PC;
use App\Hardwareitem;
use App\Monitor;
use App\Support\Collection;

class HardwareController extends Controller
{
    public function index()
    {
      $hardwarePCs = Hardwareitem::where('type_id',1)->with('devicePC')->get();
      $hardwareMO = Hardwareitem::where('type_id',2)->with('deviceMO')->get();
      $hardware = $hardwarePCs->merge($hardwareMO);

      $hardware = (new Collection($hardware))->paginate(20);
      // dd($hardware);
      return view('inventory.inventoryIndex', compact('hardware'));
    }

    public function add()
    {
      return view('inventory.inventoryADD');
    }

    public function store(Request $request)
    {
      // legend devicetype
      // 1 = PC
      // 2 = Monitor
      // 3 = Drucker
      // 4 = Webcam

      // dd($request);

      $request->validate([
        'devicetype' => 'required',
        'place' => 'required',
      ]);

      $device = $request->devicetype;

      switch ($device) {
        case 1:
            $pc = new PC;
            $pc->storePC($request->brandpc,$request->cpufamily,$request->cpu,json_encode($request->portspc),$request->speed);

            $device_id = $pc->id;
            $typeid = 1;
          break;
        case 2:
            $monitor = new Monitor;
            // storeMonitor($brandmonitor,$size,$ports)
            $monitor->storeMonitor($request->brandmonitor,$request->size,json_encode($request->portsmonitor));

            $device_id = $monitor->id;
            $typeid = 2;
          break;

        default:
          // code...
          break;
      }

      $hwitem = new Hardwareitem;
      // saveHWitem($deviceid, $type_id, $place, $name, $comment, $description)
      $hwitem->saveHWitem($device_id, $typeid, $request->place,$request->name, $request->comment, $request->description);
      // dd($request);
      return redirect()->back();

    }
}
