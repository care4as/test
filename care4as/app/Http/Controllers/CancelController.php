<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cancel;
use App\Support\Collection;

class CancelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     Legende der Statusse? Stati? der Mehrzahl von Status!
      0 = unberührt
      1 = Dokuliste
      2= Rückrufliste
      3= in Bearbeitung
     */
    public function index()
    {
        $cancels = Cancel::where('status', 0)
        ->with('user')
        ->orderBy('created_at','DESC')
        ->get();
        $categories = $cancels->pluck('Category');

        if(!$categories->first())
        {
          $categories2 = false;
        }
        else {
          foreach($categories as $categorie)
          {
            $categories2[$categorie] = $cancels->where('Category', $categorie)->count();
          }
        }

        // $cancels->paginate(12);
        $cancels = (new Collection($cancels))->paginate(12);
        // $categories->('Category');
        $categories2 = json_encode($categories2);
        $dokus = Cancel::where('status', 1)->paginate(25);
        return view('cancelsAdmin', compact('cancels','dokus','categories2'));
    }
    public function filter(Request $request)
    {
        // dd($request);
        $query = Cancel::query();
        $query->where('status', 0)->with('user');

        if(request('to') == request('from') and request('to'))
        {
          // return 1;
          $query->whereDate('created_at', '=', request('to'));
        }
        else {
          $query->when(request('from'), function ($q) {
              return $q->where('created_at','>=',request('from'));
          });
          $query->when(request('to'), function ($q) {
              return $q->where('created_at','<=',request('to'));
          });
        }
        $query->when(request('category'), function ($q) {
            return $q->where('Category', request('category'));
        });
        $query->when(request('username'), function ($q) {
            $userid = \App\User::where('name',request('username'))->value('id');
            return $q->where('created_by', $userid);
        });
        $query->orderBy('created_at','DESC');
        $cancels = $query->get();
        // dd($cancels);
        $categories = $cancels->pluck('Category');
        if(!$categories->first())
        {
          $categories2 = false;
        }
        else {
          foreach($categories as $categorie)
          {
            $categories2[$categorie] = $cancels->where('Category', $categorie)->count();
          }
        }
        $cancels = (new Collection($cancels))->paginate(12);
        // $categories->('Category');
        $categories2 = json_encode($categories2);
        $dokus = Cancel::where('status', 1)->get();
        return view('cancelsAdmin', compact('cancels','dokus','categories2'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function changeStatus($id, $status)
     {
       // return $status;
       if($status == 2 )
       {
         $cancel = Cancel::where('id',$id)->first();
         $callback = new \App\Callback;
         $callback->customer = $cancel->Customer;
         $callback->time = 'unbestimmt';
         $callback->cause = $cancel->Notice;
         $callback->created_by = Auth()->user()->id;
         $callback->directed_to = null ;

         $callback->save();
         $cancel->delete();
       }
       else
       {
         $cancel = Cancel::where('id',$id)
         ->update([
           'status' => $status,
         ]);
       }
       return redirect()->back();
     }
    public function create()
    {
      return view('cancelsAgent');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agentCancels($id)
    {
      $cancels = Cancel::where('created_by', $id)->paginate(10);
      // dd($cancels);
      return view('agentCancels', compact('cancels'));

    }

    public function store(Request $request)
    {
      // dd($request);
      $request->validate([
        'case' => 'required',
        'Category' => 'required',
        // 'Offer' => 'required',
      ]);

      // dd($request);
      $cancel = new Cancel;

      $cancel->Offer = $request->Offer;
      $cancel->Notice = $request->Cause;
      $cancel->Category = $request->Category;
      $cancel->Customer = $request->case;
      $cancel->created_by = Auth()->user()->id;
      $cancel->status = 0;

      $cancel->save();

      //track the cancel

      return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cancel = Cancel::where('id',$id)
        ->delete();

        return redirect()->back();


    }
}
