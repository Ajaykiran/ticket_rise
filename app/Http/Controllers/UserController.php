<?php

namespace App\Http\Controllers;

use App\events\mailhandling;
use App\Http\Requests\UserStore;
use App\Models\excel_data;
use App\Models\Userinfos;
use Event;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UserController extends Controller
{
    public function __construct()
    {
        //  $this->middleware('permission:detail-list|detail-create|detail-edit|detail-delete', ['only' => ['index']]);
        //  $this->middleware('permission:detail-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:detail-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:detail-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->role == 'staff') {
            if ($request->ajax()) {
                $data = userinfos::whereBetween('created_at', [$request->from_date, date('Y-m-d', strtotime($request->to_date.'+1 day'))])->get();
                // dd(date('Y-m-d',strtotime($request->to_date. '+1 day')));
                return \Datatables::of($data)
                    ->addColumn('action', function ($row) {
                        $btn1 = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="fa fa-edit btn btn-primary btn-sm edit" style="font-size:15px"></i></a>';
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="fa fa-trash btn btn-danger btn-sm delete" style="font-size:15px"></a>';

                        return $btn1.$btn;
                    })

                    ->addColumn('img_file', function ($row) {
                        $img_file = '';
                        $url = asset("storage/assets/images/$row->file");
                        $img_file .= '<img src='.$url.' class="rounded-circle" alt="organization_logo" width="100" height="100" align="center" />';

                        return $img_file.'';
                    })

                    ->rawColumns(['action', 'img_file'])
                    ->addIndexColumn()
                    ->make(true);
            }
        } else {
            if ($request->ajax()) {
                $data = userinfos::orderby('name', 'asc')->get();

                return \Datatables::of($data)
                    ->addColumn('action', function ($row) {
                        $btn1 = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="fa fa-edit btn btn-primary btn-sm edit" style="font-size:15px"></i></a>';
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="fa fa-trash btn btn-danger btn-sm delete" style="font-size:15px"></a>';

                        return $btn1.$btn;
                    })

                    ->addColumn('img_file', function ($row) {
                        $img_file = '';
                        $url = asset("storage/assets/images/$row->file");
                        $img_file .= '<img src='.$url.' class="rounded-circle" alt="organization_logo" width="100" height="100" align="center" />';

                        return $img_file.'';
                    })

                    ->rawColumns(['action', 'img_file'])
                    ->addIndexColumn()
                    ->make(true);
            }
        }
    }

    // delete
    public function destroy($id)
    {
        userinfos::find($id)->delete();

        return response()->json(['success' => ' deleted successfully.']);
    }

    // edit
    public function edit($id)
    {
        $data = userinfos::find($id);

        return response()->json($data);
    }

    // update
    public function update(Request $request)
    {
        $image = $request->image;
        $image_name = time().'_'.$image->getClientOriginalName();
        $image->storeAs('public/assets/images', $image_name);
        userinfos::updateOrCreate([
                    'id' => $request->id,
                ],
            [
                'name' => $request->name,
                'email' => $request->email,
                'birth_date' => $request->birth_date,
                'phone' => $request->phone,
                'qualification' => $request->qualification,
                'gender' => $request->gender,
                'address' => $request->address,
                'file' => $image_name,
            ]);
        // return response()->json(['success'=>'Product saved successfully.']);
        return back();
    }

    // store data
    public function store(UserStore $request)
    {
        $file = $request->file('image');
        $spreadsheet = IOFactory::load($file->getRealPath());
        // dd($spreadsheet);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        $isFirstRow = true;
        foreach ($rows as $row) {
            if ($isFirstRow) {
                $isFirstRow = false;
                continue; // Skip the first row
            }

            $existingData = excel_data::where('name', $row[0])
                             ->where('degree', $row[1])
                             ->first();
            if (!$existingData) {
                excel_data::create([
                    'name' => $row[0],
                    'degree' => $row[1],
                ]);
            }
        }
        // dd($request->sports);
        $image = $request->image;
        $image_name = time().'_'.$image->getClientOriginalName();
        $image->storeAs('public/assets/images', $image_name);

        $user = new userinfos();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->birth_date = $request->birth_date;
        $user->phone = $request->phone;
        $user->qualification = $request->qualification;

        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->file = $image_name;
        // event(new mailhandling($user));
        $data = $request->sports;
        $sportsData = [];
        foreach ($data as $index => $sports) {
            $uniqueKey = 'sports_'.($index + 1);
            $sportsData[$uniqueKey] = $sports;
        }
        $user->sports = json_encode($sportsData);
        $user->save();

        return response()->json($user);
    }

/**
 * Check if the array is associative or indexed.
 *
 * @return bool
 */
private function isAssoc(array $array)
{
    return array_keys($array) !== range(0, count($array) - 1);
}

    public function role()
    {
        if (auth()->user()->role == 'student') {
            return redirect('use');
        } elseif (auth()->user()->role == 'staff') {
            return view('form');
        } else {
            return abort(403);
        }
    }
}
