<?php

namespace App\Http\Controllers;

use App\Enums\MediaCollection;
use App\Http\Requests\NftCard\DestroyNftCardRequest;
use App\Http\Requests\NftCard\IndexNftCardRequest;
use App\Http\Requests\NftCard\ShowNftCardRequest;
use App\Http\Requests\NftCard\StoreNftCardRequest;
use App\Http\Requests\NftCard\UpdateNftCardRequest;
use App\Http\Resources\NftCardCollection;
use App\Http\Resources\NftCardResource;
use App\Models\NftCard;

class NftCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexNftCardRequest $request)
    {
        return new NftCardCollection($request->user()->nftCards()->active()->with('media')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNftCardRequest $request)
    {
        /** @var NftCard $model */
        $model = $request->user()->nftCards()->create([
            'name' => $request->input('name'),
            'collection' => $request->input('collection'),
        ]);

        $model->addMedia($request->file('image'))
            ->toMediaCollection(MediaCollection::IMAGES->value);

        return response()->json();
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowNftCardRequest $request, NftCard $card)
    {
        return new NftCardResource($card);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNftCardRequest $request, NftCard $card)
    {
        $card->update([
            'name' => $request->get('name'),
            'collection' => $request->get('collection'),
        ]);

        $card->clearMediaCollection(MediaCollection::IMAGES->value);

        $card->addMedia($request->file('image'))
            ->toMediaCollection(MediaCollection::IMAGES->value);

        return new NftCardResource($card);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyNftCardRequest $destroyNftCardRequest, NftCard $card)
    {
        $resource = new NftCardResource($card->toArray());

        $card->delete();

        return $resource;
    }
}
