<?php

namespace App\Http\Controllers;

use App\Enums\PostProjectStatus;
use App\Models\payment;
use App\Models\PostProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;


class PaymentController extends Controller
{
     public function index()
     {
          return view('front.clients.projects');
     }

     public function prePaymentValidation(Request $request){
          $session_total = session('total');
          $total = $request->input('total');
          if (floatval($total) != floatval($session_total)) {
               return response()->json(['Price Discrepancy']);
          }
          return response()->json([
               'successful_validation' => 'success',
          ],200);
     }

     /**
      * @throws Throwable
      */
     public function fulfillOrder(Request $request, $postProjectId)
    {
         $postProject = PostProject::query()->where('client_id', auth()->user()->id)->where('id', $postProjectId)->firstOrFail();
         DB::transaction(function () use ($request, $postProject) {
              $total = $request->input('total');
              Payment::query()->create([
                   'transaction_id'  => $request->transaction_id,
                   'paid_by'         => auth()->user()->id,
                   'paid_to'         => $postProject->freelancer_id,
                   'post_project_id' => $postProject->id,
                   'amount'          => $total,
              ]);
              $postProject->update([
                   'status' => PostProjectStatus::COMPLETED,
              ]);
         });
         return redirect()->route('clients.post-projects')->with('toast.success', 'Payment created!!');
    }

    public function success(Request $request)
    {
        try {
            $response = $this->gateway->completePurchase([
                'payer_id' => $request->PayerID,
                'payment_id' => $request->paymentId,
                'token' => $request->token,
                'amount' => $request->amount,
                'currency' => env('PAYPAL_CURRENCY', 'USD'),
            ])->send();

            if ($response->isSuccessful()) {
                return 'Payment was successful!';
            } else {
                return 'Payment was not successful!';
            }
        } catch ( Throwable $th) {
            return $th->getMessage();
        }
    }

}
