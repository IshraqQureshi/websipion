<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth;
use App\Models\PaymentDetails;
use App\Models\User;
use App\Models\Websites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Dompdf\Dompdf;


class TransactionHistory extends Controller
{
    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }

    public function index(Request $request)
    {
        addVendors(['dataTables', 'payment-history']);
        return view('dashboard.payment-history', ['title' => 'Transaction History']);
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {




            if(auth()->user()->role == 1 ){

                $data = PaymentDetails::whereHas('GetUser',function($query)
            {
                $query->where('role','!=','3');

            })->with('Getpackage', 'GetUser')->latest()->get();


            }elseif(auth()->user()->role == 3){
                $data = PaymentDetails::with('Getpackage', 'GetUser')->latest()->get();
            }
            else{
                $data = PaymentDetails::where('userID', auth()->user()->id)->with('Getpackage', 'GetUser')->latest()->get();
            }

            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('userID', function ($row) {
                        $name = $row->GetUser->name;
                        $email = $row->GetUser->email;
                        return "
                            <div class='d-flex align-items-center'>
                            <div class='me-2 position-relative'>
                                <div class='symbol symbol-35px symbol-circle'>
                                    <i class='bi bi-person-circle fs-2'></i>
                                </div>
                            </div>
                            <div class='d-flex flex-column justify-content-center'>
                                <a
                                    class='mb-1 text-gray-800 text-hover-primary'>$email</a>
                                <div class='fw-semibold fs-6 text-black-400'>$name</div>
                            </div>
                        </div>
                    ";
                })

                ->editColumn('packagesID', function ($row) {
                    $packages = $row->Getpackage->packageName ?? '';
                    return "<span class='badge bg-info  fw-bold px-3 py-1'>$packages</span>";
                })

                ->editColumn('transactionTime', function ($row) {
                    return date('d-m-Y : h:i:s A', $row->transactionTime);
                 })

                 ->addColumn('action', function ($row) {
                    return "<div class='btn-group' role='group' aria-label='Basic example'>
                        <a href='".route('invoice', ['type' => 'download', 'id' => $row->id])."' class='btn btn-primary rounded'>
                            <i class='bi bi-cloud-arrow-down-fill'></i>
                        </a>
                        <a href='".route('invoice', ['type' => 'print', 'id' => $row->id])."' class='btn btn-primary rounded mx-2'>
                            <i class='bi bi-printer'></i>
                        </a>
                    </div>
                ";
                })
                ->rawColumns(['userID', 'packagesID', 'invoiceNumber', 'transactionID', 'totalPayment', 'paymentMode', 'transactionTime', 'action'])
                ->make(true);
        }
    }

    public function invoice( string $type, int $invoice_id ){

        $payment = PaymentDetails::find($invoice_id);
        $user = User::find($payment->userID);

        if( $type == 'download' && $invoice_id ){
            $html = View::make('dashboard.invoice', ['title' => 'invoice', 'payment' => $payment, 'user' => $user])->render();
            // Create a new instance of Dompdf
            $pdf = new Dompdf();

            // Load HTML into Dompdf
            $pdf->loadHtml($html);

            // Set paper size and orientation
            $pdf->setPaper('A4', 'landscape');

            // Render PDF
            $pdf->render();

            // Set the response headers to download the PDF file
            return $pdf->stream('invoice_'.time().'.pdf');
        }

        if( $type == 'print' && $invoice_id ){
            return view('dashboard.invoice', ['title' => 'invoice', 'payment' => $payment, 'user' => $user]);
        }
    }




}
