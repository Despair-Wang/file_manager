<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\PermissionArea;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    private function makeJson($state, $data = null, $msg = null)
    {
        return response()->json(['state' => $state, 'data' => $data, 'msg' => $msg])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Area::get();
        return $this->makeJson(1, $areas, null);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('area.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = Area::create(['name' => $request->name]);
        if ($result->id == '') {
            return $this->makeJson(0, $result, null);
        }
        PermissionArea::create(['permission_id' => 0, 'area_id' => $result->id]);
        return $this->makeJson(1, $result->id, null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = Area::Where('id', $id)->first();
        if (is_null($result)) {
            return $this->makeJson(0, null, 'NO_DATA');
        }
        return $this->makeJson(1, $result, null);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $area = Area::Where('id', $id)->first();
        if (is_null($area)) {
            return redirect()->intended(route('dashboard'));
        }
        return view('area.edit', compact('area'));
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
        $result = Area::Where('id', $id)->first();
        if (is_null($result)) {
            return $this->makeJson(0, null, 'NO_DATA');
        }
        $result = $result->update(['name' => $request->name]);
        if (!$result) {
            return $this->makeJson(0, $result, 'UPDATE_ERROR');
        } else {
            return $this->makeJson(1, null, null);
        }
    }

    public function addPermission(Request $request, Area $id)
    {
        if (!is_null($id)) {
            $id = $id->id;
            $permissions = $request->permissions;
            if ($permissions != '' || is_null($permissions)) {
                foreach ($permissions as $p) {
                    $result = PermissionArea::create(['permission_id' => $p, 'area_id' => $id]);
                    if (!$result) {
                        return $this->makeJson(0, $result, 'ADD_PERMISSION_ERROR');
                    }
                }
                return $this->makeJson(1, null, null);
            }
        } else {
            return $this->makeJson(0, null, 'NO_DATA');
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
        $result = Area::Where('id', $id)->first();
        if (is_null($result)) {
            return $this->makeJson(0, null, 'NO_DATA');
        }
        $result = $result->delete();
        if (!$result) {
            return $this->makeJson(0, $result, 'DELETE_ERROR');
        } else {
            return $this->makeJson(1, null, null);
        }

    }
}