<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = Input::get('search','');

        if ( !empty( $keyword ) ) {
            $Categories = Categories::orWhere('category_name', 'like', $keyword.'%')
                ->orderBy('category_name');
        } else {
            $Categories = Categories::orderBy('category_name');
        }

        $Categories = $Categories->paginate();

        return view('categories.categories_search', compact(['Categories']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Category = new Categories();
        return view('categories.categories_edit', compact(['Category']));
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
            Categories::find($request->input('id'))->delete();
            $status = 'Transaction Deleted';
            return redirect("/categories")->with(compact('status'));
        }

        $arr_validation = [];
        if ( !$request->has('id') ) {
            $arr_validation['category_name'] = "required|unique:categories";
        } else {
            $arr_validation['category_name'] = "required|unique:categories,category_name,".$request->input('id');
        }

        $this->validate($request,$arr_validation);

        if ( !$request->has('id') ) {
            $Category = Categories::create($request->all());
            $status = "Transaction Saved";
        } else {
            $Category = Categories::find($request->input('id'));
            $Category->update($request->all());
            $status = "Transaction Updated";
        }

        return redirect("/categories/$Category->id/edit")->with(compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Category = Categories::findOrNew($id);
        return view('categories.categories_edit', compact(['Category']));
    }
}
