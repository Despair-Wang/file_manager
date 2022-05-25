<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\File;
use App\Models\PermissionArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    private function makeJson($state, $data = null, $msg = null)
    {
        return response()->json(['state' => $state, 'data' => $data, 'msg' => $msg])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    private function check($file_id)
    {
        return File::rightJoin('permission_area', 'file.Authorized_area', '=', 'permission_area.area_id')->Where('file.id', $file_id)->Where('permission_area.permission_id', Auth::user()->permission_id)->first();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::leftJoin('permission_area', 'file.authorized_area', '=', 'permission_area.area_id')->Where('permission_area.permission_id', Auth::user()->permission_id)->get();
        return $this->makeJson(1, $files, null);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = PermissionArea::Where('permission_id', Auth::user()->permission_id)->get();
        return view('file.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->name == '') {
            return $this->makeJson(0, null, 'NO_NAME');
        }

        $result = File::create([
            'name' => $request->name,
            'content' => $request->content,
        ]);
        if ($result->id == '') {
            return $this->makeJson(0, $result, 'CREATE_ERROR');
        } else {
            return $this->makeJson(1, $result->id, null);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = $this->check($id);
        if (is_null($file)) {
            return $this->makeJson(0, null, 'NO_DATA');
        }
        return $this->makeJson(1, $file, null);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $file = $this->check($id);
        if (is_null($file)) {
            return redirect()->intended(route('dashboard'));
        }
        return view('file.edit', compact('file'));
    }

    public function changeArea($id)
    {
        $file = $this->check($id);
        $areas = Area::get();
        if (is_null($file)) {
            return redirect()->intended(route('dashboard'));
        }
        return view('file.changeArea', compact('file', 'areas'));

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
        $file = $this->check($id);
        if (is_null($file)) {
            return $this->makeJson(0, null, 'NO_DATA');
        } else {
            $params = $request->only('name', 'content', 'authorized_area');
            $result = $file->update($params);
            if (!$result) {
                return $this->makeJson(0, $result, 'UPDATE_ERROR');
            } else {
                return $this->makeJson(1, null, null);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = $this->check($id);
        if (is_null($file)) {
            return $this->makeJson(0, null, 'NO_DATA');
        } else {
            $result = $file->update(['status' => 0]);
            if (!$result) {
                return $this->makeJson(0, $result, 'DELETE_ERROR');
            } else {
                return $this->makeJson(1, null, null);
            }
        }
    }
}