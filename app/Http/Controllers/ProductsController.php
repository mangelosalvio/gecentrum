<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Products;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class ProductsController extends Controller
{

    public function  __construct(){
        $this->middleware('auth');

        $Categories = Categories::orderBy('category_name')->lists('category_name','id');
        return view()->share(compact(['Categories']));
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
            $Products = Products::orWhere('product_name','like',$keyword.'%')
                ->orWhere('product_code','like',$keyword.'%')
                ->orderBy('product_name');
        } else {
            $Products = Products::orderBy('product_name');
        }

        $Products = $Products->paginate();

        return view('products.products_search', compact(['Products']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Product = new Products();
        return view('products.products_edit', compact(['Product']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /**
         * Limit to only 10 Products
         */

        /*if ( Products::count() > 10 && !$request->has('id') ) {
            $status = 'The Demo version is only limited to 10 Products. Please contact <b>Michael Salvio</b> at <b>09435158936</b> for the Full Version';
            return redirect('/products')->with(compact(['status']));
        }*/

        if ( $request->input('action') == 'Delete' ) {
            Products::find($request->input('id'))->delete();
            $status = 'Transaction Deleted';
            return redirect("/products")->with(compact('status'));
        }

        $arr_validation  = [
            'product_name' => 'required',
            'product_cost' => 'numeric'
        ];

        if ( !$request->has('id') ) {
            $arr_validation['product_code'] = "required|unique:products";
        } else {
            $arr_validation['product_code'] = "required|unique:products,product_code,".$request->input('id');
        }



        $this->validate($request,$arr_validation);

        if ( !$request->has('id') ) {
            $Product = Products::create($request->all());
            $status = "Transaction Saved";
        } else {
            $Product = Products::find($request->input('id'));
            $Product->update($request->all());

            $Product->has_serial_no = $request->input('has_serial_no',0);
            $Product->save();
            $status = "Transaction Updated";
        }

        return redirect("/products/$Product->id/edit")->with(compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Product = Products::findOrNew($id);
        return view('products.products_edit', compact(['Product']));
    }

    public function search()
    {
        return Products::where('product_name','like',"%".Input::get('q')."%")
            ->orWhere('product_code','like','%'.Input::get('q').'%')
            ->selectRaw("*, concat(product_code, ' | ', product_name) content")
            ->get()->toJson();
    }

}
