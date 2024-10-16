<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBedRequest;
use App\Models\BedModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BedModelController extends Controller
{
    public function index()
    {
        return view('pages.bed');
    }

    public function get_bed_data(Request $request)
    {
        $bed= BedModel::select('bed_models.*')
                        ->orderBy('created_at', 'desc');
        return DataTables::eloquent($bed)
                    ->filter(function ($query) use ($request) {
                if ($request->has('name')) {
                    $query->where('name', 'like', "%{$request->get('name')}%");
                }

            })
             ->editColumn('status', function ($bed) {
                return $bed->is_deleted ? '<span class="badge bg-danger p-2">InActive</span>' : '<span class="badge bg-primary p-2">Active</span>';
            })
             ->editColumn('occupancy', function ($bed) {
                return $bed->is_active ? '<div class="badge bg-dangerbp-2">Occupied</span>' : '<span class="badge bg-secondary p-2">Unoccupied</span>';
            })
             ->addColumn('action', function ($bed) {
                return '<div class="btn-group">'.
                '<a type="button" class="btn btn-outline-primary">'.'Edit Bed'.'</a>'.
                '<a type="button" class="btn btn-outline-primary">'.'Delete'.'</a>'.
                '</div>';
            })
            ->setRowId(function ($bed) {
                return "row_".$bed->id;
            })
            ->rawColumns(['occupancy','status','action'])
            ->make(true);

    }

    public function create()
    {
        return view('pages.create_bed');
    }

    public function store(CreateBedRequest $request)
    {
        $data = $request->all();
        $bed = BedModel::create($data);

        return redirect()->to(route('bed.index'));

    }

    public function update(CreateBedRequest $request, BedModel $bedModel){
        $data= $request->all();
        $bedModel->update($data);

        return redirect(route('bed.index'));
    }

    public function delete(BedModel $bedModel)
    {
        $bedModel->update([
            'is_deleted' => 1
        ]);
        return redirect(route('bed.index'));
    }

    public function show(BedModel $bedModel)
    {
        return view('pages.bed_model_show', [
            'data' => $bedModel
        ]);
    }

}
