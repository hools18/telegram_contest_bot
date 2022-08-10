<?php

namespace App\Http\Controllers\Panel\Contest;

use App\Http\Requests\Panel\Contest\ContestDeleteRequest;
use App\Http\Requests\Panel\Contest\ContestImageUpdateRequest;
use App\Http\Requests\Panel\Contest\ContestUpdateRequest;
use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContestController
{
    public function index()
    {
        return view('panel.contest.index', [
            'contests' => Contest::withCount('members')->latest()->get()
        ]);
    }

    public function create()
    {
        $contest = Contest::create([
            'user_id' => Auth::id()
        ]);

        return redirect()->route('panel.contest.edit', $contest);
    }

    public function edit(Contest $contest)
    {
        return view('panel.contest.edit', ['contest' => $contest]);
    }

    public function update(ContestUpdateRequest $request, Contest $contest)
    {
        $contest->fill($request->all());
        $contest->save();
        if ($request->image) {
            $contest->addMedia($request->image)->usingName(md5_file($request->image->getRealPath()))
                ->usingFileName($request->image->hashName())->toMediaCollection('image');
        }
        return redirect()->back()->with('success', 'Конкурс успешно обновлён');

    }

    public function delete(ContestDeleteRequest $request)
    {
        $contest = Contest::find($request->contest_id);
        $contest->clearMediaCollection('image');
        $contest->delete();
        return response()->json([
            'message' => 'Конкурс удалён'
        ]);
    }

    public function updateImage(ContestImageUpdateRequest $request, Contest $contest)
    {
        $contest->clearMediaCollection('image');
        $media = $contest->addMedia($request->image)->usingName(md5_file($request->image->getRealPath()))
            ->usingFileName($request->image->hashName())->toMediaCollection('image');

        return response()->json([
            'image' => $media->getUrl('thumb_1200')
        ]);
    }

    public function deleteImage(Contest $contest)
    {
        $contest->clearMediaCollection('image');

        return response()->json([
            'message' => 'Изображение удалено',
        ]);
    }

    public function members_index(Contest $contest)
    {
        return view('panel.contest.members.index', [
            'contest' => $contest
        ]);
    }

}
