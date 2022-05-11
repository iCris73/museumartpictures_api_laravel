<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Artpictures;
use Illuminate\Support\Facades\DB;

class ArtController extends Controller
{
    protected $time;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->time = time();
        if (!auth()->check()) {
            return response()->json(
                $this->getResultResponse(401, ['error' => 'Unauthorized']),
                401
            );
        }
        # filtering records
        if ($request && (@$request->fields || @$request->filters)) {
            $filters = [];
            $fields = [];
            $query = DB::table('artpictures');
            if (@$request->fields) {
                $fields = explode(',', trim($request->fields));
                $query = $query->select($fields);
            }
            if (
                @$request->filters &&
                is_array($request->filters) &&
                count($request->filters) > 0
            ) {
                foreach ($request->filters as $k => $v) :
                    $key = preg_replace('([^A-Za-z])', '', trim($k));
                    $value = preg_replace('([^A-Za-z])', '', trim($v));
                    $filters[$key] = $value;
                    $query = $query->where($key, "like", "%{$value}%");
                endforeach;
            }
            $query = $query->get();
            return response()->json(
                $this->getResultResponse(200, $query),
                200
            );
        }
        # list all records
        return response()->json(
            $this->getResultResponse(200, Artpictures::all()),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->time = time();
        if (!auth()->check()) {
            return response()->json(
                $this->getResultResponse(401, ['error' => 'Unauthorized']),
                401
            );
        }
        $validator = validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'painter' => 'required|string|max:50',
            'country' => 'required|string|max:20',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $this->getResultResponse(400, $validator->errors()->toJson()),
                400
            );
        }
        $artPicture = new Artpictures();
        $artPicture->name = $request->name;
        $artPicture->painter = $request->painter;
        $artPicture->country = $request->country;
        $artPicture->save();
        return response()->json(
            $this->getResultResponse(200, $artPicture),
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->time = time();
        if (!auth()->check()) {
            return response()->json(
                $this->getResultResponse(401, ['error' => 'Unauthorized']),
                401
            );
        }
        $validator = validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'painter' => 'required|string|max:50',
            'country' => 'required|string|max:20',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $this->getResultResponse(400, $validator->errors()->toJson()),
                400
            );
        }
        $artPicture = Artpictures::findOrFail($request->id);
        $artPicture->name = $request->name;
        $artPicture->painter = $request->painter;
        $artPicture->country = $request->country;
        $artPicture->save();
        return response()->json(
            $this->getResultResponse(200, $artPicture),
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(
                $this->getResultResponse(401, ['error' => 'Unauthorized']),
                401
            );
        }
        Artpictures::destroy($request->id);
    }

    protected function getResultResponse($code, $message)
    {
        return [
            'code' => $code,
            'date' => date('c', $this->time),
            'elapsed' => $this->getDuration($this->time, time()),
            'message' => $message,
        ];
    }

    /**
     * Converts the difference between two timestamps to a representative string
     * @param integer $timeOne
     * @param integer $timeTwo
     * @return string
     */
    protected function getDuration(int $timeOne, int $timeTwo)
    {
        $time = abs($timeTwo - $timeOne);
        $hours = intval($time / 3600);
        $minutes = intval(($time - $hours * 3600) / 60);
        $segundos = $time - $minutes * 60;
        $time = null;
        if ($hours) {
            if ($hours > 1) {
                $txt = 'horas';
            } else {
                $txt = 'hora';
            }
            $time[] = sprintf('%s %s', $hours, $txt);
        }
        if ($minutes) {
            if ($minutes > 1) {
                $txt = 'minutos';
            } else {
                $txt = 'minuto';
            }
            $time[] = sprintf('%s %s', $minutes, $txt);
        }
        if ($segundos) {
            if ($segundos < 1) {
                $segundos = round($segundos, 3);
            }
            if ($segundos > 1) {
                $txt = 'segundos';
            } else {
                $txt = 'segundo';
            }
            $time[] = sprintf('%s %s', $segundos, $txt);
        }
        if ($time) {
            return implode(', ', $time);
        }
        return '0 segundos';
    }
}
