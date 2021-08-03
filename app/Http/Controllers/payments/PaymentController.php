<?php

namespace App\Http\Controllers\payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * View Form to user for details
     */
    public function checkout() {
        return view('payments.checkout');
    }

    /**
     * Hit SecurePayment API and redirect user to returned URL
     */
    public function payment(Request $request) {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:100'
        ]);
        $data = $request->all();
        $response = resolve('payment')->makePayment($data);
        return redirect($response);
    }

    /**
     * Webhook called after payment success by third party bank service
     */
    public function payment_notification(Request $request) {
        $data = $request->all();
    }
}
