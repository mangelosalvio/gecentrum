<?php

namespace App\Http\Controllers;

use App\PhysicalCountDetails;
use App\PhysicalCounts;
use App\Products;
use App\Warehouses;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class PhysicalCountsController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

        $Warehouses = Warehouses::orderBy('warehouse_name')->lists('warehouse_name','id');
        $Products = Products::orderBy('product_name')->lists('product_name','id');

        return view()->share(compact([
            'Warehouses',
            'Products'
        ]));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $keyword = Input::get('search','');

        if ( !empty( $keyword ) ) {
            $PhysicalCounts = PhysicalCounts::orWhere('date','like',$keyword.'%')
                ->orderBy('date');
        } else {
            $PhysicalCounts = PhysicalCounts::orderBy('id','desc');
        }

        $PhysicalCounts = $PhysicalCounts->paginate();

        return view('physical_counts.physical_counts_search', compact(['PhysicalCounts']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $PhysicalCounts = new PhysicalCounts();
        return view('physical_counts.physical_counts_edit', compact(['PhysicalCounts']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ( $request->input('action') == 'Delete' ) {
            PhysicalCounts::find($request->input('id'))->delete();
            $status = 'Transaction Deleted';
            return redirect("/physical_counts")->with(compact('status'));
        }

        $arr_validation  = [
            'warehouse_id' => 'required'
        ];

        if ( !$request->has('id') ) {
            $arr_validation['date'] = "required|unique:physical_counts,date,NULL,id,warehouse_id,".$request->get('warehouse_id');
        } else {
            $arr_validation['date'] = "required|unique:physical_counts,date,".$request->get('id').",id,warehouse_id,".$request->get('warehouse_id');
        }

        $arr_messages = [
            'warehouse_id.required' => 'Select a Warehouse'
        ];

        $this->validate($request, $arr_validation, $arr_messages);

        if ( !$request->has('id') ) {
            $PhysicalCounts = PhysicalCounts::create($request->all());
            $status = "Transaction Saved";
        } else {
            $PhysicalCounts = PhysicalCounts::find($request->input('id'));
            $PhysicalCounts->update($request->all());
            $status = "Transaction Updated";
        }

        return redirect("/physical_counts/$PhysicalCounts->id/edit")->with(compact('status'));
    }

    public function addProduct($id, Request $request)
    {
        $arr_validation = [
            'product_id' => 'required|unique:physical_count_details,product_id,NULL,id,deleted_at,NULL,physical_count_id,' . $id,
            'quantity' => 'required|numeric'
        ];


        $arr_messages = [
            'product_id.required' => 'Select a product',
            'product_id.unique' => 'Product can only be used once'
        ];

        $this->validate($request,$arr_validation,$arr_messages);

        PhysicalCounts::findOrNew($id)
            ->products()->attach($request->input('product_id'),[
                'quantity' => $request->input('quantity')
            ]);

        $status = 'Product added';

        return redirect("/physical_counts/$id/edit")->with(compact('status'));
    }

    public function deleteDetail($id)
    {

        $PhysicalCounts = PhysicalCountDetails::findOrNew($id)->PhysicalCounts;
        PhysicalCountDetails::findOrNew($id)->delete();
        $status = 'Detail Deleted';

        return redirect("/physical_counts/$PhysicalCounts->id/edit")->with(compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $PhysicalCounts = PhysicalCounts::findOrNew($id);
        return view('physical_counts.physical_counts_edit', compact(['PhysicalCounts']));
    }
}
