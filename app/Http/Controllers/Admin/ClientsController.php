<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\PaymentDetails;
use App\Models\User;
use App\Models\Websites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ClientsController extends Controller
{

    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }

    public function index(Request $request)
    {
        addVendors(['dataTables', 'clients']);
        return view('dashboard.clients-list', ['title' => 'Clients List']);
    }

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->role == 3) :
            $data = User::latest()->get();
            elseif (auth()->user()->role == 1):
                $data = User::where('role','!=',3)->latest()->get();
            else:
            $data = User::where('id',auth()->user()->id)->latest()->get();
            endif;
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return "<div class='d-flex align-items-center'>
                                <div class='me-3 position-relative'>
                                    <div class='symbol symbol-35px symbol-circle'>
                                        <i class='bi bi-person-circle fs-2'></i>
                                    </div>
                                </div>
                                <div class='d-flex flex-column justify-content-center'>
                                    <a href='" . route('profile', $row->id) . "' class='mb-1 text-gray-800'>{$row->name}</a>
                                    <div class='fw-semibold fs-6 text-black-400'>{$row->email}</div>
                                </div>
                        </div>";
                })

                ->editColumn('role', function ($row) {
                    if ($row->role == 1) {
                        $role = "<span class='badge bg-success fw-bold px-3 py-1'>Admin</span>";
                    } elseif ($row->role == 2) {
                        $role = "<span class='badge bg-info fw-bold px-3 py-1'>Client</span>";
                    }
                    elseif ($row->role == 3) {
                        $role = "<span class='badge bg-info fw-bold px-3 py-1'>Super Admin</span>";
                    }
                    return $role;
                })

                ->editColumn('status', function ($row) {
                    if ($row->status == 1) {
                        $status = "<span name='$row->id' class='badge bg-success user-status fw-bold px-3 py-1'>Active</span>";
                    } elseif ($row->status == 2) {
                        $status = "<span name='$row->id' class='badge bg-danger user-status fw-bold px-3 py-1'>Inactive</span>";
                    }
                    return $status;
                })

                ->addColumn('action', function ($row) {
                    return "<div class='btn-group' role='group' aria-label='Basic example'>
                                <a href='javascript:vaid(0)' data-id='$row->id' data-role='$row->role'  data-name='$row->name'  data-email='$row->email' data-mobile='$row->mobile' class='btn btn-primary EditClient rounded'>
                                    <i class='bi bi-pencil-square'></i>
                                </a>

                                <button type='button' class='btn btn-danger client-delete ms-2 rounded' id='$row->id'>
                                    <i id='$row->id' class='bi bi-trash3-fill client-delete'></i>
                                </button>
                            </div>
                        ";
                })
                ->rawColumns(['name', 'role', 'mobile', 'status', 'action'])
                ->make(true);
        }
    }


    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'mobile' => ['required', 'numeric', 'digits_between:10,15'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => [
                'required',
                'string',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }



        $request = $request->all();
        $request['role'] = $request['inlineRadioOptions'];
        $request['password'] = Hash::make($request['password']);
        if (auth()->user()->role == 1 || auth()->user()->role == 3) {
            User::Create($request);
        }
        return response()->json(['status' => 200, 'msg' => 'Create successfully']);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'mobile' => ['required', 'numeric', 'digits_between:10,15'],
            'email' => ['required', 'string', 'email',  Rule::unique('users', 'email')->ignore($request->id, 'id')],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }


        $user = User::find($request->id); // Assuming you have the user ID
        $data = $request->only(['name', 'email', 'mobile']); // Specify the fields you want to update
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password); // Update the password if it exists in the request
        }
        $data['role'] = $request->inlineRadioOptions;
        if (auth()->user()->role == 1 || auth()->user()->role == 3) {
            $user->update($data); // Update the user model with the provided data
        }
        return response()->json(['status' => 200, 'msg' => 'Updated successfully']);
    }

    public function delete(Request $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 3) {
            $User = User::find($request->id);
            $User->delete();
        }
        return response()->json(['status' => 200, 'msg' => 'Deleted successfully']);
    }

    public function status(Request $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 3) {
            $User = User::find($request->id);
            $User->status = $request->statusValue == 'Active' ? 2 : 1;
            $User->save();
        }
        return response()->json(['msg' => $request->statusValue == 'Active' ? 'Inactive' : 'Active']);
    }

    public function profile(Request $request)
    {
        $website = Websites::where('ownerID', '=', $request->id)->get();
        $paymentdetails = PaymentDetails::where('userID', '=', $request->id)->with('Getpackage')->get();

        $User = User::find($request->id);
        return view('dashboard.profile', ['title' => 'Profile', 'user' => $User, 'website' => $website, 'paymentdetails' => $paymentdetails]);
    }

    public function edit(Request $request)
    {
        $User = User::find($request->id);
        $country = Country::all();
        addVendors(['profile-edit', 'select2']);
        return view('dashboard.profile-edit', ['title' => 'Profile Edit', 'user' => $User, 'country' => $country]);
    }

    public function saveProfile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'mobile' => ['required', 'numeric', 'digits_between:10,15'],
            'email' => ['required', 'string', 'email',  Rule::unique('users', 'email')->ignore($request->id, 'id')],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }

        $id = $request->post('id');
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->zipCode = $request->zipCode;
        $user->gstNumber = $request->gstNumber;

        if (!empty($request->password)) {
            $user->password = hash::make($request->password);
        }
        if (auth()->user()->role == 1 || auth()->user()->role == 3) {
            $user->save();
        }
        return response()->json(['msg' => 'Updated successfully', 'url' => route('EditProfile', $id)]);
    }
}
