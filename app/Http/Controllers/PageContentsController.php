<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageContents;
use App\Http\Requests\StorePageContentsRequest;
use App\Http\Requests\UpdatePageContentsRequest;
use App\Http\Resources\PageContentsResource;

class PageContentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $position = $request->position ?? "";

        $results = PageContents::where('position', 'like', "%$position%")->get();

        return PageContentsResource::collection($results);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePageContentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePageContentsRequest $request)
    {
        $image = $request->file('image')->store('pageImages') ?? null;

        return PageContents::create([
            ...$request->all(),
            "image" => $image
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PageContents  $pageContents
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return PageContents::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePageContentsRequest  $request
     * @param  \App\Models\PageContents  $pageContents
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePageContentsRequest $request, $id)
    {
        $pageContents = PageContents::find($id);

        $image = $request->file('image')?->store('pageImages') ?? $pageContents->image ?? null;

        if(!$pageContents) {
            PageContents::create([
                ...$request->all(),
                "image" => $image
            ]);
        }
        else {
            $pageContents->update([
                ...$request->all(),
                "image" => $image
            ]);
        }

        return response()->json([
            "status" => "success",
            "title"  => "Update Successfull",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PageContents  $pageContents
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PageContents::find($id)->delete();

        return response()->json([
            "status" => "success",
            "title"  => "Delete Successfull",
        ], 200);
    }
}
