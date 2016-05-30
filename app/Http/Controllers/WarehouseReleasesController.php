<?php

namespace App\Http\Controllers;

use App\Customers;
use App\Products;
use App\Suppliers;
use App\WarehouseReleaseDetails;
use App\WarehouseReleases;
use App\Warehouses;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class WarehouseReleasesController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

        $Suppliers = Suppliers::orderBy('supplier_name')->lists('supplier_name','id');
        $Products = Products::orderBy('product_name')->lists('product_name','id');
        $Customers = Customers::orderBy('customer_name')->lists('customer_name','id');

        return view()->share(compact([
            'Suppliers',
            'Products',
            'Customers'
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
            $WarehouseReleases = WarehouseReleases::orWhere('date','like',$keyword.'%')
                ->orderBy('date');
        } else {
            $WarehouseReleases = WarehouseReleases::orderBy('id','desc');
        }

        $WarehouseReleases = $WarehouseReleases->paginate();

        return view('warehouse_releases.warehouse_releases_search', compact(['WarehouseReleases']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $WarehouseReleases = new WarehouseReleases();
        return view('warehouse_releases.warehouse_releases_edit', compact(['WarehouseReleases']));
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
            WarehouseReleases::find($request->input('id'))->delete();
            $status = 'Transaction Deleted';
            return redirect("/warehouse_releases")->with(compact('status'));
        }

        $arr_validation  = [
            'date' => 'required',
            'from_warehouse_id' => 'required',
            'to_warehouse_id' => 'required'
        ];

        $arr_messages = [
            'date.required' => 'Enter Date',
            'from_warehouse_id.required' => 'Select a Sending Warehouse',
            'to_warehouse_id.required' => 'Select a Recipient Warehouse'
        ];

        $this->validate($request, $arr_validation, $arr_messages);

        if ( !$request->has('id') ) {
            $WarehouseReleases = WarehouseReleases::create($request->all());
            $status = "Transaction Saved";
        } else {
            $WarehouseReleases = WarehouseReleases::find($request->input('id'));
            $WarehouseReleases->update($request->all());
            $status = "Transaction Updated";
        }

        return redirect("/warehouse_releases/$WarehouseReleases->id/edit")->with(compact('status'));
    }

    public function addProduct($id, Request $request)
    {
        $arr_validation = [
            'product_id' => 'required',
            'quantity' => 'required|numeric'
        ];

        $arr_messages = [
            'product_id.required' => 'Select a product'
        ];

        $this->validate($request,$arr_validation,$arr_messages);

        WarehouseReleases::findOrNew($id)
            ->products()->attach($request->input('product_id'),[
                'quantity' => $request->input('quantity')
            ]);

        $status = 'Product added';

        return redirect("/warehouse_releases/$id/edit")->with(compact('status'));
    }

    public function deleteDetail($id)
    {

        $WarehouseReleases = WarehouseReleaseDetails::findOrNew($id)->WarehouseRelease;
        WarehouseReleaseDetails::findOrNew($id)->delete();
        $status = 'Detail Deleted';

        return redirect("/warehouse_releases/$WarehouseReleases->id/edit")->with(compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $WarehouseReleases = WarehouseReleases::findOrNew($id);
        return view('warehouse_releases.warehouse_releases_edit', compact(['WarehouseReleases']));
    }
}
