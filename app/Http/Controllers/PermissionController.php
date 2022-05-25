<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
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
        $permissions = Permission::get();
        return $this->makeJson(1, $permissions, null);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permission');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = Permission::create(['name' => $request->name]);
        if ($result->id == '') {
            return $this->makeJson(0, $result, null);
        }
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
        $result = Permission::Where('id', $id)->first();
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
        $permission = Permission::Where('id', $id)->first();
        if (is_null($permission)) {
            return redirect()->intended(route('dashboard'));
        }
        return view('permission.edit', compact('permission'));
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
        $result = Permission::Where('id', $id)->first();
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Permission::Where('id', $id)->first();
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