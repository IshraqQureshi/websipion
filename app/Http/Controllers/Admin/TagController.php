<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }

    public function index(Request $request)
    {
        addVendors(['dataTables', 'tag']);
        return view('dashboard.tags', ['title' => __('site.tags-page.title')]);
    }

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            if(auth()->user()->role == 3 || auth()->user()->role == 1){
                $data = Tag::latest()->get();
            }else{
                $data = Tag::where('user_id', auth()->user()->id)->latest()->get();
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return   "<span class='badge bg-success fw-bold px-3 py-1'>$row->name</span>";
                })
                ->addColumn('action', function ($row) {
                    return "<div class='btn-group' role='group' aria-label='Basic example'>
                                <a href='javascript:vaid(0)' data-id='$row->id'  data-name='$row->name' class='btn btn-primary EditTags rounded'>
                                    <i class='bi bi-pencil-square'></i>
                                </a>

                                <button type='button' class='btn btn-danger tag-delete ms-2 rounded' id='$row->id'>
                                    <i id='$row->id' class='bi bi-trash3-fill tag-delete'></i>
                                </button>
                            </div>
                        ";
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
        }
    }


    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required', 'string',
                Rule::unique('tags', 'name')->where(function ($query) use ($request) {
                    return $query->where('user_id', auth()->user()->id);
                })->ignore($request->id, 'id'),
            ],
        ]);

        $customMessages = [
            'name.required' => 'The tag name field is required.',
        ];
        $validator->setCustomMessages($customMessages);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }

        $request['user_id'] = auth()->user()->id;
        Tag::updateOrCreate(
            [
                'id'   => $request->id ?? '',
            ],
            $request->all()
        );

        $msg = $request->id == '' ? 'Tag created successfully...' : 'Tag Updated successfully...';

        return response()->json(['status' => 200, 'msg' => $msg]);
    }

    public function delete(Request $request)
    {
        $Tag = Tag::find($request->id);
        $Tag->delete();
        return response()->json(['status' => 200, 'msg' => 'Deleted successfully']);
    }
}
