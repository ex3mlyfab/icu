<?php

namespace App\Http\Controllers;

use App\Models\NormativeValue;
use Illuminate\Http\Request;

class NormativeController extends Controller
{
    //
    public function index()
    {
        return view('pages.normative');
    }
    public function getNormative(Request $request)
    {
        $perPage = $request->input('per_page', 21);
        $search = $request->input('search');

        $query = NormativeValue::query();
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        if($request->page == "all"){
            $normative = $query->all();
        }else{
        $normative = $query->paginate($perPage);
        }

        return response()->json($normative);

    }

    public function storeNormative(Request $request)
    {
        $normative = $request->all();
        NormativeValue::create($normative);
        return response(['message'=> 'Normative Added successfully'], 200);
    }

    public function updateNormative(Request $request, $id)
    {
        $normative = NormativeValue::find($id);
        $normative->update($request->all());
        return response(['message'=> 'Normative Updated successfully'], 200);
    }

    public function deleteNormative($id)
    {
        $normative = NormativeValue::find($id);
        $normative->delete();
        return response(['message'=> 'Normative Deleted successfully'], 200);
    }

    public function getNormativeById($id)
    {
        $normative = NormativeValue::find($id);
        return response()->json($normative);
    }
    public function getNormativeByName($name)
    {
        $normative = NormativeValue::where('name', $name)->first();
        return response()->json($normative);
    }

}
