<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PC;
use App\Hardwareitem;
use App\Monitor;
use App\Support\Collection;

class HardwareController extends Controller
  {
    public function __contruct()
    {
      $this->middleware('auth');
    }
    public function index()
    {
      $hardwarePCs = Hardwareitem::where('type_id',1)->with('devicePC')->get();
      $hardwareMO = Hardwareitem::where('type_id',2)->with('deviceMO')->get();
      $hardware = $hardwarePCs->merge($hardwareMO);

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
    public function show($id)
    {
      $item = Hardwareitem::find($id);

      switch ($item->type_id) {
        case '1':
          $item->load('devicePC');
          break;
        case '2':
          $item->load('deviceMO');
          break;

      }
      return response()->json($item);
      return view('inventory.HWItemShow', compact('item'));
      // dd($item);
    }
    public function update($id, Request $request)
    {
      // dd($request);
      $item = Hardwareitem::find($id);

      $item->name = $request->name;

      $item->place = $request->place;
      $item->comment = $request->comment;
      $item->description = $request->description;

      //if the item type is not changed, change the item data, f.e. pc speed from 2.7 to 2.3
      if($item->type_id == $request->devicetype)
      {
        // return $item->type_id;
        switch ($item->type_id) {
          case '1':
            $item2 = PC::find($item->device_id);
            $item2->brand = $request->brand;
            $item2->cpu = $request->cpu;
            $item2->speed = $request->speed;
            $item2->port = json_encode($request->portspc);

            $item2->save();
          break;

          case '2':

            $item2 = Monitor::find($item->device_id);

            // dd($item2);

            $item2->size = $request->size;
            $item2->brand = $request->brand;
            $item2->ports = json_encode($request->portsmonitor);

            $item2->save();
            break;
        }
      }
      else {
        return 'Gerätänderung noch nicht implementiert';
      }

      $item->type_id = $request->devicetype;
      $item->save();
      return redirect()->back();


    }
    public function delete($id)
    {
        $item = Hardwareitem::find($id);
        $item->delete();

        return redirect()->back();
    }
}
